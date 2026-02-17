<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact()
    {
        return view('frontend.contact');
    }

    public function requestForm(?string $serviceSlug = null)
    {
        $service = null;
        if ($serviceSlug) {
            $service = Service::where('slug',$serviceSlug)->first();
        }
        $services = Service::where('status','active')->orderBy('title')->get();
        return view('frontend.request', compact('services','service'));
    }

    public function submitRequest(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'applicant_name' => 'required|string|max:150',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'message' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:2048',
        ]);

        // Create request first
        $serviceRequest = ServiceRequest::create([
            'service_id' => $data['service_id'],
            'applicant_name' => $data['applicant_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'] ?? null,
            'status' => 'submitted',
        ]);

        // Handle multiple attachments (optional)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file) continue;
                $path = $file->store('attachments', 'public');
                $serviceRequest->attachments()->create([
                    'path' => $path,
                    'label' => null,
                ]);
            }
        }

        return back()->with('success', 'Permohonan Anda telah dikirim.');
    }
}