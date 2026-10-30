<?php
$note=<<<XML
<note>
<to>
    <person>Tove</person>
    <from>
        <person>Jani</person>
        <heading id="1">Reminder</heading>
    </from>
</to>
<from>Jani</from>
<heading id="1">Reminder</heading> 
<body>Do not forget me this weekend!</body>
</note>
XML;

$xml = new SimpleXMLElement($note);
$result = $xml->xpath("/note/to/from");
// Forma uno
$xml->to->from->heading['id'] = '3';
// Forma dos
$result[0]->heading['id'] = '4';
header("Content-Type: application/xml; charset=UTF-8");
echo $xml->asXML();