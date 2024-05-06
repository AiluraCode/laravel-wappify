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
    protected $description = 'Run the queue for whatsapp messages.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Run command: php artisan queue:listen --queue=whatsapp --tries=1 --timeout=60 --name=wappify');
        $this->line('Running queue');
        Artisan::call('queue:listen', [
            '--queue' => config('wappify.queue.name'),
            '--tries' => config('wappify.queue.tries'),
            '--timeout' => config('wappify.queue.timeout'),
            '--name' => config('wappify.queue.name'),
        ]);
    }
}
