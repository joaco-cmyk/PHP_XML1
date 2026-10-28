<?php
$xml = simplexml_load_file("text.xml") or die("Error: Cannot create object");
$xml = new SimpleXMLElement($xml->asXML());
header("Content-Type: application/xml; charset=UTF-8");
echo $xml->asXML();
?>
