<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use stdClass;

class VehicleController extends Controller
{
    function createVehicle(Request $data){
        return $this->makeRequest($data->json()->all());
    }

    function makeRequest($data){
        $serverUrl='https://kfc-co.dragontail.com/PosInsertEmployees';
        $ch = curl_init($serverUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);

        $result = curl_exec($ch);

        $jsonData=json_decode($result);

        curl_close($ch);

        return json_encode($data);
    }
}
