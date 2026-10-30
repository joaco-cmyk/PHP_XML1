<?php


$xml = new SimpleXMLElement('<products/>');


$product = $xml->addChild('product');
$product->addChild('id', '1');
$product->addChild('name', 'Laptop');
$product->addChild('price', '899');


$product = $xml->addChild('product');
$product->addChild('id', '2');
$product->addChild('name', 'Mouse');
$product->addChild('price', '25');




$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$dom->save('products.xml');


?>

