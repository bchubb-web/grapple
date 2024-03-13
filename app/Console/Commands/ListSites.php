<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ListSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grapple:list';

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
        $response = Http::get(env('GRAPPLE_MANAGER_URL') . '/site');
        $sites = json_decode($response);
        foreach($sites as $site) {
            $tableBody[] = [$site->name];
        }

        $this->table(
            ['Site Name'],
            $tableBody
        );
    }
}
