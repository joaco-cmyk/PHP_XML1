<?php


$products = [
   [
       "id" => 1,
       "name" => "Zapatillas",
       "price" => 90,
       "description" => "Zapatillas de alta competición",
       "age" => 25
   ],
   [
       "id" => 2,
       "name" => "Plantillas",
       "price" => 120,
       "description" => "Plantillas personalizadas",
       "age" => 30
   ],
   [
       "id" => 3,
       "name" => "Balón",
       "price" => 40,
       "description" => "Balón Wilson",
       "age" => 35
   ],
   [
       "id" => 4,
       "name" => "Pantalón",
       "price" => 15,
       "description" => "Pantalón deportivo",
       "age" => 28
   ],
   [
       "id" => 5,
       "name" => "Camiseta",
       "price" => 25,
       "description" => "Camiseta de entrenamiento",
        "age" => 22
   ]
];


$xml = new SimpleXMLElement("<products/>");


foreach ($products as $product) {


   $item = $xml->addChild("product");


   foreach ($product as $key => $value) {
       $item->addChild($key, htmlspecialchars((string)$value, ENT_XML1, "UTF-8"),
       $item->addAttribute("id", (string)$product["id"])
       );
   }
}

header("Content-Type: application/xml; charset=UTF-8");

echo $xml->asXML();

?>