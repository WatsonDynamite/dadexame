<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Game extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_players' => $this->total_players,
            'created_by' => $this->created_by,
            'deck_used' => $this->deck_used,
            'created_at' => $this->created_at
        ];
        return parent::toArray($request);
    }
}
