<?php

/**
 * @property Product $product
 */
class ProductController
{
    private $product;

    /**
     * productController constructor.
     */
    function __construct($database)
    {
        $this->product = new Product($database);

    }


    /**
     * @return Product
     */
    public function getItems()
    {

        $stmt = $this->product->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $products_arr = [];
            $products_arr["products"] = [];

            // fetch() быстрее, чем fetchAll()
            while ($row = $stmt->fetch()){
                $product_item=array(
                    "name" => $row['name'],
                    "price" => $row['price'],
                    "dateAndTime" => date('d.m.Y H:i:s', $row['date_and_time'])
                );
                $products_arr["products"][] = $product_item;
            }

            http_response_code(200);
            echo json_encode($products_arr);

        } else {
            http_response_code(404);
            $res = [
                "status" => "false",
                "message" => "Товары не найдены."
            ];
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
    }


    public function setItem()
    {
        $res = $this->validateInput();

        if ($res["status"] === "false") {
            http_response_code(200);
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            exit();
        }

        // устанавливаем значения свойств товара
        $this->product->name = htmlentities($_POST['name-input']);
        $this->product->price = htmlentities($_POST['price-input']);
        $this->product->dateAndTime = (new DateTime($_POST['date-input']))->getTimestamp();
        $this->product->created = (new DateTime())->getTimestamp();

        // создание товара
        if ($this->product->create()) {
            http_response_code(201);
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(503);
            $res["status"] = "false";
            $res["message"] = "Ошибка сохранения данных";
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
    }

    private function validateInput()
    {
        $res = ["status" => "true"];

        // убеждаемся, что данные не пусты
        if (!Validator::noEmptyString($_POST['name-input'])){
            $res["status"] = "false";
            $res["errors"][ "name-input"] = "Поле обязательно к заполнению!";
        }
        if (!Validator::noEmptyString($_POST['price-input'])){
            $res["status"] = "false";
            $res["errors"][ "price-input"] = "Поле обязательно к заполнению!";
        }
        if (!Validator::noEmptyString($_POST['date-input'])){
            $res["status"] = "false";
            $res["errors"][ "date-input"] = "Поле обязательно к заполнению!";
        }

        if($res["status"] === "false"){
            return $res;
        }

        if (!is_numeric($_POST['price-input'])){
            $res["status"] = "false";
            $res["errors"][ "price-input"] = "Значение поля должно быть числом!";
        }

        if (!Validator::isDateTimeFormat($_POST['date-input'])){
            $res["status"] = "false";
            $res["errors"][ "date-input"] = "Значение поля необходимо ввести в формате дд.мм.гггг --:--";
        }

        return $res;
    }
}