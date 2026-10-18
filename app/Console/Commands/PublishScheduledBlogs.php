<?php

namespace App\Console\Commands;

use App\Models\Blog;
use Illuminate\Console\Command;

class PublishScheduledBlogs extends Command
{
    protected $signature = 'blogs:publish-scheduled';

    protected $description = 'Publish scheduled blogs whose publish time has arrived';

    public function handle(): int
    {
        $count = Blog::query()
            ->where('status', 'schedule')
            ->where('time_publish', '<=', now())
            ->update(['status' => 'publish']);

        $this->info("Published {$count} scheduled blog(s).");

        return self::SUCCESS;
    }
}
