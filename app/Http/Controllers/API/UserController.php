<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public $successStatus = 200;

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $field = filter_var(request('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if(Auth::attempt([$field => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $success['username'] = $user->name;
            $success['role'] = $user->role;

            $auth = User::find($user->id);
            $auth->api_token = $success['token'];
            $auth->save();

            return response()->json($success, $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'unauthorised'], 401);
        }
    }


    /**
     * Register api
     *
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }


    /**
     * Change passoerd
     *
     * @param UserChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(UserChangePasswordRequest $request)
    {
        $auth = Auth::user();
        $user = User::find($auth->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['success' => 'OK'], 200);
    }
}
