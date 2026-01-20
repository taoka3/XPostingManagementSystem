<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DispatchScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'x:dispatch-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch scheduled posts to X';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = \App\Models\XPost::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($posts as $post) {
            \App\Jobs\PostToXJob::dispatch($post);
        }

        $this->info('Dispatched ' . $posts->count() . ' posts.');
    }
}
