<?php

class GenericController{

    protected $conectar;
    protected $conexion;
    protected $twig;

    public function __construct() {
		require_once  __DIR__ . "/../core/Conectar.php";
        
        
        

		$this->conectar=new Conectar();
        $this->conexion=$this->conectar->conexion();
        $loader = new Twig_Loader_Filesystem('view');
        $this->twig = new Twig_Environment($loader, array('debug' => true));

    }

}









