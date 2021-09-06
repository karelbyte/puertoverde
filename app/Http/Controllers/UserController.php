<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\PagesTrait;
use App\Http\Resources\UserCollection;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Permission as PermissionResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Http\Requests\User as Store;

class UserController extends Controller
{
    use PagesTrait;

    public function index(Request $request)
    {

        try {

            $data = User::with('permissions')
                   ->filter($request->name)
                   ->seller((bool)$request->seller);

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
                'data' =>  new UserCollection($list),
            ];

        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        try {
            $user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => $request->status,
                    'seller' => $request->seller,
                    'manager_percentage' => $request->manager_percentage,
                    'manager_price' => $request->manager_price,
                    'free_for_all' => $request->free_for_all,
                    'installer' => $request->installer,
                    'admin' => $request->admin,
                ]
            );

            $permissions = Permission::whereIn('value', $request->permissions)->get();

            foreach ($permissions as $permission) {
                UserPermission::create([
                    'user_id' => $user->id,
                    'permission_id' => $permission->id
                ]);
            }

            $user->load('permissions');

            return new UserResource( $user);

        } catch (Exception $e) {
            return response()->json(['data' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $dataToUpdate= [
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'seller' =>  $request->seller,
                'manager_percentage' => $request->manager_percentage,
                'manager_price' => $request->manager_price,
                'free_for_all' => $request->free_for_all,
                'installer' => $request->installer,
                'admin' => $request->admin,
            ];

            if ($request->filled('password')) {
                $dataToUpdate['password'] = Hash::make($request->password);
            }

            $user = User::where('id', $id)->first();

            $user->fill($dataToUpdate)->save();

            $permissions = Permission::whereIn('value', $request->permissions)->get();

            UserPermission::where('user_id', $id)->delete();

            foreach ($permissions as $permission) {
                UserPermission::create([
                    'user_id' => $user->id,
                    'permission_id' => $permission->id
                ]);
            }

            $user->load('permissions');

            return new UserResource($user);

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

            $user = User::where('id', $id)->first();

            $user->delete();

            return response()->json(['data' => 'Usuario eliminado con exito!']);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function getPermissionList() {
        return  PermissionResource::collection(Permission::all());
    }

    public function login(Request $request)
    {
        $user = User::with('permissions')->where('email', $request->email)->first();

        if ($user) {

            $pass = Hash::check($request->password, $user->password);

            if ($pass) {

                $dataToken = $user->createToken('token');

                $expireIn = Carbon::parse($dataToken->token->expires_at)->timestamp;

                return response(['data' =>  ['user' => new UserResource($user), 'token' => $dataToken->accessToken, 'expires' => $expireIn]]);

            } else {
                return response()->json(['message' => 'Las credenciales no son válidas'], 401);
            }
        } else {
            return response()->json(['message'=>'El usuario no es válido'], 401);
        }
    }
}
