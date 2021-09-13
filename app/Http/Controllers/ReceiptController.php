<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\ReceiptCollection;
use App\Models\Inventory;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Resources\Receipt as ReceiptResource;
use Exception;
use Illuminate\Support\Carbon;


class ReceiptController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            $data = Receipt::with(['items', 'items.product', 'user'])
                     ->filter($request->name);

            list($take, $skip) = $this->getPagesConfig($request);
            $total = $data->select('*')->count();
            $list = $data->skip($skip)->take($take)
                ->orderBy('moment', 'desc')
                ->get();

            return  [
                'total' => $total,
                'data' => new ReceiptCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function store(Request $request)
    {
        try {
            $receipt = Receipt::create([
                'user_id' => auth()->user()->id,
                'moment' => Carbon::parse($request->moment),
                'document' => $request->document,
                'note' => $request->note,
                'amount' => 0,
                'status' => 'in-progress'
            ]);

            $receipt->items()->createMany($request->items);


            return new ReceiptResource($receipt);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {
        try {

            $receipt =  Receipt::find($id);

            $receipt->fill([
                'moment' => Carbon::parse($request->moment),
                'document' => $request->document,
                'note' => $request->note,
            ])->save();

            $receipt->items()->delete();

            $receipt->items()->createMany($request->items);


            return new ReceiptResource($receipt);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function destroy($id)
    {

        try {

            $receipt =  Receipt::where('id', $id)->first();

            $receipt->items()->delete();

            $receipt->delete();

            return response()->json(['data' => 'Recepcion eliminada con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function setToInventories($id)
    {
        try {

            $receipt =  Receipt::find($id);

            $receipt->load('items');

            foreach ($receipt->items as $item) {

                $inventory = Inventory::where('product_id', $item->product_id)->first();

                if ( $inventory) {
                    $inventory->quantity  =  $inventory->quantity + $item->quantity;
                    $inventory->save();

                    $inventory->details()->create([
                        'documentable_type' => Receipt::class,
                        'documentable_id' => $receipt->id,
                        'type' => 'Recepcion',
                        'quantity' => $item->quantity,
                        'total' => $inventory->quantity
                    ]);

                } else {
                   $inventory = Inventory::create([
                        'product_id' =>  $item->product_id,
                        'quantity' =>  $item->quantity,
                        'min' => 0
                    ]);
                   $inventory->details()->create([
                       'documentable_type' => Receipt::class,
                       'documentable_id' => $receipt->id,
                       'type' => 'Recepcion',
                       'quantity' => $item->quantity,
                       'total' => $item->quantity
                   ]);
                }
            }

            $receipt->fill([
                'status' => 'apply'
            ])->save();


            return new ReceiptResource($receipt);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function receiptDoc($id)
    {

        try {

            $data =  Receipt::with(['items', 'items.product', 'items.product.measure', 'user'])
                ->where('id', $id)
                ->first();

           // return $data;

            $view  = view('receipt', compact('data'))->render();

            $footer = view('footer', compact('data'))->render();


            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);

            return $pdf->inline('recepcion - '.$data->document .'.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
