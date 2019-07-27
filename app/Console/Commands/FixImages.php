<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;

class FixImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix images, run only once!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::where('text', 'like', '%<img %')->get();

        foreach ($posts as $post) {
            $this->info('Post: "' . $post->header . '" has image');

            preg_match("~<img [^>]+>~si", $post->text, $matches);
            foreach ($matches as $m) {
                $this->info('Match img: ' . $m);
            }
        }

        $this->info('Posts with images: ' . $posts->count());
    }
}
