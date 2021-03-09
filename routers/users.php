<?php
ini_set('display_errors', 0);
// Роутер
function route($method, $urlData, $formData) {
$file = "users.json";
$json = json_decode(file_get_contents($file), true);

   
    // Получение информации о пользователе
    // GET /goods/{goodId}
if ($method === 'GET' && count($urlData) === 1) {
    $userId = $urlData[0];
    foreach($json as $item) {  

        if($item["id"]==$userId ){

         echo (" Name - ".$item["name"]." users email - ".$item["email"]." with id - ".$item["id"]);
        }
    
    }  
        
        return;
}


    // Добавление нового пользователя
    // POST /user
if ($method === 'POST' && empty($urlData)) {
    $userId = $_POST['id'];
    $userName =  $_POST['name'];
    $userEmail =  $_POST['email'];

    $check = 0;

    foreach($json as $item) {  
    
        if($item["id"]==$userId ){

            echo ("Yes, user with that id already exists!");
            $check = 1;
        }
    } 
        if ($check==0) {
         
            $json[]=['id' => $userId, 'name' => $userName, 'email' => $userEmail];
            sort($json);
            file_put_contents($file, json_encode($json)); }   
        
    return;
}


    // Обновление всех данных о пользователе
    // PUT /user/{userId}
if ($method === 'PUT' && count($urlData) === 1) {
        
    $userId = $urlData[0];
    $data = array();
    parse_str(file_get_contents("php://input"), $data);
    $data = json_decode(json_encode($data));
    $userName = $data->name; 
    $userEmail = $data->email; 
        foreach ($json  as $key => $value){    // Найти в массиве  
            if (in_array($userId, $value)) {    // Совпадение значения переменной
             $json[$key] = array('id'=>$userId, 'name'=>$userName, 'email'=>$userEmail);  // Присвоить новое значение
            }
        }
    file_put_contents($file, json_encode($json));    
    return;
}


    // Частичное обновление данных о пользователе
    // PATCH /user/{userId}
if ($method === 'PATCH' && count($urlData) === 1) {
    $goodId = $urlData[0];
    $data = array();
    parse_str(file_get_contents("php://input"), $data);
    $data = json_decode(json_encode($data));
    $userEmail = $data->email; 
    
        foreach ($json  as $key => $value){    // Найти в массиве  
            if (in_array($userId, $value)) {  
                $json[$key]['email'] = $userEmail;
            }
        }
    file_put_contents($file, json_encode($json));    
    return;
    }


    // Удаление пользователя
    // DELETE /user/{userId}
    if ($method === 'DELETE' && count($urlData) === 1) {
    $userId = $urlData[0];
      
        foreach ($json  as $key => $value){    // Найти в массиве  
            if (in_array($userId, $value)) { 
                
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

