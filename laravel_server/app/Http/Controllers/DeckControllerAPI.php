<?php

namespace App\Http\Controllers;

use App\Card;
use App\Deck;
use App\Http\Resources\Card as CardResource;
use App\Http\Resources\Deck as DeckResource;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Storage;
	
class DeckControllerAPI extends Controller
{

	public function getDecks()
    {
        return DeckResource::collection(Deck::all());
    }

    public function getDeck($id)
    {
        
    }

    public function changeDeckStatus($id)
    {
        $deck = Deck::findOrFail($id);
        ($deck->active == 1) ? $deck->active =0 : $deck->active =1;   
    
        $deck->save();

        return "User Blocked Status changed";
    }

    public function store(Request $request){

    	if($request->hasFile('image')){

    		$request->file('image');
    		$storage_path = Storage::putFile('public', $request->file('image'));
    		
    		$card = Card::create([
            
            'value' => 'Ace',
            'suite' => 'Club',
            'deck_id' => '1',
            'path' => $storage_path
        	]);
        	$card->save();

        	return $card;

    	}else{
    		return 'No input specified';
    	}
    }	
}
