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

// Add a child element to the body element
$xml->body->addChild("date","2014-01-01");

// Add a child element after the last element inside note
$footer = $xml->addChild("footer","Some footer text");
header("Content-Type: application/xml; charset=UTF-8");
echo $xml->saveXML("text.xml");
$xml->save("test.xml");
?>