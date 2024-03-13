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
    protected $signature = 'grapple:new {name} {--repo=}';

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
        $status = json_decode($response, true);

        switch ($status) {
            case 409:
                $this->error('Site already exists');
                return;
            case 500:
                $this->error('Site creation failed');
                return;
            case 201:
                $this->info('Site ' . $data['name'] . ' created');
                break;
        }
    }
}
