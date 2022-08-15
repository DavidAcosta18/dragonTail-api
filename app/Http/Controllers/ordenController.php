<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use \App\Classes\OrderClass;
use stdClass;

//set_error_handler(null);
class ordenController extends Controller
{
    function create(Request $data){
        //$order= new OrderClass();
       // $order->getOrderData();
        $url= 'https://kfc-co.dragontail.com/PosInsertOrders';
        $myJSON = $data->post();
        //var_dump($myJSON);
        //$order= new OrderClass($data->post());
        $order= new OrderClass(json_decode($data->post()[0], true));
        $myJSON=$order->generateOrder();
        /*$validator = Validator::make($myJSON,[
            'storeNo' => ['required',  'numeric'],
            'fullLoad'=> ['required',  'boolean'],
            'orders.*.storeNo' => ['required',  'numeric'],
            'orders.*.orderId' => ['required',  'numeric'],
            'orders.*.clientId' => ['required',  'numeric'],
            'orders.*.firstName' => ['required',  'string'],
            'orders.*.lastName' => ['required',  'string'],
            'orders.*.city' => ['required',  'string'],
            'orders.*.street' => ['required',  'string'],
            'orders.*.addressNo' => ['required',  'string'],
            'orders.*.secondaryAddress' => ['required',  'string'],
            'orders.*.lat' => ['required',  'numeric'],
            'orders.*.lng' => ['required',  'numeric'],
            'orders.*.phone' => ['required',  'string'],
            'orders.*.orderTotal' => ['required',  'numeric'],
            'orders.*.cash' => ['required',  'numeric'],
            'orders.*.netSales' => ['required',  'numeric'],
            'orders.*.guaranteeMinutes' => ['required',  'numeric'],
            'orders.*.isTimedOrder' => ['required',  'numeric'],
            'orders.*.saleType' => ['required',  'numeric'],
            'orders.*.carrierInstructions' => ['required',  'string'],
            'orders.*.email' => ['required',  'string'],
            'orders.*.isNotPaid' => ['required',  'numeric'],
            'orders.*.tips' => ['required',  'numeric'],
            'orderItems.*.storeNo' => ['required',  'numeric'],
            'orderItems.*.orderId' => ['required',  'numeric'],
            'orderItems.*.itemNo' => ['required',  'string'],
            'orderItems.*.position' => ['required',  'string'],
            'orderItems.*.quantity' => ['required',  'numeric'],
            'orderItems.*.description' => ['required',  'string'],
            'orderItems.*.action' => ['required',  'numeric'],
            'orderItems.*.kdsList' => ['required',  'string']
        ]);
        if($validator->fails()){
            return response(array("invalid data"=>$validator->failed()), 403);
        }*/
        $response= $this->makeRequest($url,json_encode($myJSON));
        return  $this->validateCall($response);
    }

    function validateCall($data){
       if($data["status"]!="ok"){
            return response(array("dragontail cannot process this request error :"=>$data["errDescription"]),500);
        }
        return json_encode($data);
    }

    function changeStatus($orderId,$storeNo){
        $dataraw=array (
            'StoreNo' => $storeNo,
            'orders' => 
            array (
              0 => 
              array (
                'id' => $orderId,
                'status' => 6,
              ),
            ),
            'SetCarrierAssigned' => 1,
          );
          $validator = Validator::make($dataraw,[
            'StoreNo' => ['required',  'string'],
            'orders.*.id' => ['required',  'string'],
            'orders.*.status' => ['required',  'integer'],

          ]);
          if($validator->fails()){
            return response(array("invalid data"=>$validator->failed()), 403);
        }
        $url= 'https://kfc-co.dragontail.com/handler/100/orders';
       $response =$this->makeRequest($url,json_encode($dataraw));
       try {
            return $response["orders"];
        }catch (\Throwable $th) {
            //return $jsonData["error"];
    }
        return $response;
    }


    function getOrder($orderId,$storeNo){
        $intStoreNo = intval( $storeNo); 
        $dataraw=array (
            "storeNo" => $intStoreNo,
          );
        $validator = Validator::make($dataraw,[
            'storeNo' => ['required',  'numeric']
         ]);
         if($validator->fails()){
            return response(array("invalid data"=>$validator->failed()), 403);
        }
        $url= 'https://kfc-co.dragontail.com/GetOrderUpdatesForPos';
        $orderList = json_encode($this->makeRequest($url,json_encode($dataraw)));
        
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
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $result = curl_exec($ch);
        $jsonData=json_decode($result, true);

        if(curl_error($ch) ){
            return curl_error($ch);
        }

        curl_close($ch);
        return $jsonData;
    }
}

