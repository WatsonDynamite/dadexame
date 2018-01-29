<?php

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
///////////////////////USERS//////////////////////
//Route to return all users
Route::get('users', 'UserControllerAPI@getUsers');
//Route to Check email 
Route::get('users/emailavailable', 'UserControllerAPI@emailAvailable');
//Route to return specific Users
Route::get('users/{id}', 'UserControllerAPI@getUser');
//Route to Register User
Route::post('users', 'UserControllerAPI@store');
// Route to Confirm Register
Route::get('verify/{confirmation_code}', 'UserControllerAPI@verify');
//Route to Change User
Route::put('users/{id}', 'UserControllerAPI@update');
//Route to Delete User
Route::delete('users/{id}', 'UserControllerAPI@delete');
//Route to Block User
Route::get('users/{id}/block', 'UserControllerAPI@blockUser');
 
///////////////////////GAMES//////////////////////
Route::get('games', 'GameControllerAPI@index');
Route::get('games/lobby', 'GameControllerAPI@lobby');
Route::get('games/status/{status}', 'GameControllerAPI@gamesStatus');
Route::get('games/{id}', 'GameControllerAPI@getGame');
Route::post('games', 'GameControllerAPI@store');
Route::patch('games/{id}/join-start', 'GameControllerAPI@joinAndStart');
Route::patch('games/{id}/endgame/{winner}', 'GameControllerAPI@endgame');

/////////////////////DECKS//////////////////////////
Route::get('decks', 'DeckControllerAPI@getDecks');
Route::get('decks/{id}', 'DeckControllerAPI@getDeck');
Route::get('decks/{id}/changeStatus', 'DeckControllerAPI@changeDeckStatus');
Route::post('decks', 'DeckControllerAPI@store');

///////////////////////CONFIG//////////////////////
Route::get('configs', 'ConfigControllerAPI@getConfigInfo');

///////////////////////LOGIN//////////////////////
Route::post('login', 'LoginControllerAPI@login');
Route::post('loginAdmin', 'LoginControllerAPI@loginAdmin');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
Route::middleware('auth:api')->get('user', function() {
    return response()->json(request()->user());
});

///////////////////////UPDATE USER/////////////////////
Route::middleware('auth:api')->put('user', function() {
	return response() -> json(['msg'=>'User atualizado'], 200);
});

 
Route::get('teste', function(){
	return response()->json(['msg'=>'Só um teste'], 200);
});
Route::middleware('auth:api')->get('teste', function() {
	return response() -> json(['msg'=>'Só um teste'], 200);
});
