<?php
$note=<<<XML
<note>
<to>Tove</to>
<from>Jani</from>
<heading>Reminder</heading>
<body>Do not forget me this weekend!</body>
</note>
XML;

$xml = new SimpleXMLElement($note);
header("Content-Type: application/xml; charset=UTF-8");
echo $xml->saveXML();
?>