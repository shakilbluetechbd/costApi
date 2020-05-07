<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\userResource;



class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        try {

            $user->save();
            return response([
                'data' => new userResource($user),
                'message' => ['created'],
                'error' => []
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {

            return response([
                'data' => new userResource($user),
                'message' => ['not created'],
                'error' => [$e->getMessage()]
            ], Response::HTTP_BAD_REQUEST);
             
        }
    }
}
