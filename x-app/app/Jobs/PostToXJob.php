<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\XPost;
use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Log;

class PostToXJob implements ShouldQueue
{
    use Queueable;

    private $post;

    /**
     * Create a new job instance.
     */
    public function __construct(XPost $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Setup connection
            $connection = new TwitterOAuth(
                config('services.x.api_key'),
                config('services.x.api_secret'),
                config('services.x.access_token'),
                config('services.x.access_token_secret')
            );
            $connection->setApiVersion('2');

            $mediaIds = [];
            if ($this->post->images && count($this->post->images) > 0) {
                Log::info('Processing images: ' . json_encode($this->post->images));

                // Media upload MUST use API v1.1
                $connectionV1 = new TwitterOAuth(
                    config('services.x.api_key'),
                    config('services.x.api_secret'),
                    config('services.x.access_token'),
                    config('services.x.access_token_secret')
                );
                $connectionV1->setApiVersion('1.1');

                foreach ($this->post->images as $imagePath) {
                    $fullPath = Storage::disk('public')->path($imagePath);
                    Log::info('Uploading image: ' . $fullPath . ' (Exists: ' . (file_exists($fullPath) ? 'Yes' : 'No') . ')');

                    if (!file_exists($fullPath)) {
                        continue;
                    }

                    $media = $connectionV1->upload('media/upload', ['media' => $fullPath]);

                    Log::info('Upload status: ' . $connectionV1->getLastHttpCode());
                    Log::info('Upload response: ' . json_encode($media));

                    if ($connectionV1->getLastHttpCode() != 200) {
                        Log::error('Upload failed with body: ' . json_encode($connectionV1->getLastBody()));
                    }

                    if (isset($media->media_id_string)) {
                        $mediaIds[] = $media->media_id_string;
                    }
                }
                Log::info('Media IDs: ' . json_encode($mediaIds));
            }

            $params = ['text' => $this->post->content];
            if (count($mediaIds) > 0) {
                $params['media'] = ['media_ids' => $mediaIds];
            }

            // API v2 requires JSON payload
            $result = $connection->post('tweets', $params); // @phpstan-ignore-line

            if ($connection->getLastHttpCode() == 201) {
                $this->post->update(['status' => 'posted']);
            } else {
                throw new Exception('X API Error: ' . json_encode($result));
            }
        } catch (Exception $e) {
            $this->post->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
