<?php

namespace App\Jobs;

use App\Models\Page;
use App\Models\Price;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class TrackPage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $page;

    /**
     * Create a new job instance.
     *
     * @param Page $page
     * @return void
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Open a Puppeteer window
        $puppeteer = new Puppeteer;
        $browser = $puppeteer->launch();
        $page = $browser->newPage();
        $page->goto($this->page->url);

        // Process XPath prices
        $normal_price_xpath = $this->page->normal_price_regex ? $this->page->normal_price_regex : $this->page->store->default_normal_price_regex;
        $normal_prices = $page->querySelectorXPath($normal_price_xpath);
        $normal_price_value = is_countable($normal_prices) && count($normal_prices) > 0 ? $normal_prices[0]->evaluate(JsFunction::createWithParameters(['el'])->body("return el.textContent")) : null;
        $normal_price_value = self::process_price_value($normal_price_value);

        $discounted_price_xpath = $this->page->discounted_price_regex ? $this->page->discounted_price_regex : $this->page->store->default_discounted_price_regex;
        $discounted_prices = $page->querySelectorXPath($discounted_price_xpath);
        $discounted_price_value = is_countable($discounted_prices) && count($discounted_prices) > 0 ? $discounted_prices[0]->evaluate(JsFunction::createWithParameters(['el'])->body("return el.textContent")) : null;
        $discounted_price_value = self::process_price_value($discounted_price_value);

        $special_price_xpath = $this->page->special_price_regex ? $this->page->special_price_regex : $this->page->store->default_special_price_regex;
        $special_prices = $page->querySelectorXPath($special_price_xpath);
        $special_price_value = is_countable($special_prices) && count($special_prices) > 0 ? $special_prices[0]->evaluate(JsFunction::createWithParameters(['el'])->body("return el.textContent")) : null;
        $special_price_value = self::process_price_value($special_price_value);

        $all_prices = array_filter([$normal_price_value, $discounted_price_value, $special_price_value]);

        // Close Chrome
        $browser->close();

        // Create new price into the database
        $price = new Price;
        $price->page_id = $this->page->id;
        $price->product_id = $this->page->product_id;
        $price->store_id = $this->page->store_id;
        $price->normal_price = $normal_price_value;
        $price->discounted_price = $discounted_price_value;
        $price->special_price = $special_price_value;
        $price->lowest_price = !empty($all_prices) ? min($all_prices) : null;
        $price->save();

        return $price;
    }

    public static function process_price_value($value, string $currency_short_name = 'PEN')
    {
        if ($value === null) {
            return null;
        }

        $numeric_value = 0;
        switch ($currency_short_name) {
            case 'PEN':
                $numeric_value = preg_replace('/[^0-9.]/', '', $value);
                break;

            default:
                $numeric_value = preg_replace('/[^0-9.]/', '', $value);
                break;
        }

        return $numeric_value;
    }
}
