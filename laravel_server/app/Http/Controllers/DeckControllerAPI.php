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
        $card = Card::where('deck_id', $id)->first();
        return CardResource::collection(Card::all()->where('deck_id', $id));
        
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

    		$storage_path = Storage::putFile('public/decks/'.$request->deck.'/', $request->file('image'));
    		
    		$card = Card::create([
            
            'value' => $request->value,
            'suite' => $request->suite,
            'deck_id' => Deck::where('name',$request->deck)->first()->id,
            'path' => $storage_path
        	]);
        	$card->save();

        	return $card;

    	}else{
    		return 'No input specified';
    	}
    }	
}
