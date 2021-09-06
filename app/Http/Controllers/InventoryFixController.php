<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\InventoryFixCollection;
use App\Http\Resources\ReceiptCollection;
use App\Models\Inventory;
use App\Models\InventoryFix;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Resources\InventoryFix as InventoryFixResource;
use Exception;
use Illuminate\Support\Carbon;


class InventoryFixController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            $data = InventoryFix::with(['items', 'items.product', 'user'])
                     ->filter($request->name);

            list($take, $skip) = $this->getPagesConfig($request);
            $total = $data->select('*')->count();
            $list = $data->skip($skip)->take($take)
                ->orderBy('moment', 'desc')
                ->get();

            return  [
                'total' => $total,
                'data' =>  new InventoryFixCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function store(Request $request)
    {
        try {
            $inventoryFix = InventoryFix::create([
                'user_id' => auth()->user()->id,
                'moment' => Carbon::parse($request->moment),
                'document' => $request->document,
                'note' => $request->note,
                'type' => $request->input('type.value'),
                'amount' => 0,
                'status' => 'in-progress'
            ]);

            $inventoryFix->items()->createMany($request->items);


            return new  InventoryFixResource($inventoryFix);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {
        try {

            $inventoryFix =  InventoryFix::find($id);

            $inventoryFix->fill([
                'moment' => Carbon::parse($request->moment),
                'document' => $request->document,
                'note' => $request->note,
            ])->save();

            $inventoryFix->items()->delete();

            $inventoryFix->items()->createMany($request->items);


            return new InventoryFixResource($inventoryFix);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function destroy($id)
    {

        try {

            $inventoryFix =  InventoryFix::where('id', $id)->first();

            $inventoryFix->items()->delete();

            $inventoryFix->delete();

            return response()->json(['data' => 'Ajuste eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function setToInventories($id)
    {
        try {

            $inventoryFix =  InventoryFix::find($id);

            $inventoryFix->load('items');

            foreach ($inventoryFix->items as $item) {

                $inventory = Inventory::where('product_id', $item->product_id)->first();

                if ( $inventory) {
                    $inventory->quantity  = $inventoryFix->type == 'add' ? $inventory->quantity + $item->quantity :  $inventory->quantity - $item->quantity;
                    $inventory->save();
                } else {
                   if ( $inventoryFix->type == 'add') {
                       $inventory = Inventory::create([
                           'product_id' =>  $item->product_id,
                           'quantity' =>  $item->quantity,
                           'min' => 0
                       ]);
                   }
                }

                $inventory->details()->create([
                    'documentable_type' =>  InventoryFix::class,
                    'documentable_id' => $inventoryFix->id,
                    'quantity' => $inventoryFix->type == 'add' ? $item->quantity : - $item->quantity,
                    'total' => $inventory->quantity
                ]);
            }

            $inventoryFix->fill([
                'status' => 'apply'
            ])->save();


            return new InventoryFixResource($inventoryFix);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function inventoryFixDoc($id)
    {

        try {

            $data =  InventoryFix::with(['items', 'items.product', 'items.product.measure', 'user'])
                ->where('id', $id)
                ->first();

           // return $data;

            $view  = view('inventory-fix', compact('data'))->render();

            $footer = view('footer', compact('data'))->render();


            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);

            return $pdf->inline('ajuste - '.$data->document .'.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
