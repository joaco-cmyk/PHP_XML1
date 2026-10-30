<?php

$file = "text.xml";
$xml = simplexml_load_file($file);

unset($xml->note[0]->to);
$xml->asXML($file);