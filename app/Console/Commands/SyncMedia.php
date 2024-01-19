<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SyncMedia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $images = Media::all();

        $bar = $this->output->createProgressBar(count($images));

        $bar->start();

        foreach ($images as $image) {
            \Log::info('Image id: ' . $image->id);

            \Artisan::call('media-library:regenerate', [
                '--ids' => $image->id,
                '--only-missing' => true,
                '--force' => true
            ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
