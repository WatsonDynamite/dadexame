<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Game as GameResource;
use App\Game;
use App\User;
class GameControllerAPI extends Controller
{
    public function index()
    {
        return GameResource::collection(Game::all());
    }

    public function lobby()
    {
        return GameResource::collection(Game::where('status', 'pending')->get());
    }

    public function gamesStatus($status)
    {
        return GameResource::collection(Game::where('status', $status)->get());
    }

    public function getGame($id)
    {
        return new GameResource(Game::find($id));
    }

    public function store(Request $request)
    {
        $request->validate([
                'created_by' => 'required',
            ]);
        $user = User::where('nickname', $request->created_by)->first();
        $game = new Game();
        $game->fill($request->all());
        
        //No matter what status and winner was defined on the client.
        // When creating a game it will always assume "pending" status
        // and winner will be null
        
        $game->created_by = $user->id;
        $game->status = 'pending';
        $game->save();
        
        return response()->json(new GameResource($game), 201);
    }

    public function startGame(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->status = 'active';
        $game->save();
        return $game;
    }

    public function endgame($id)
    {
        $game = Game::findOrFail($id);
        if (is_null($game->created_by) || ($game->created_by == "")) {
            return response()->json(array('code'=> 409, 'message' => 'Cannot end a game that has no first player'), 409);
        }
        if (is_null($game->status) || ($game->status != "active")) {
            return response()->json(array('code'=> 409, 'message' => 'Cannot end a game whose status is not "active"'), 409);
        }
        $game->status = 'terminated';
        $game->save();
        return $game;
    }
    
    public function registerGameUser($gameid, Request $request)
    {
        $table = 'game_user';
        $user = User::where('nickname', $request->user)->first();
        \DB::insert('insert into game_user (game_id, user_id, winner) values (?, ?, ?)', [$gameid, $user->id, $request->is_winner]);
       
    }
}
