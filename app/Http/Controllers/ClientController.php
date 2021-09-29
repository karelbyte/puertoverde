<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\ClientCollection;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\Client as ClientResource;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            list($take, $skip) = $this->getPagesConfig($request);

            $data = Client::where('type', $request->type)
                ->freeForAll()
                ->filter($request->name)
                ->sortBy($request->sortBy, $request->descending);

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

            $client->company = $request->company;
            $client->name = $request->name;
            $client->email = $request->email;
            $client->phones = $request->phones;
            $client->address = $request->address;
            $client->note = $request->note;
            $client->save();

          //  $request['user_id'] = auth()->user()->id;
         //   $client->fill($request->all())->save();

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


    public function export(Request $request)
    {

        try {

            $type = $request->type == 'lead' ? 'Prospectos' : 'Clientes';

            $moment = now();
            $fileName =  "{$type}-{$moment}.xlsx";

            Excel::store(new ClientsExport($request->all()), $fileName, 'public');

            $url = url('/');

            return ['data' => "${url}/storage/${fileName}"];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
