<?php
ini_set('display_errors', 0);
// Роутер
function route($method, $urlData, $formData) {
$file = "goods.json";
$json = json_decode(file_get_contents($file), true);

   
    // Получение информации о товаре
    // GET /goods/{goodId}
if ($method === 'GET' && count($urlData) === 1) {
    // Получаем id товара
    $goodId = $urlData[0];
    foreach($json as $item) {  
        if($item["id"]==$goodId ){
         echo ("Cost - ".$item["price"]." good's title - ".$item["good"]." with id - ".$item["id"]);
        }
    }     
        return;
}


    // Добавление нового товара
    // POST /goods 
if ($method === 'POST' && empty($urlData)) {
    $goodId = $_POST['id'];
    $goodTitle =  $_POST['good'];
    $goodPrice =  $_POST['price'];
    $check = 0;

    foreach($json as $item) {  
        if($item["id"]==$goodId ){

            echo ("Yes, object with that id already exists!");
            $check = 1;
        }
    } 
        if ($check==0) {
            $json[]=['id' => $goodId, 'good' => $goodTitle, 'price' => $goodPrice];
            sort($json);
            file_put_contents($file, json_encode($json)); }   
    return;
}


    // Обновление всех данных товара
    // PUT /goods/{goodId}
if ($method === 'PUT' && count($urlData) === 1) {
        
    $goodId = $urlData[0];
    $data = array();
    parse_str(file_get_contents("php://input"), $data);
    $data = json_decode(json_encode($data));
    $goodPrice = $data->price; 
    $goodTitle = $data->good; 

        foreach ($json  as $key => $value){    // Найти в массиве  
            if (in_array($goodId, $value)) {    // Совпадение значения переменной
             $json[$key] = array('id'=>$goodId, 'good'=>$goodTitle, 'price'=>$goodPrice);  // Присвоить новое значение
            }
        }

    file_put_contents($file, json_encode($json));    
    return;
}


    // Частичное обновление данных товара
    // PATCH /goods/{goodId}
if ($method === 'PATCH' && count($urlData) === 1) {
    $goodId = $urlData[0];
    $data = array();
    parse_str(file_get_contents("php://input"), $data);
    $data = json_decode(json_encode($data));
    $goodPrice = $data->price; 
    
        foreach ($json  as $key => $value){    // Найти в массиве  
            if (in_array($goodId, $value)) {  
                $json[$key]['price'] = $goodPrice;
            }
        }

    file_put_contents($file, json_encode($json));    
    return;
    }


    // Удаление товара
    // DELETE /goods/{goodId}
    if ($method === 'DELETE' && count($urlData) === 1) {
    $goodId = $urlData[0];
      
        foreach ($json  as $key => $value){    // Найти в массиве  
            if (in_array($goodId, $value)) { 
                
              unset($json[$key]);
              
              
            } 
            sort($json);
        }

        file_put_contents($file, json_encode($json));    
    return;
    }


    // Возвращаем ошибку
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));

}

