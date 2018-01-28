<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Config extends Resource
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
            'platform_email' => $this->platform_email,
            'platform_email_properties' => $this->platform_email_properties,
            'img_base_path' => $this->img_base_path
        ];
    }
}
