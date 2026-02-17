<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\InfografisController as FrontInfografisController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BeritaController as FrontBeritaController;
use App\Http\Controllers\Frontend\AgendaController as FrontAgendaController;
use App\Http\Controllers\Frontend\ServiceController as FrontServiceController;
use App\Http\Controllers\Frontend\GalleryController as FrontGalleryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', function(){
    $q = request('q');
    $results = collect();

    if ($q) {
        // Cari berita published
        $berita = \App\Models\Berita::where('status','published')
            ->where(function($w) use ($q){
                $w->where('title','like',"%{$q}%")
                  ->orWhere('excerpt','like',"%{$q}%")
                  ->orWhere('content','like',"%{$q}%");
            })->selectRaw("'berita' as type, slug as id, title as title, published_at as date, null as extra")
            ->get();

        // Cari layanan aktif
        $layanan = \App\Models\Service::where('status','active')
            ->where(function($w) use ($q){
                $w->where('title','like',"%{$q}%")
                  ->orWhere('description','like',"%{$q}%");
            })->selectRaw("'layanan' as type, slug as id, title as title, null as date, null as extra")
            ->get();

        // Cari agenda published
        $agenda = \App\Models\Agenda::where('status','published')
            ->where(function($w) use ($q){
                $w->where('title','like',"%{$q}%")
                  ->orWhere('description','like',"%{$q}%");
            })->selectRaw("'agenda' as type, id as id, title as title, start_date as date, location as extra")
            ->get();

        $results = $berita->concat($layanan)->concat($agenda);
    }

    return view('frontend.search', compact('q','results'));
})->name('search');
Route::get('/berita', [FrontBeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [FrontBeritaController::class, 'show'])->name('berita.show');
Route::get('/agenda', [FrontAgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{id}', [FrontAgendaController::class, 'show'])->name('agenda.show');
Route::get('/layanan', [FrontServiceController::class, 'index'])->name('layanan.index');
Route::get('/layanan/{slug}', [FrontServiceController::class, 'show'])->name('layanan.show');
Route::get('/galeri', [FrontGalleryController::class, 'index'])->name('galeri.index');
Route::get('/kontak', [ContactController::class, 'contact'])->name('kontak');
// PJU/Infografis page
Route::get('/pju', [FrontInfografisController::class, 'index'])->name('pju.index');
Route::get('/permohonan', [ContactController::class, 'requestForm'])->name('permohonan.form');
Route::get('/permohonan/{serviceSlug}', [ContactController::class, 'requestForm'])->name('permohonan.form.service');
Route::post('/permohonan', [ContactController::class, 'submitRequest'])->name('permohonan.submit');

// Endpoint JSON data PJU (baca dari CSV public/files/pju.csv) + filter polygon torut.geojson jika tersedia
Route::get('/pju/data', function(){
    $points = [];
    $file = public_path('files/pju.csv');

    // Muat polygon Toraja Utara dari GeoJSON jika ada (MultiPolygon/Polygon)
    $polygons = [];
    $geoFile = public_path('files/torut.geojson');
    if (file_exists($geoFile)) {
        $geo = json_decode(file_get_contents($geoFile), true);
        if (isset($geo['type'])) {
            $type = $geo['type'];
            if ($type === 'FeatureCollection') {
                foreach ($geo['features'] ?? [] as $f) {
                    $geom = $f['geometry'] ?? null;
                    if (!$geom) continue;
                    if (($geom['type'] ?? '') === 'Polygon') {
                        foreach ($geom['coordinates'] as $ring) { $polygons[] = $ring; }
                    } elseif (($geom['type'] ?? '') === 'MultiPolygon') {
                        foreach ($geom['coordinates'] as $poly) { foreach ($poly as $ring) { $polygons[] = $ring; } }
                    }
                }
            } elseif ($type === 'Polygon') {
                foreach ($geo['coordinates'] as $ring) { $polygons[] = $ring; }
            } elseif ($type === 'MultiPolygon') {
                foreach ($geo['coordinates'] as $poly) { foreach ($poly as $ring) { $polygons[] = $ring; } }
            }
        }
    }

    // Ray casting untuk cek point-in-polygon (GeoJSON: [lng,lat])
    $pointInPolygon = function(float $lat, float $lng, array $ring): bool {
        $inside = false; $n = count($ring);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = (float)($ring[$i][1] ?? 0); // lat
            $yi = (float)($ring[$i][0] ?? 0); // lng
            $xj = (float)($ring[$j][1] ?? 0);
            $yj = (float)($ring[$j][0] ?? 0);
            $intersect = (($yi > $lng) != ($yj > $lng)) && ($lat < ($xj - $xi) * ($lng - $yi) / (max($yj - $yi, 1e-12)) + $xi);
            if ($intersect) $inside = !$inside;
        }
        return $inside;
    };

    // Helper: cek di salah satu ring (abaikan lubang untuk kesederhanaan)
    $isInsideAnyPolygon = function(float $lat, float $lng) use ($polygons, $pointInPolygon): bool {
        if (empty($polygons)) return false;
        foreach ($polygons as $ring) {
            if ($pointInPolygon($lat, $lng, $ring)) return true;
        }
        return false;
    };

    if (file_exists($file)) {
        $handle = fopen($file, 'r');
        if ($handle) {
            $firstLine = fgets($handle);
            if ($firstLine !== false) {
                $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';
                rewind($handle);
                $header = fgetcsv($handle, 0, $delimiter) ?: [];
                $index = [];
                foreach ($header as $i => $col) {
                    $index[strtolower(trim($col))] = $i;
                }
                while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                    $lat = null; $lng = null; $label = null;

                    // Cari kolom langsung: lat/lng atau latitude/longitude
                    foreach (["lat","latitude"] as $k) {
                        if (isset($index[$k])) { $val = trim((string)($row[$index[$k]] ?? '')); if ($val !== '' && is_numeric(str_replace([','], ['.'], $val))) { $lat = (float)str_replace([','], ['.'], $val); } break; }
                    }
                    foreach (["lng","lon","long","longitude"] as $k) {
                        if (isset($index[$k])) { $val = trim((string)($row[$index[$k]] ?? '')); if ($val !== '' && is_numeric(str_replace([','], ['.'], $val))) { $lng = (float)str_replace([','], ['.'], $val); } break; }
                    }

                    // Jika belum ada, parse dari kolom Tikor
                    if (($lat === null || $lng === null) && isset($index['tikor'])) {
                        $tikor = trim((string)($row[$index['tikor']] ?? ''));
                        if ($tikor !== '') {
                            if (preg_match_all('/-?\d+[\.,]?\d*/', $tikor, $m) && count($m[0]) >= 2) {
                                $lat = (float)str_replace(',', '.', $m[0][0]);
                                $lng = (float)str_replace(',', '.', $m[0][1]);
                            }
                        }
                    }

                    // Label opsional
                    foreach (["nama","name","lokasi","alamat","keterangan"] as $k) {
                        if (isset($index[$k])) { $label = trim((string)($row[$index[$k]] ?? '')); break; }
                    }

                    // Valid basic range
                    $valid = $lat !== null && $lng !== null && $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;

                    if ($valid) {
                        $keep = false;
                        if (!empty($polygons)) {
                            $keep = $isInsideAnyPolygon($lat, $lng);
                        } else {
                            // Fallback: bounding box approx Torut
                            $keep = $lat >= -3.3 && $lat <= -2.5 && $lng >= 119.6 && $lng <= 120.2;
                        }
                        if ($keep) {
                            $points[] = [ 'lat' => $lat, 'lng' => $lng, 'label' => $label ];
                        }
                    }
                }
                fclose($handle);
            } else { fclose($handle); }
        }
    }

    return response()->json($points);
})->name('pju.data');

// Profil pages (simple static for now)
Route::view('/profil/struktur', 'frontend.profil.struktur')->name('profil.struktur');
// Route::view('/profil/kepala', 'frontend.profil.kepala')->name('profil.kepala'); // disabled as requested
Route::get('/profil/tugas', [\App\Http\Controllers\Frontend\ProfileController::class, 'tugas'])->name('profil.tugas');

Route::get('/init-app', function(){
    \App\Models\User::updateOrCreate(
        ['email' => 'kel.tallunglipu'],
        [
            'name' => 'Kelurahan Tallunglipu',
            'password' => \Illuminate\Support\Facades\Hash::make('kel.tallunglipu46'),
            'is_admin' => true
        ]
    );

    \App\Models\User::updateOrCreate(
        ['email' => 'keltallunglipu'],
        [
            'name' => 'Admin Keltallunglipu',
            'password' => \Illuminate\Support\Facades\Hash::make('keltallunglipu46'),
            'is_admin' => true
        ]
    );

    // Initial data for infografis if empty
    if (\App\Models\Infografis::count() == 0) {
        $wilayahs = ["Bo'ne Randanan", "Bo'ne Limbong", "Bo'ne Matampu' Utara", "Bo'ne Matampu' Selatan"];
        foreach ($wilayahs as $w) {
            \App\Models\Infografis::create(['wilayah' => $w, 'penduduk_tetap' => 0, 'penduduk_non_tetap' => 0]);
        }
    }
    return "App Initialized. Accounts: kel.tallunglipu / kel.tallunglipu46 AND keltallunglipu / keltallunglipu46. Please login at /admin/login";
});

// Auth routes
Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [LoginController::class, 'login']);
Route::post('admin/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita'])->except(['show']);
    Route::post('berita/upload-image', [AdminBeritaController::class, 'uploadImage'])->name('berita.upload-image');
    Route::post('agenda/upload-image', [AdminAgendaController::class, 'uploadImage'])->name('agenda.upload-image');
    Route::resource('agenda', AdminAgendaController::class)->parameters(['agenda' => 'agendum'])->except(['show']);
    Route::resource('service-categories', AdminServiceCategoryController::class)->except(['show']);
    Route::resource('services', AdminServiceController::class)->except(['show']);
    Route::resource('slides', \App\Http\Controllers\Admin\SlideController::class)->except(['show']);
    Route::resource('gallery', AdminGalleryController::class)->except(['show']);

    // Tugas & Fungsi CRUD
    Route::resource('tugas', \App\Http\Controllers\Admin\TugasController::class)->parameters(['tugas' => 'tuga'])->except(['show']);

    // Housing stats (editable bar chart data + note + pie)
    Route::get('housing-stats', [\App\Http\Controllers\Admin\HousingStatController::class, 'index'])->name('housing-stats.index');
    Route::post('housing-stats', [\App\Http\Controllers\Admin\HousingStatController::class, 'store'])->name('housing-stats.store');
    Route::patch('housing-stats/{housing_stat}', [\App\Http\Controllers\Admin\HousingStatController::class, 'update'])->name('housing-stats.update');
    Route::delete('housing-stats/{housing_stat}', [\App\Http\Controllers\Admin\HousingStatController::class, 'destroy'])->name('housing-stats.destroy');
    Route::post('housing-note', [\App\Http\Controllers\Admin\HousingStatController::class, 'updateNote'])->name('housing-note.update');
    // Pie update
    Route::post('housing-pie', [\App\Http\Controllers\Admin\HousingStatController::class, 'updatePie'])->name('housing-pie.update');

    // Documents management (PDF uploads)
    Route::get('documents', [\App\Http\Controllers\Admin\DocumentController::class, 'edit'])->name('documents.edit');
    Route::post('documents', [\App\Http\Controllers\Admin\DocumentController::class, 'update'])->name('documents.update');

    // Infografis CRUD
    Route::resource('infografis', \App\Http\Controllers\Admin\InfografisController::class)->except(['show']);

    Route::get('service-requests', [AdminServiceRequestController::class, 'index'])->name('service-requests.index');
    Route::get('service-requests/{service_request}', [AdminServiceRequestController::class, 'show'])->name('service-requests.show');
    Route::patch('service-requests/{service_request}/status', [AdminServiceRequestController::class, 'updateStatus'])->name('service-requests.update-status');
    Route::delete('service-requests/{service_request}', [AdminServiceRequestController::class, 'destroy'])->name('service-requests.destroy');
});
