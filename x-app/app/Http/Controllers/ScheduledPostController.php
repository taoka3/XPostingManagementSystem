<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\XPost;

class ScheduledPostController extends Controller
{
    public function index()
    {
        $posts = XPost::where('status', 'scheduled')
            ->orderBy('scheduled_at', 'asc')
            ->get();
        return view('x-post.scheduled', compact('posts'));
    }

    public function destroy(XPost $post)
    {
        if ($post->status !== 'scheduled') {
            return redirect()->back()->with('error', 'Only scheduled posts can be deleted.');
        }

        $post->delete();
        return redirect()->back()->with('success', 'Scheduled post deleted.');
    }
}
