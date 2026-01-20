<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\XPost;
use App\Jobs\PostToXJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class XPostController extends Controller
{
    public function index()
    {
        return view('x-post.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:280',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'images' => 'max:4',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('x-posts', 'public');
                $imagePaths[] = $path;
            }
        }

        $post = XPost::create([
            'content' => $validated['content'],
            'images' => $imagePaths,
            'scheduled_at' => $validated['scheduled_at'] ? Carbon::parse($validated['scheduled_at']) : null,
            'status' => $validated['scheduled_at'] ? 'scheduled' : 'posted', // Will update if job fails
        ]);

        if (!$validated['scheduled_at']) {
            PostToXJob::dispatch($post);
        }

        return redirect()->back()->with('success', 'Post ' . ($validated['scheduled_at'] ? 'scheduled' : 'queued') . ' successfully!');
    }
}
