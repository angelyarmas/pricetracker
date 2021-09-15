<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class AddProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new Product into the database.';

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
        $name = $this->ask('What is the product name?');
        $description = $this->ask('What is the product description?');

        if ($this->confirm(sprintf('Do you want to create the product: %s?', $name) , true)) {
            $product = new Product;
            $product->name = $name;
            $product->description = $description;

            $product->save();
            $this->info(sprintf('Product «%s» created!', $name));
        } else {
            $this->warn(sprintf('Operation to create product «%s» has been cancelled!', $name));
        }
    }
}
