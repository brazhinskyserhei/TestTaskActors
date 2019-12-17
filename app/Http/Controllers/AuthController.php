<?php

namespace App\Http\Controllers;

use App\Address;
use App\Staff;
use App\User;
use App\Store;
use Illuminate\Http\Request;
use Auth;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:staff',
            'password' => 'required|confirmed',
            'last_name' => 'required',
            'first_name' => 'required',
            'username' => 'required',
            'address' => 'required',
            'district' => 'required',
            'city_id' => 'required|numeric',
            'postal_code' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();

        $addressParameters = [
            'address' => $input['address'],
            'district' => $input['district'],
            'city_id' => $input['city_id'],
            'postal_code' => $input['postal_code'],
            'phone' => $input['phone'],
        ];

        $input['password'] = bcrypt($input['password']);
        $input['address_id'] = $this->createAddress($addressParameters);
        $input['store_id'] = 1;

        $userStaff = User::create($input);
        $success['token'] = $userStaff->createToken('token_auth')->accessToken;
        $success['name'] = $userStaff->username;
        return response()->json(['success' => $success], 201);
    }

    protected function createAddress($addressParameters)
    {
        return Address::create($addressParameters)->address_id;
    }

    protected function createStore($address_id)
    {
        return Store::create([
            'manager_staff_id' => 1,
            'address_id' => $address_id
        ])->store_id;
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if (!$user->active) {
                return response()->json(['error' => 'User not active'], 401);
            }
            $success['token'] = $user->createToken('token_auth')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function testAuth()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }


}
