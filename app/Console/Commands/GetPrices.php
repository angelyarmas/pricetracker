<?php

namespace App\Console\Commands;

use App\Jobs\TrackPage;
use App\Models\Page;
use Illuminate\Console\Command;

class GetPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the prices for all the products pages.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pages = Page::all();

        foreach ($pages as $page) {
            TrackPage::dispatch($page);
        }
    }
}
