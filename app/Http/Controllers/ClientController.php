<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\ClientCollection;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\Client as ClientResource;
use Exception;

class ClientController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            list($take, $skip) = $this->getPagesConfig($request);

            $data = Client::where('type', $request->type)
                ->freeForAll()
                ->filter($request->name) ;

            $total = $data->select('*')->count();
            $list = $data->skip($skip)->take($take)->get();

            return  [
                'total' => $total,
                'data' =>  new ClientCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function store(Request $request)
    {
        try {
            $request['user_id'] = auth()->user()->id;
            $provider = Client::create($request->all());

            return new ClientResource($provider);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {

        try {

            $client = Client::where('id', $id)->first();

            $request['user_id'] = auth()->user()->id;
            $client->fill($request->all())->save();

            return new ClientResource($client);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = Client::where('id', $id)->first();

            $user->delete();

            return response()->json(['data' => 'Cliente eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
