<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;

class AddCurrency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a Currency into the database.';

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
        $name = $this->ask('What is the currency name?');
        $short_name = $this->ask('What is the currency short name?');
        $symbol = $this->ask('What is the currency symbol?');

        if ($this->confirm(sprintf('Do you want to create the currency: %s?', $name) , true)) {
            $currency = new Currency();
            $currency->name = $name;
            $currency->short_name = $short_name;
            $currency->symbol = $symbol;

            $currency->save();
            $this->info(sprintf('Currency «%s» created!', $name));
        } else {
            $this->warn(sprintf('Operation to create currency «%s» has been cancelled!', $name));
        }
    }
}
