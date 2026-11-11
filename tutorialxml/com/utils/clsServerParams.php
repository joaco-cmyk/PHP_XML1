<?php

class clsServerParams
{
    public function __constructor()
    {

    }

    public function get($pParam)
    {
        $parameter = $_GET[$pParam];
        echo $parameter . ' Como ' . $pParam . ' ';
        return $parameter;
    }

}

?>