<?PHP

$name = $_GET['name'] ?? '';
$phone = $_GET['phone'] ?? '';
$prueba = <<<XML
<prueba>
    <apellidos>Zamora</apellidos>
</prueba>
XML;

   $xml = new SimpleXMLElement($prueba);
   $xml -> addChild("name", $name);
   $xml -> addChild("phone", $phone);

header('Content-Type: application/xml; charset=UTF-8');
echo $xml->asXML();