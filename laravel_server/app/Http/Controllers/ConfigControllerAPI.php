<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use App\Config;
use App\Http\Resources\Config as ConfigResource;


class ConfigControllerAPI extends Controller
{
	public function getConfigInfo(){
		return ConfigResource::collection(Config::all());
	}

}
