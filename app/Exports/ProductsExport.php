<?php

namespace App\Exports;

use App\Http\Resources\Product as ProductResource;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    use Exportable;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function view(): View
    {

        $products =  Product::with(['prices', 'providers', 'relates'])
            ->filter($this->params['name'] ?? null)
            ->type($this->params['type'] ?? null)
            ->get();

        $products = $products->map(function ($product) {
           $price = $product->price->sale_price ?? $product->prices[0]->sale_price;
           return [
                'code' => $product->code,
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->gettype(),
                'measure' => $product->measure->name,
                'price' =>  number_format($price, 2)
           ];
        });

        return view('exports.products', [
            'products' => $products
        ]);
    }
}
