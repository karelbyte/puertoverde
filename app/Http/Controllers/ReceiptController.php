<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\Price;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductProvider;
use App\Models\ProductRelate;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ReceiptController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            $data = Receipt::with(['items', 'user'])
                     ->template($request->template)
                     ->filter($request->name)
                     ->type($request->type);

            list($take, $skip) = $this->getPagesConfig($request);
            $total = $data->select('*')->count();
            $list = $data->skip($skip)->take($take)->get();

            return  [
                'total' => $total,
                'data' => new ProductCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function store(Request $request)
    {
        try {
            $product = Product::create($request->all());

            $prices = $product->prices()->createMany($request->prices);
            $defaultPrice = $prices->filter(fn($price) => $price->default)->first();

            if (count($request->relates) > 0) {
                   $product->attachRelates($request->relates);
            }

            if (count($request->providers) > 0) {
                $product->attachProviders($request->providers);
                $defaultProvider = collect($request->providers)->first();
                $product->provider_id = $defaultProvider['id'];
            }

            $product->price_id = $defaultPrice->id;
            $product->save();

            $product->load('prices');
            $product->load('providers');
            $product->load('relates');

            return new ProductResource($product);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);

            $product->fill($request->all())->save();

            // Actualizando precios
            $prices = collect($request->prices);

            $pricesIds = $prices->filter(fn($price) => $price['created_at'] !== null)
                ->pluck('id')
                ->toArray();

            ProductPrice::where('product_id',$product->id)->whereNotIn('id', $pricesIds)->delete();

            $prices->each(function ($price) use ($product) {
                ProductPrice::updateOrCreate(
                    [
                        'id' => $price['id']
                    ],
                    [
                        'product_id' => $product->id,
                        'percent_apply' => $price['percent_apply'],
                        'price' => $price['price'],
                        'sale_price' => $price['sale_price'],
                        'default' =>  $price['default'],
                    ]
                );
            });


          // Actualizando Proveedores

            $providers = collect($request->providers);

            $providersIds = $providers->pluck('id')->toArray();

            ProductProvider::where('product_id', $product->id)->whereNotIn('provider_id', $providersIds)->delete();

            $providers->each(function ($provider) use ($product) {
                ProductProvider::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'provider_id' => $provider['id']
                    ],
                    [
                        'product_id' => $product->id,
                        'provider_id' => $provider['id']
                    ]
                );
            });

            // Actualizando Relacionados

            $relates = collect($request->relates);

            $relatesIds = $relates->pluck('id')->toArray();

            ProductRelate::where('product_id', $product->id)->whereNotIn('relate_id', $relatesIds)->delete();

            $relates->each(function ($relate) use ($product) {
               $relateGenerate =  ProductRelate::firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'relate_id' => $relate['id']
                    ],
                    [
                        'product_id' => $product->id,
                        'relate_id' => $relate['id'],
                        'quantity' => $relate['quantity']
                    ]
                );
                $relateGenerate->quantity = $relate['quantity'];
                $relateGenerate->save();

            });

            $product->load('prices');
            $product->load('providers');
            $product->load('relates');

            return new  ProductResource($product);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function storeFile(Request $request)
    {
        try {

            $product = Product::find($request->product_id);

            $product ->addMedia($request->file('file'))
                ->toMediaCollection('products');

            return new ProductResource($product);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function deleteFile($id)
    {
        try {

            $media = Media::find($id);

            $product = Product::find($media->model_id);

            Media::destroy($id);

            return new ProductResource($product);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function destroy($id)
    {

        try {

            $user = Product::where('id', $id)->first();

            $user->delete();

            return response()->json(['data' => 'Producto eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
