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
                'driver' => $mail->driver,
                'host' => $mail->host,
                'port' => $mail->port,
                'from' => array('address' => $mail->from_address, 'name' => $mail->from_name),
                'encryption' => $mail->encryption,
                'username' => $mail->username,
                'password' => $mail->password,
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false
            );

		Config::set('mail',$config);
	}

}
