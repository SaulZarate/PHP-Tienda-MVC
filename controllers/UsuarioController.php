<?php

require_once "models/usuario.php";

class UsuarioController{

    public function index(){
        echo "Controlador Usuarios, Accion index";
    }
    public function registro(){
        require_once "views/usuario/registro.php";
    }
    public function save(){

        if (isset($_POST)) {
            $usuario = new Usuario();

            $nombre = (isset($_POST["nombre"])) ? $_POST["nombre"] : false;
            $apellidos = (isset($_POST["apellidos"])) ? $_POST["apellidos"] : false;
            $email = (isset($_POST["email"])) ? $_POST["email"] : false;
            $password = (isset($_POST["password"])) ? $_POST["password"] : false;

            if ($nombre && $apellidos && $email && $password) {

                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $save = $usuario->save();

                if ($save) {
                    $_SESSION["register"] = "complete";
                } else {
                    $_SESSION["register"] = "failed";
                }

            }else{
                $_SESSION["register"] = "failed";
            }

        } else {
            $_SESSION["register"] = "failed";
        }

        /* Redirecciono a la pagina de registro */
        header("Location: " . base_url . "usuario/registro");

    }
    public function login(){
        if( isset($_POST) ){
            // Identificar al usuario
            // Consulta a la base de datos
            $usuario = new Usuario();
            $usuario->setEmail($_POST["email"]);
            $usuario->setPassword($_POST["password"]);

            $identity = $usuario->login(); // Retorna un objeto usuario o false
            
            if( $identity && is_object($identity) ){
                $_SESSION["identity"] = $identity;
                if( $identity->rol == "admin"){
                    $_SESSION["admin"] = true;
                }
            }else{
                $_SESSION["error_login"] = "Identificacion fallida";
            }

            // Crear una Session
        }

        header("Location: " . base_url);
    }
    // Cerrar sesion
    public function logout(){
        if( isset($_SESSION["identity"]) ){
            unset($_SESSION["identity"]);
            
        }
        if( isset($_SESSION["admin"]) ){
            unset($_SESSION["admin"]);
            
        }
        header("Location: ".base_url);
    }

} // Fin de la clase
