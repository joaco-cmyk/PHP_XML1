<?php
    $note = <<<XML
        <note>
            <to>Tove</to>
            <from>Jani</from>
            <heading>Reminder</heading>
            <body>Don't forget me this weekend!</body>
        </note>
    XML;

    header("Content-Type: application/xml; charset=UTF-8");
    $xml=new SimpleXMLElement($note);
    echo $xml ->asXML();
?>