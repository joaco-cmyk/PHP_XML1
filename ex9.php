<?php
$xml = simplexml_load_file("text.xml") or die("Error: Cannot create object");
$xml = new SimpleXMLElement($xml->asXML());
echo $xml->saveXML();
?>
