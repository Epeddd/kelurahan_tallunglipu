<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $items = ServiceRequest::with('service')->latest()->paginate(20);
        return view('admin.service_requests.index', compact('items'));
    }

    public function show(ServiceRequest $service_request)
    {
        return view('admin.service_requests.show', ['item' => $service_request->load('service')]);
    }

    public function updateStatus(Request $request, ServiceRequest $service_request)
    {
        $data = $request->validate([
            'status' => 'required|in:submitted,in_review,completed,rejected',
        ]);
        $service_request->update($data);
        return back()->with('success','Status diperbarui');
    }

    public function destroy(ServiceRequest $service_request)
    {
        $service_request->delete();
        return redirect()->route('admin.service-requests.index')->with('success','Data dihapus');
    }
}