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

    public function newDeck(Request $request){

        if($request->hasFile('image')){

            //verify if deck already exists if so, replace it

            $deck = Deck::where('name', $request->name)->first();
            
            $request->file('image');
                $storage_path = Storage::putFileAs('public/decks/'.$request->name.'/', $request->file('image'), 'semFace.png');
            if($deck == null){
                $deck = Deck::create([
                'name' => $request->name,
                'active' => 0,
                'complete' => 0,
                'hidden_face_image_path' => $storage_path
                ]);
            }else{
               $deck->hidden_face_image_path = $storage_path; 
            }
            $deck->save();
            return $deck;

        }else{
            return 'No input specified';
        }

        return $deck;
    }

    public function newCard(Request $request){


    	//if($request->hasFile('image')){

            //verify if card already exists if so, replace it

            $card = Card::where('deck_id',Deck::where('name',$request->deck)->first()->id)->where('suite', $request->suite)->where('value', $request->value)->first();
            
            $card_name = $this->newCardName($request);

            $request->file('image');
            $storage_path = Storage::putFileAs('public/decks/'.$request->deck.'/', $request->file('image'),$card_name);

            if($card == null){

                $deck_id = Deck::where('name',$request->deck)->first()->id;

                $card = Card::create([
                'value' => $request->value,
                'suite' => $request->suite,
                'deck_id' => $deck_id,
                'path' => $storage_path
                ]);

                if(CardResource::collection(Card::all()->where('deck_id', $deck_id))->count() == 52){
                    $deck = Deck::where('id', $deck_id)->first();
                    $deck->complete = 1;
                    $deck->save();
                }             

    		}else{
        	   $card->path = $storage_path;	
            }
            $card->save();
             
        	return $card;

    	//}else{
    		return 'No input specified';
    	//}
    }	


    public function newCardName(Request $request){

        $card_name = '';

        switch ($request->suite) {
            case 'Club':
                $card_name .= 'p';        
                break;
            case 'Diamond':
                $card_name .= 'o';
                break;
            case 'Heart':
                $card_name .= 'c';
                break;
            case 'Spade':
                $card_name .= 'e';
                break;
            default:
                break;
        }

        switch ($request->value) {
            case 'Ace':
                $card_name .= '1';
                break;
            case '2':
                $card_name .= '2';
                break;
            case '3':
                $card_name .= '3';
                break;
            case '4':
                $card_name .= '4';
                break;
            case '5':
                $card_name .= '5';
                break;
            case '6':
                $card_name .= '6';
                break;
            case '7':
                $card_name .= '7';
                break;
            case '8':
                $card_name .= '8';
                break;
            case '9':
                $card_name .= '9';
                break;
            case '10':
                $card_name .= '10';
                break;
            case 'Jack':
                $card_name .= '11';
                break;
            case 'Queen':
                $card_name .= '12';
                break;
            case 'King':
                $card_name .= '13';
                break;
            default:
                break;
        }

        $card_name .= '.png';

        return $card_name;

    }

}
