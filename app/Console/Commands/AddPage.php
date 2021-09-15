<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\Page;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Console\Command;

class AddPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:page {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a product page into the database.';

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
        $url = $this->argument('url');

        // Select the Store
        if (Store::where('domain', parse_url($url, PHP_URL_HOST))->count() > 0) {
            $store_id = Store::where('domain', parse_url($url, PHP_URL_HOST))->first()->id;
        } else {
            $store_search = $this->anticipate('What is the Store?', function ($input) {
                return Store::where('domain', 'like', '%'.$input.'%')->pluck('domain')->toArray();
            });
            $store_id = Store::where('domain', $store_search)->first()->id;
        }

        // Select the Product
        $product_search = $this->anticipate('What is the Product?', function ($input) {
            return Product::where('name', 'like', '%'.$input.'%')->pluck('name')->toArray();
        });
        $product_id = Product::where('name', $product_search)->first()->id;

        // Select the Currency
        $currency_search = $this->anticipate('What is the Currency?', function ($input) {
            return Currency::where('short_name', 'like', '%'. strtoupper($input))->pluck('short_name')->toArray();
        });
        $currency_id = Currency::where('short_name', $currency_search)->first()->id;

        // Save the page into the Database
        if ($this->confirm('Do you want to create the page?', true)) {
            $page = new Page();
            $page->url = $url;
            $page->store_id = $store_id;
            $page->product_id = $product_id;
            $page->currency_id = $currency_id;
            $page->save();

            $this->info('Page created!');
        } else {
            $this->warn('Operation to create page has been cancelled!');
        }
    }
}
