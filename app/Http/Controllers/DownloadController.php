<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download(Resource $resource)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to download resources.');
        }

        // Record download history
        Download::create([
            'user_id' => Auth::id(),
            'resource_id' => $resource->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Increment download count
        $resource->increment('download_count');

        return redirect()->back()->with('success', 'Download recorded! (File download would start here)');
    }
}