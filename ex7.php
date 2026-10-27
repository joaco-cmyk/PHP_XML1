<?php
$note=<<<XML
<note>
<to>Tove</to>
<from>Jani</from>
<heading>Reminder</heading>
<body date="2014-01-01" type="private">Do not forget me this weekend!</body>
</note>
XML;

$xml = simplexml_load_string($note);

foreach($xml->body[0]->attributes() as $a => $b)
  {
  echo $a,'="',$b,"<br>";
  }
?>
