<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Price;
use Illuminate\Http\Request;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class TestController extends Controller
{
    public function testroute(Request $request)
    {
        $price = Price::find(4);
        return $price;

        // $url = 'https://simple.ripley.com.pe/seagate-barracuda-disco-duro-interno-hdd-para-computadoras-portatiles-de-escritorio-embalaje-sin-frustracion-pmp00000980881?color80_fijo=negro&s=o';
        // $puppeteer = new Puppeteer;

        // $browser = $puppeteer->launch();
        // $page = $browser->newPage();
        // $page->goto($url);

        // $normal_prices = $page->querySelectorXPath("//div[contains(@class, 'product-normal-price')]/dt");
        // $discounted_prices = $page->querySelectorXPath("//div[contains(@class, 'product-internet-price')]/dt");
        // $special_prices = $page->querySelectorXPath("//div[contains(@class, 'product-ripley-price')]/dt");


        // // Get the "viewport" of the page, as reported by the page.
        // $dimensions = array(
        //     'normal_price' => is_countable($normal_prices) && count($normal_prices) > 0 ? $normal_prices[0]->evaluate(JsFunction::createWithParameters(['el'])->body("return el.textContent")) : null,
        //     'discounted_price' => is_countable($discounted_prices) && count($discounted_prices) > 0 ? $discounted_prices[0]->evaluate(JsFunction::createWithParameters(['el'])->body("return el.textContent")) : null,
        //     'special_price' => is_countable($special_prices) && count($special_prices) > 0 ? $special_prices[0]->evaluate(JsFunction::createWithParameters(['el'])->body("return el.textContent")) : null,
        // );

        // // printf('Dimensions: %s', print_r($dimensions, true));

        // $browser->close();

        // return $dimensions;
    }
}
