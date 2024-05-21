<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

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
     *
     * @return void
     */
    public function handle(): void
    {
        $name = Config::get('wappify.queue.name');
        $tries = Config::get('wappify.queue.tries');
        $timeout = Config::get('wappify.queue.timeout');
        $this->line('Running queue');
        Artisan::call('queue:listen', [
            '--queue'   => $name,
            '--tries'   => $tries,
            '--timeout' => $timeout,
            '--name'    => $name,
        ]);
    }
}
