<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\ProviderCollection;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Resources\Provider as ProviderResource;
use Exception;

class ProviderController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            $data = Provider::filter($request->name);

            if (!$request->list) {
                list($take, $skip) = $this->getPagesConfig($request);
                $total = $data->select('*')->count();
                $list = $data->skip($skip)->take($take)->get();
            } else {
                $total = 0;
                $list = $data->get();
            }

            return  [
                'total' => $total,
                'data' => new ProviderCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function store(Request $request)
    {
        try {
            $provider = Provider::create($request->all());

            return new ProviderResource($provider);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id)
    {

        try {

            $provider = Provider::where('id', $id)->first();

            $provider->fill($request->all())->save();

            return new ProviderResource($provider);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function destroy($id)
    {

        try {

            $user = Provider::where('id', $id)->first();

            $user->delete();

            return response()->json(['data' => 'Proveedor eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
