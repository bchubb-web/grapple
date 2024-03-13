<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use App\Models\Site;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grapple:deploy {site} {--b|branch=main} {--c|commit=HEAD}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new deployment for a site within grapple';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $site = Site::query()->where('name', $this->argument('site'))->first();

        $deployment = [
            'site_id' => $site->id,
            'commit' => $this->option('commit'),
            'branch' => $this->option('branch'),
            'live' => true,
        ];


        $this->line('Deploying ' . $site->name);

        $response = Http::post(env('GRAPPLE_MANAGER_URL') . '/deploy', $deployment);
        $status = json_decode($response, true);
        switch ($response->status()) {
            case 500:
                $this->error('Deployment failed');
                return;
            case 201:
                $this->info('Site deployed');
                break;
            default:
                $this->info($response->status() . '\n' . $response->body());
                break;
        }
    }
}
