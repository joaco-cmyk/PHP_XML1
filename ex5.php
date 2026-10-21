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

$result = $xml->xpath("/note/to");

print_r($result);
?>