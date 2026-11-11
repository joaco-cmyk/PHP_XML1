<?php

class clsUser
{
    private string $dni;
    private string $name;
    private string $lastname;
    private string $age;
    private string $password;

    public function __construct()
    {
        // Constructor logic
    }

    public function Login()
    {
        $users = simplexml_load_file('users.xml');
        foreach ($users->user as $U) {
            if ((string) $u->username === $this->username && (string) $u->password === $this->password) {
                
            }
        }
    }

    public function Logout()
    {
    }

    public function Register()
    {
        echo 'Registro ejecutado';
        $name = $this->name;
        $password = $this->password;
        $lastname = $this->lastname;
        $dni = $this->dni;
        $age = $this->age;

        $users = simplexml_load_file('users.xml');

        $newUser = $users->addChild('user');

        if ($name === null) {
            echo "Error: No se ha indicado nombre\n";
            return false;
        } else {
            $newUser->addChild('name', $name);
        }

        if ($password === null) {
            echo "Error: No se ha indicado contraseña\n";
            return false;
        } else {
            $newUser->addChild('password', $password);
        }

        if ($lastname === null) {
            echo "Error: No se ha indicado apellido\n";
            return false;
        } else {
            $newUser->addChild('last_name', $lastname);
        }

        if ($dni === null) {
            echo "Error: No se ha indicado DNI\n";
            return false;
        } else {
            $newUser->addChild('dni', $dni);
        }

        if ($age === null) {
            echo "Error: No se ha indicado edad\n";
            return false;
        } else {
            $newUser->addChild('age', $age);
        }

        $this->saveXmlFile($users, 'users.xml');
        return true;
    }

    public function saveXmlFile($xml, $file) {
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($file);
    }
    public function setDni($pParam)
    {
        $this->dni = $pParam;
    }

    public function setName($pParam)
    {
        $this->name = $pParam;
    }

    public function setLast_name($pParam)
    {
        $this->lastname = $pParam;
    }

    public function setPassword($pParam)
    {
        $this->password = $pParam;
    }

    public function setAge($pParam)
    {
        $this->age = $pParam;
    }
}
?>