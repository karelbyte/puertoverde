<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\InventoryCollection;
use App\Http\Resources\ReceiptCollection;
use App\Models\Inventory;
use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Http\Resources\Receipt as ReceiptResource;
use Exception;
use Illuminate\Support\Carbon;


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

            $receipt =  Receipt::find($id);

            $receipt->fill([
                'moment' => Carbon::parse($request->moment),
                'document' => $request->document,
                'note' => $request->document,
            ]);

            $receipt->items()->delete();

            $receipt->items()->createMany($request->items);


            return new ReceiptResource($receipt);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


}
