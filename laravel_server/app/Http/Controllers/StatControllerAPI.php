<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Game as GameResource;

use App\User;
use App\Game;

class StatControllerAPI extends Controller
{

	public function totalPlayers(Request $request)
	{	
        return UserResource::collection(User::all())->count();
    }

    public function totalGames(Request $request)
	{	
        return GameResource::collection(Game::all())->count();
    }

    public function topPlayersMorePoints(Request $request)
	{	
		//top 5 player with best score
		return UserResource::collection($users = DB::table('users')
							->orderBy('total_points','desc')	
							->take(5)->get());
    	 
    }

    public function topPlayersMoreGames(Request $request)
	{	
        //top 5 player with more games played
		return $users = UserResource::collection(DB::table('users')
							->orderBy('total_games_played','desc')	
							->take(5)->get());
    	 
    }

    public function topPlayersBestAvg(Request $request)
	{	
        //top 5 player with best average
		return $users = UserResource::collection(DB::table('users')
							->orderByRaw('total_points / total_games_played DESC')
							
							->take(5)->get());
    	 
    }
    

}