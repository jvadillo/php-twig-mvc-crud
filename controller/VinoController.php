<?php
class VinoController{

    private $conectar;
    private $conexion;
    private $twig;

    public function __construct() {
		require_once  __DIR__ . "/../core/Conectar.php";
        require_once  __DIR__ . "/../model/Vino.php";
        
        $this->conectar=new Conectar();
        $this->conexion=$this->conectar->conexion();

        $loader = new Twig_Loader_Filesystem('view');
        $this->twig = new Twig_Environment($loader, array('debug' => true));

    }

   /**
    * Ejecuta la acción correspondiente.
    *
    */
    public function run($accion){
        switch($accion)
        { 
            case "index" :
                $this->index();
                break;
            case "nuevo" :
                $this->nuevo();
                break;
            case "alta" :
                $this->crear();
                break;
            case "detalle" :
                $this->detalle();
                break;
            case "actualizar" :
                $this->actualizar();
                break;
            case "borrar" :
                $this->borrar();
                break;
            default:
                $this->index();
                break;
        }
    }

    /**
    * Carga la página principal de bodegas con la lista de
    * bodegas que consigue del modelo.
    *
    */ 
    public function detalle(){


        $vino = new Vino($this->conexion);
        $result = $vino ->getById($_GET["id"]);
        
        echo $this->twig->render('detalleVinoView.html', array(
            "vino" => $result,
            "bodega" => $_GET["bodega"],
            "titulo" => "Detalle Vino"
        ));
    }

    public function nuevo(){

        echo $this->twig->render('detalleVinoView.html', array(
            "bodega" => $_GET["bodega"],
            "titulo" => "Nuevo Vino"
        ));
    }

    public function borrar(){
        
        //Creamos el objeto bodega
        $vino = new Vino($this->conexion);
        //Recuperamos de BBDD la bodega
        $vino = $vino->deleteById($_GET["id"]);
        
        header("Location: index.php?controller=bodega&action=detalle&id=" . $_GET["bodega"]);
    }
    
   /**
    * Crea una nuevo bodega a partir de los parámetros POST 
    * y vuelve a cargar el index.php.
    *
    */
    public function crear(){
        if(isset($_POST["nombre"])){
            
            //Creamos una bodega
            $vino=new Vino($this->conexion);
            $vino->setNombre($_POST["nombre"]);
            $vino->setDescripcion($_POST["descripcion"]);
            $vino->setBodega($_POST["bodega"]);
            $vino->setTipo($_POST["tipo"]);
            $vino->setAno($_POST["ano"]);
            $vino->setAlcohol($_POST["alcohol"]);

            $save = $vino->guardar();
        }
        header("Location:index.php?controller=bodega&action=detalle&id=".$_POST["bodega"]);
    }

   /**
    * Actualiza bodega a partir de los parámetros POST 
    * y vuelve a cargar el index.php.
    *
    */
    public function actualizar(){
        if(isset($_POST["id"])){
            
            //Creamos un vino
            $vino=new Vino($this->conexion);
            $vino->setId($_POST["id"]);
            $vino->setNombre($_POST["nombre"]);
            $vino->setDescripcion($_POST["descripcion"]);
            $vino->setBodega($_POST["bodega"]);
            $vino->setTipo($_POST["tipo"]);
            $vino->setAno($_POST["ano"]);
            $vino->setAlcohol($_POST["alcohol"]);
            $save=$vino->actualizar();
        }
        header("Location:index.php?controller=bodega&action=detalle&id=".$_POST["bodega"]);
    }
    
    
   /**
    * Crea la vista que le pasemos con los datos indicados.
    *
    */
    public function view($vista,$datos){
        $data = $datos;  
        require_once  __DIR__ . "/../view/" . $vista . "View.php";

    }

}
?>
