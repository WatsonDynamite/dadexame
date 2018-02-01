<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

define('YOUR_SERVER_URL', 'http://188.186.86.13');
// Check "oauth_clients" table for next 2 values:
define('CLIENT_ID', '2');
define('CLIENT_SECRET','jkam2AA8X2PuE1hPsnGG2QkA4ZZGB9cpJGy0pCou');
class LoginControllerAPI extends Controller
{
	public function login(Request $request)
	{
		$http = new \GuzzleHttp\Client;
		$response = $http->post(YOUR_SERVER_URL.'/oauth/token', [
			'form_params' => [
				'grant_type' => 'password',
				'client_id' => CLIENT_ID,
				'client_secret' => CLIENT_SECRET,
				'username' => $request->email,
				'password' => $request->password,
				'scope' => ''
			],
			'exceptions' => false,
		]);
		$errorCode= $response->getStatusCode();

		$user = User::where('email', $request->email)->first();

		if ($errorCode=='200' && ($user->confirmed == 1)  && ($user->blocked == 0)) {
			return json_decode((string) $response->getBody(), true);
		} else {
			if($user->confirmed == 0){
				return response()->json(
				['msg'=>'User has not been confirmed'], $errorCode);
			}elseif ($user->blocked == 1) {
				return response()->json(
				['msg'=>'User has been blocked'], $errorCode);
			}
			return response()->json(
				['msg'=>'User credentials are invalid'], $errorCode);
		}
	}

	public function loginAdmin(Request $request)
	{
		$http = new \GuzzleHttp\Client;
		$response = $http->post(YOUR_SERVER_URL.'/oauth/token', [
			'form_params' => [
				'grant_type' => 'password',
				'client_id' => CLIENT_ID,
				'client_secret' => CLIENT_SECRET,
				'username' => $request->email,
				'password' => $request->password,
				'scope' => ''
			],
			'exceptions' => false,
		]);
		$errorCode= $response->getStatusCode();
		$user = User::where('email',$request->email) -> first();

		if ($errorCode=='200' && ($user->admin == 1) && ($user->blocked == 0)) {
			return json_decode((string) $response->getBody(), true);
		} else {
			if($user->confirmed == 0){
				return response()->json(
				['msg'=>'User has not been confirmed'], $errorCode);
			}elseif ($user->blocked == 1) {
				return response()->json(
				['msg'=>'User has been blocked'], $errorCode);
			}
			return response()->json(
				['msg'=>'User credentials are invalid'], $errorCode);
		}
	}


	public function logout()
	{
		\Auth::guard('api')->user()->token()->revoke();
		\Auth::guard('api')->user()->token()->delete();
		return response()->json(['msg'=>'Token revoked'], 200);
        
	}
}
