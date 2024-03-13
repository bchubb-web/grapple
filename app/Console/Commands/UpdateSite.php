<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class UpdateSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grapple:update {site}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a site to latest deployment';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $site = $this->argument('site');
        $this->line('updating ' . $site);
        $response = Http::put(env('GRAPPLE_MANAGER_URL') . "/site/{$site}", []);
        if (200 !== $response->status()) {
            $this->error('Error updating ' . $site);
            return;
        }
        $this->info('Updating ' . $site . ' initialised');

    }
}
