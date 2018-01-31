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
Route::post('decks', 'DeckControllerAPI@newDeck');
Route::post('cards', 'DeckControllerAPI@newCard');

///////////////////////CONFIG//////////////////////
Route::get('configs', 'ConfigControllerAPI@getConfigInfo');
Route::post('configs', 'ConfigControllerAPI@setConfigInfo');

///////////////////////LOGIN//////////////////////
Route::post('login', 'LoginControllerAPI@login');
Route::post('loginAdmin', 'LoginControllerAPI@loginAdmin');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');
Route::middleware('auth:api')->get('user', function() {
    return response()->json(request()->user());
});

///////////////////////UPDATE USER/////////////////////
//updates the user after a game is finished
Route::middleware('auth:api')->put('user', 'UserControllerAPI@gamePoints');
//updates user when he edits himself (no password)
Route::middleware('auth:api')->put('user/profile', 'UserControllerAPI@updateUser');
//updates user password
Route::middleware('auth:api')->put('user/pass', 'UserControllerAPI@updatePass');
//delete own user
Route::middleware('auth:api')->delete('user', 'UserControllerAPI@deleteUser');



/////////////////////STATISTICS////////////////////////
//get total nr of players
Route::get('stats/totalPlayers','StatControllerAPI@totalPlayers');
//get total nr of played games
Route::get('stats/totalGames','StatControllerAPI@totalGames');
//get top 5 players with most games
Route::get('stats/topPlayersMoreGames','StatControllerAPI@topPlayersMoreGames');
//get top 5 players with most points
Route::get('stats/topPlayersMorePoints','StatControllerAPI@topPlayersMorePoints');
//get top 5 players with best average
Route::get('stats/topPlayersBestAvg','StatControllerAPI@topPlayersBestAvg');
 


Route::get('teste', function(){
	return response()->json(['msg'=>'Só um teste'], 200);
});
Route::middleware('auth:api')->get('teste', function() {
	return response() -> json(['msg'=>'Só um teste'], 200);
});
