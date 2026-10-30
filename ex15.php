<?php
$xmlString = <<<XML
<root>
    <item>Primero</item>
    <item>Segundo</item>
    <item>Tercero</item>
</root>
XML;

$xml = new SimpleXMLElement($xmlString);

// Eliminar el segundo elemento (<item> con índice 1)
unset($xml->item[1]);

// Mostrar el XML resultante
Header('Content-type: text/xml');
echo $xml->asXML();
?>
