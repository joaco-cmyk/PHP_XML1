<?php


   $name="Raphina";


   $note=<<<XML
   <note>
       <name>{$name}</name>
       <phone>{$phone}</phone>
       <to>Tove22222222</to>
       <from>Jani</from>
       <heading>Reminder</heading>
       <body type="ordinary" class="B">Do not forget me this weekend!</body>
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
   $r->addAttribute("id","direct_message");
foreach($xml->body[0]->attributes() as $a => $b)
  {
  $r->addAttribute($a,$b);
  }
foreach($xml->children() as $child)
    {
        $r->addChild($child->getName(), (string)$child);
    }
   header("Content-Type: application/xml; charset=UTF-8");
   echo $r->asXML();

?>
