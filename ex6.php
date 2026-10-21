<?php


   $name="Raphina";


   $note=<<<XML
   <note>
       <name>{$name}</name>
       <to>Tove22222222</to>
       <from>Jani</from>
       <heading>Reminder</heading>
       <body>Do not forget me this weekend!</body>
   </note>
   XML;


   $xml = new SimpleXMLElement($note);
   $result = $xml->xpath("/note/name");


   //print_r($result);
//die;
   $masage=<<<XML
       <message>
           {$result[0]}
       </message>
   XML;


   $r = new SimpleXMLElement($masage);


   header("Content-Type: application/xml; charset=UTF-8");
   echo $r->asXML();


?>
