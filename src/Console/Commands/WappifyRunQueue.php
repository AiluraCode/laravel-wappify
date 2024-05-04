<?php

namespace AiluraCode\Wappify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class WappifyRunQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wappify:queue';

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
        $this->info('Running queue');
        Artisan::queue('queue:work', [
            '--queue' => config('wappify.queue'),
            '--tries' => config('wappify.tries'),
            '--timeout' => config('wappify.timeout'),
            '--name' => config('wappify.name'),
        ]);
    }
}
