<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Site;

class ListSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grapple:list {site?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve a list of sites from the remote grapple';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tableBody = [];
        if ($this->argument('site')) {
            $site = Site::query()->where('name', $this->argument('site'))->first();

            $response = Http::get(env('GRAPPLE_MANAGER_URL') . '/site/' . $site->id . '/deployments');

            $deployments = json_decode($response);

            foreach($deployments as $deploy) {
                $tableBody[] = [ $deploy->id, $this->argument('site'), $deploy->status ? 'True' : 'False', $deploy->commit, $deploy->branch];
            }

            $this->table(
                ['Id', 'Site Name', 'Live', 'Commit', 'Branch'],
                $tableBody
            );

            return;
        }

        $response = Http::get(env('GRAPPLE_MANAGER_URL') . '/site');
        $sites = json_decode($response);
        foreach($sites as $site) {
            $tableBody[] = [ $site->name, $site->repo_url ];
        }

        $this->table(
            ['Site Name', 'Repo'],
            $tableBody
        );
    }
}
