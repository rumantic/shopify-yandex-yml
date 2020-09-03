<?php

namespace App\Http\Controllers;

use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple;
use Bukashk0zzz\YmlGenerator\Model\Category;
use Bukashk0zzz\YmlGenerator\Model\Currency;
use Bukashk0zzz\YmlGenerator\Model\Delivery;
use Bukashk0zzz\YmlGenerator\Model\ShopInfo;
use Bukashk0zzz\YmlGenerator\Settings;
use Bukashk0zzz\YmlGenerator\Generator;
use Faker;

class ProductController extends Controller
{
    private $faker;

    public function index() {
        $shop = Auth::user();
        $domain = $shop->getDomain()->toNative();
        Log::info("Shop {$domain} call");

        //$shopApi = $shop->api()->rest('GET', '/admin/products.json');

        //Log::info("Shop {$domain}'s object:" . json_encode($shop));
        //Log::info("Shop {$domain}'s API objct:" . json_encode($shopApi));
        $guid = $this->get_xml_guid();
        $yml_link = config('app.url').'/yml?guid='.$guid;
        return view('home', compact('yml_link'));
    }

    private function get_xml_guid() {
        return md5('test');

    }

    public function generator () {
        $this->faker = Faker\Factory::create();
        //$this->faker = new Faker\Generator();

        // $file = tempnam(sys_get_temp_dir(), 'YMLGenerator');
        $file = 'd:/tmp/generator.xml';
        $settings = (new Settings())
            ->setOutputFile($file)
            ->setEncoding('UTF-8')
        ;

        // Creating ShopInfo object (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#shop)
        $shopInfo = (new ShopInfo())
            ->setName('BestShop')
            ->setCompany('Best online seller Inc.')
            ->setUrl('http://www.best.seller.com/')
        ;

        // Creating currencies array (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#currencies)
        $currencies = [];
        $currencies[] = (new Currency())
            ->setId('USD')
            ->setRate(1)
        ;

        // Creating categories array (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#categories)
        $categories = [];
        $categories[] = (new Category())
            ->setId(1)
            ->setName($this->faker->name)
        ;

        // Creating offers array (https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#offers)
        $offers = [];
        $offers[] = (new OfferSimple())
            ->setId(12346)
            ->setAvailable(true)
            ->setUrl('http://www.best.seller.com/product_page.php?pid=12348')
            ->setPrice($this->faker->numberBetween(1, 9999))
            ->setCurrencyId('USD')
            ->setCategoryId(1)
            ->setDelivery(false)
            ->setName('Best product ever')
        ;

        // Optional creating deliveries array (https://yandex.ru/support/partnermarket/elements/delivery-options.xml)
        $deliveries = [];
        $deliveries[] = (new Delivery())
            ->setCost(2)
            ->setDays(1)
            ->setOrderBefore(14)
        ;

        (new Generator($settings))->generate(
            $shopInfo,
            $currencies,
            $categories,
            $offers,
            $deliveries
        );
        return view('test');
    }
}
