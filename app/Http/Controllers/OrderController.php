<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Controllers\Traits\SettingsTrait;
use App\Http\Resources\ReceiptCollection;
use App\Models\Client;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Resources\Receipt as ReceiptResource;
use Exception;
use Illuminate\Support\Carbon;


class OrderController extends Controller
{
    use PagesTrait, SettingsTrait;

    public function index(Request $request)
    {

        try {

            $data = Order::with(['items', 'items.product', 'user'])
                     ->filter($request->name);

            list($take, $skip) = $this->getPagesConfig($request);
            $total = $data->select('*')->count();
            $list = $data->skip($skip)->take($take)
                ->orderBy('created_at', 'desc')
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
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'moment' => now(),// Carbon::parse($request->moment),
                'document' => $this->nextFolio('order'),
                'note' => $request->note,
                'amount' => 0,
                'status' => 'in-progress'
            ]);

            $order->items()->createMany($request->items);


            return new ReceiptResource($order);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {
        try {

            $order =  Order::find($id);

            $order->fill([
                'note' => $request->note,
            ])->save();

            $order->items()->delete();

            $order->items()->createMany($request->items);


            return new ReceiptResource($order);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function destroy($id)
    {

        try {

            $receipt =  Order::where('id', $id)->first();

            $receipt->items()->delete();

            $receipt->delete();

            return response()->json(['data' => 'Pedido eliminad con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function setToInventories($id, $document)
    {
        try {

            $order = Order::find($id);
            $order->load('items');

            $receipt = Receipt::create($order->toArray());
            $receipt->document = $document;
            $receipt->moment = now();
            $receipt->save();

            foreach ($order->items as $item) {
                $receipt->items()->create($item->toArray());
            }

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

            $order->fill([
                $receipt->document = $document,
                'status' => 'apply'
            ])->save();


            return new ReceiptResource($order);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function orderDoc($id)
    {

        try {

            $data = Order::with(['items', 'items.product', 'items.product.measure', 'user'])
                ->where('id', $id)
                ->first();

            $view  = view('order', compact('data'))->render();

            $footer = view('footer', compact('data'))->render();


            $pdf = \PDF::loadHTML( $view )
                ->setOption('footer-html', $footer);

            return $pdf->inline('pedido - '.$data->document .'.pdf');

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function resources() {
        try {

            $data = $data = Client::with([
                'services',
                'services.quotes'
            ])->where('type', 'client')
                ->get();

            return response()->json(['data' =>  $data]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
