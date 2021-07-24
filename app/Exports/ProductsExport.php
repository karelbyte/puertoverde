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

        return view('exports.products', [
            'products' => $products
        ]);
    }
}
