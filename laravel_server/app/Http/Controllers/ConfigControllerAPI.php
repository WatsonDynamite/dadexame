<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Jsonable;
use App\Config;
use App\Http\Resources\Config as ConfigResource;


class ConfigControllerAPI extends Controller
{
	public function getConfigInfo(Request $request){
		return ConfigResource::collection(Config::all());
	}

	public function setConfigInfo(Request $request){

		$config = array(
                'driver' => $request->driver,
                'host' => $request->host,
                'port' => $request->port,
                'from' => array('address' => $request->email, 'name' => 'Blackjack Game'),
                'encryption' => $request->encryption,
                'username' => $request->username,
                'password' => $request->password,
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false
            );

		//saves to DB
		$config_var = Config::where('id', 1)->first();

		$config_var->platform_email = $request->email;
		$config_var->platform_email_properties = '{"driver": "'.$request->driver.'",'.
												'"host": "'.$request->host.'",'.
												'"port": "'.$request->port.'",'.
												'"password": "'.$request->password.'",'.
												'"encryption": "'.$request->encryption.'"}';
		$config_var->save();

		Config::set('mail',$config);
	}

}
