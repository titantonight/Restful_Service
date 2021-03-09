# Restful_Service
Простой RESTful-сервис на нативном PHP.
Доработал сервис со статьи https://webdevkin.ru/posts/backend/restful-servis-na-nativnom-php
В статье данные генерируется случайным образом, а также никуда не заносятся информация добавленная пользователем.
Я добавил CRUD с Json-файлами:

curl -X GET localhost/Restful_Service/goods/1 -i
curl -X PATCH localhost/Restful_Service/goods/1 --data "price=20001" -i
curl -X PUT localhost/Restful_Service/goods/1 --data "good=ring&price=20001" -i
curl -X DELETE localhost/Restful_Service/goods/1 -i
