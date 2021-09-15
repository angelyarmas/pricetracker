<?php

namespace App\Console\Commands;

use App\Models\Store;
use Illuminate\Console\Command;

class AddStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new Store into the database.';

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
        $name = $this->ask('What is the store name?');
        $domain = $this->ask('What is the store domain?');
        $default_normal_price_regex = $this->ask('Input the normal price regex');
        $default_discounted_price_regex = $this->ask('Input the discounted price regex');
        $default_special_price_regex = $this->ask('Input the special price regex');

        if ($this->confirm(sprintf('Do you want to create the store: %s?', $name) , true)) {
            $store = new Store();
            $store->name = $name;
            $store->domain = $domain;
            $store->default_normal_price_regex = $default_normal_price_regex;
            $store->default_discounted_price_regex = $default_discounted_price_regex;
            $store->default_special_price_regex = $default_special_price_regex;

            $store->save();
            $this->info(sprintf('Store «%s» created!', $name));
        } else {
            $this->warn(sprintf('Operation to create store «%s» has been cancelled!', $name));
        }
    }
}
