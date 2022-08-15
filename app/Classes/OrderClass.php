<?php
namespace App\Classes;

class OrderClass 
 {
       private $storeNo;
       private $fullLoad;
       private $orderId;
       private $dailyNo;
       private $clientId;
       private $lastName;
       private $firstName;
       private $city;
       private $street;
       private $addressNo;
       private $secondaryAddress;
       private $postCode;
       private $lat;
       private $lng;
       private $phone;
       private $entrance;
       private $orderTotal;
       private $paymentMethod;
       private $cash;
       private $netSales;
       private $guaranteeMinutes;
       private $isTimedOrder;
       private $saleType;
       private $carrierInstructions;
       private $cookInstructions;
       private $priority;
       private $email;
       private $sendMessage;
       private $source;
       private $CSR;
       private $vipId;
       private $refundFor;
       private $isNotPaid;
       private $tips;
       private $position;
       private $itemNo;
       private $quantity;
       private $description;
       private $side;
       private $rightSideIcon;
       private $action;
       private $kdsList;
       private $style;
       private $flow1;
       private $deliveryType;
       private $items;


       function __construct($OrderData) {
              var_dump($OrderData['medio']);
              $saleType=2;
              if($OrderData['medio']== 'Rappi'){
                     $saleType= 1;
              }
              $this->items = $OrderData['items'];
            $this->cod_cabeceraApp = $OrderData['cod_cabeceraApp'];
            $this->phone = $OrderData['phone'];
            $this->clientId = $OrderData['clientId'];
            $this->firstName = $OrderData['firstName'];
            $this->lastName = $OrderData['lastName'];
            $this->addressNo = $OrderData['addressNo'];
            $this->street = $OrderData['street'];
            $this->secondaryAddress = $OrderData['secondaryAddress'];
            $this->email = $OrderData['email'];
            $this->postCode = $OrderData['postCode'];
            $this->lat = $OrderData['lat'];
            $this->lng = $OrderData['lng'];
            $this->description = $OrderData['items'][0]['plu_descripcion'];
            $this->saleType = $saleType;
           // var_dump($this->$saleType);


       }
        
    public function generateOrder()
    {
       $order= array (
       'storeNo' => 100,
       'fullLoad' => false,
       'orders' => 
       array (
         0 => 
         array (
              'storeNo' => 100,
              'orderId' => intval($this->cod_cabeceraApp),
              'dailyNo' => 843402,
              'clientId' => intval($this->clientId),
              'lastName' => $this->firstName,
              'firstName' => $this->lastName,
              'city' => 'Santo Domingo',
              'street' => $this->street,
              'addressNo' => $this->addressNo,
              'secondaryAddress' => $this->secondaryAddress,
              'lat' => intval($this->lat),
              'lng' => intval($this->lng),
              'phone' => $this->phone,
              'orderTotal' => 468.02,
              'paymentMethod' => 0,
              'cash' => 468.02,
              'isTimedOrder' => 1,
              'saleType' => $this->saleType,
              'carrierInstructions' => '| P:C.O.D',
              'cookInstructions' => '',
              'priority' => 0,
              'email' => '110462221406282@gmail.com',
              'source' => 1,
         ),
       ),
       'orderItems' => 
       array (
         0 => 
         array (
           'storeNo' => 100,
           'orderId' => 126,
           'position' => '000',
           'itemNo' => '1',
           'quantity' => 1.0,
           'description' => $this->description,
           'side' => 3,
           'action' => 0,
           'kdsList' => 'Pack-KDS',
           'style' => 'color:orange;font-weight: bold',
         ),
         1 => 
         array (
           'storeNo' => 100,
           'orderId' => intval($this->cod_cabeceraApp),
           'position' => '001',
           'itemNo' => '2',
           'quantity' => 1.0,
           'description' => $this->description,
           'side' => 3,
           'action' => 0,
           'kdsList' => 'Pack-KDS',
           'style' => '',
         ),
       ),
       );
    
         return $order;
        }
 } 