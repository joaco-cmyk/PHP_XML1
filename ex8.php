<?php
$note=<<<XML
<note>
<to>Tove</to>
<from>Jani</from>
<heading>Reminder</heading>
<body>Do not forget me this weekend!</body>
</note>
XML;

$xml=simplexml_load_string($note);
foreach ($xml->children() as $child)
  {
  echo "Child node: " . $child . "<br>";
  }
?>