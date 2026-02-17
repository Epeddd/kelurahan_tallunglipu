<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle too-large uploads gracefully
        $this->renderable(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            if ($request->is('admin/slides*')) {
                return back()->withInput()->withErrors([
                    'image' => 'File terlalu besar. Maksimal 10MB. Silakan pilih file yang lebih kecil atau kompres gambar.',
                ]);
            }
        });
    }
}
