<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductProvider;
use App\Models\Provider;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory()->count(50)->make();
        $provider = Provider::all();
        $priceUpPercent  = Setting::first()->currentPricePercent;

        $products->each(function ($product) use ($provider,  $priceUpPercent) {
            $providers = $provider->random(rand(1,3));
            $product =  Product::create($product->getAttributes());
            foreach ($providers as $prodiver) {
                ProductProvider::create([
                    'product_id' => $product->id,
                    'provider_id' => $prodiver->id
                ]);
            }
            $fakePrice = rand(100, 200) / 2;
            $productPrice = ProductPrice::create([
                'product_id' => $product->id,
                'price' =>  $fakePrice,
                'percent_apply' =>  $priceUpPercent,
                'sale_price' => $fakePrice + (($fakePrice * $priceUpPercent) / 100)
            ]);
            $product->price_id =  $productPrice->id;
            $product->provider_id =  $providers->first()->id;
            $product->save();
        });
    }
}
