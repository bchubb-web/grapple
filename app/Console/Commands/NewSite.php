<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use App\Models\Site;

class NewSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grapple:new {name} {--repo=} {?deploy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new site within grapple';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $data = [
            'name' => $this->argument('name'),
            'repo_url' => $this->option('repo'),
        ];

        $this->line('Creating ' . $data['name']);

        $response = Http::post(env('GRAPPLE_MANAGER_URL') . '/site', $data);
        if (200 !== $response->status()) {
            $this->error('Site creation failed');
            return;
        }
        $sites = json_decode($response);
        $this->info('Site ' . $data['name'] . ' created');
    }
}
