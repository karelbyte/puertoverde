<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\PercentCollection;
use App\Models\Percent;
use Illuminate\Http\Request;
use App\Http\Resources\Percent as PercentResource;
use Exception;

class PercentController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {
        try {

            $data = Percent::filter($request->percentage)->orderBy('default', 'desc');

            if ($request->paging == 'on') {
                list($take, $skip) = $this->getPagesConfig($request);
                $total = $data->select('*')->count();
                $list = $data->skip($skip)->take($take)->get();
            } else {
                $total = 0;
                $list = $data->get();
            }

            return  [
                'total' => $total,
                'data' => new PercentCollection($list)
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        try {
            $percent = Percent::create($request->all());

            return new PercentResource($percent);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $percent = Percent::find($id);

            $percent->fill($request->all())->save();

            return new PercentResource($percent);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function destroy($id)
    {
        try {

            $percent = Percent::where('id', $id)->first();

            $percent->delete();

            return response()->json(['data' => 'Porciento eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function setDefault($id)
    {
        try {

            Percent::whereNotIn('id', [$id])->update(['default' => 0]);

            Percent::where('id', $id)->update(['default' => 1]);

            return response()->json(['data' => 'Porciento ajustado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
