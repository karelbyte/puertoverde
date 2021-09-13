<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\InventoryCollection;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Resources\Inventory as InventoryResource;
use Exception;



class InventoryController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            $data = Inventory::with(['product'])
                     ->filter($request->name);

            list($take, $skip) = $this->getPagesConfig($request);
            $total = $data->select('*')->count();
            $list = $data->skip($skip)->take($take)
                ->get();

            return  [
                'total' => $total,
                'data' => new InventoryCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }




    public function update(Request $request, $id)
    {
        try {

            $inventory =  Inventory::find($id);

            $inventory->fill([
                'min' => $request->min,
            ])->save();

            return new InventoryResource($inventory);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function historyDoc($id)
    {
        try {

            $data =  Inventory::with(['details' => function($q) {
                $q->orderBy('created_at', 'desc');
            }, 'details.documentable', 'details.documentable.user', 'product'])
                ->where('id', $id)
                ->first();

            //return  $data;

            $view  = view('inventory-history', compact('data'))->render();

            $footer = view('footer', compact('data'))->render();


            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);

            return $pdf->inline('historico - '.$data->product->nname .'.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


}
