<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use stdClass;

class ordenController extends Controller
{
    function create(Request $data){
        $url= 'https://kfc-co.dragontail.com/PosInsertOrders';
        
        $myJSON = $data->post();
       return $this->makeRequest($url,json_encode($myJSON));
    }
    function assign(Request $data,$orderId){
        $dataraw='{
            "StoreNo": "100",
            "orders": [
                {
                    "id": "'.$orderId.'",
                    "status": 6
                }
            ],
            "reshuffle": false,
            "SetCarrierAssigned": 1
        }';

        $url= 'https://kfc-co.dragontail.com/handler/100/orders';
        return $this->makeRequest($url,$dataraw);
    }  function status(Request $data,$orderId){
        $dataraw='{
            "storeNo": 100,
            "updateStamp": 1
          }';

        $url= 'https://kfc-co.dragontail.com/GetOrderUpdatesForPos';
        $orderList = $this->makeRequest($url,$dataraw);
        $response= $this->parseOrderlist($orderList,$orderId);
        if($response==false){
            return response(array($orderId=>"Does not exist"),404);
        }
        return $response;
    }
    function parseOrderlist($data,$orderId){
        $pedido;
        $orderArray =  json_decode($data)->orders;
        foreach($orderArray as $order){
            if($order->orderId==$orderId){
                return $order;
            }
        };
        return false;
      
        

    }

    function makeRequest($url,$data){
        $token="70345032-4E50-477A-5533-71715A41445A";
        $serverUrl=$url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serverUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);

        $result = curl_exec($ch);

        $jsonData=json_decode($result);

        curl_close($ch);

        return json_encode($jsonData);
    }
}