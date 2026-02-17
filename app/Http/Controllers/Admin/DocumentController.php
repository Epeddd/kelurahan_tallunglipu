<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function edit()
    {
        // Read current files (if exist)
        $profilKepala = file_exists(public_path('files/profil-kepala-dinas.pdf'));
        $strukturOrg  = file_exists(public_path('files/struktur-organisasi.pdf'));
        return view('admin.documents.edit', compact('profilKepala','strukturOrg'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profil_kepala_pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            'struktur_org_pdf'  => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Ensure folder exists
        $targetDir = public_path('files');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        if ($request->hasFile('profil_kepala_pdf')) {
            $request->file('profil_kepala_pdf')->move($targetDir, 'profil-kepala-dinas.pdf');
        }
        if ($request->hasFile('struktur_org_pdf')) {
            $request->file('struktur_org_pdf')->move($targetDir, 'struktur-organisasi.pdf');
        }

        return back()->with('status','Dokumen berhasil diperbarui');
    }
}