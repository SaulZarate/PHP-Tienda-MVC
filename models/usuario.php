<?php 

    class Usuario{

        // Estos atributos los mismo que estan en la base de datos
        private $id;
        private $nombre;
        private $apellidos;
        private $email;
        private $password;
        private $rol;
        private $imagen;

        private $db;

        public function __construct(){
            $this->db = DataBase::connect();
        }

        /* GETTERS */
        function getId(){
            return $this->id;
        }
        function getNombre(){
            return $this->nombre;
        }
        function getApellidos(){
            return $this->apellidos;
        }
        function getEmail(){
            return $this->email;
        }
        function getPassword(){
            return password_hash($this->db->escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4] );
        }
        function getRol(){
            return $this->rol;
        }
        function getImagen(){
            return $this->imagen;
        }

        /* SETTERS */
        function setId($id){
            $this->id = $id ;
        }
        function setNombre($nombre){
            $this->nombre = $this->db->escape_string($nombre);
        }
        function setApellidos($apellidos){
            $this->apellidos = $this->db->escape_string($apellidos);
        }
        function setEmail($email){
            $this->email = $this->db->escape_string($email);
        }
        function setPassword($password){
            $this->password = $password;
        }
        function setRol($rol){
            $this->rol = $rol ;
        }
        function setImagen($imagen){
            $this->imagen = $imagen ;
        }

        /* Guarda el objeto en la base de datos */
        public function save(){
            $sql = "INSERT INTO usuarios VALUES(null, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null);";
            $save = $this->db->query($sql);

            $result = false;
            if($save){
                $result = true;
            }

            return $result;
        }

        public function login(){
            $result = false;
            
            $email = $this->email;
            $password = $this->password;
            
            // Comprobar si existe el usuario
            $sql = "SELECT * FROM usuarios WHERE email = '$email'";
            $login = $this->db->query($sql);
            
            if( $login && $login->num_rows == 1 ){
                $usuario = $login->fetch_object(); // Objeto del registro obtenido en la consulta 
                
                $verify = password_verify($password, $usuario->password);
                if( $verify ){
                    $result = $usuario;
                }
            }

            return $result;
        }

    }


?>