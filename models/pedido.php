<?php 


class Pedido{
    
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    private $db;

    public function __construct(){
        $this->db = DataBase::connect();
    }

    /* GETTERS */
    public function getId(){
        return $this->id;
    }
    public function getUsuario_id(){
        return $this->usuario_id;
    }
    public function getProvincia(){
        return $this->provincia;
    }
    public function getLocalidad(){
        return $this->localidad;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getCoste(){
        return $this->coste;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getOferta(){
        return $this->oferta;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getHora(){
        return $this->hora;
    }

    /* SETTERS */
    public function setId($id){
        $this->id = $id;
    }
    public function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }
    public function setProvincia($provincia){
        $this->provincia = $this->db->real_escape_string($provincia);
    }
    public function setLocalidad($localidad){
        $this->localidad = $this->db->real_escape_string($localidad);
    }
    public function setDireccion($direccion){
        $this->direccion = $this->db->real_escape_string($direccion);
    }
    public function setCoste($coste){
        $this->coste = $coste;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
    public function setOferta($oferta){
        $this->oferta = $oferta;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }
    public function setHora($hora){
        $this->hora = $hora;
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ METODOS ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function getAll(){
        $productos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC");
        return $productos;
    }

    // Devuelve un pedido por id
    public function getOne(){
        $productos = $this->db->query("SELECT * FROM pedidos WHERE id = {$this->id}");
        return $productos->fetch_object();
    }

    // Devuelve todos los pedidos por usuario (id)
    public function getAllByUser(){
        $sql = "SELECT p.* FROM pedidos p "
            ."WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC ";

        $pedido = $this->db->query($sql);
        
        return $pedido;
    }

    // Devuelve el ultimo pedido de un usuario por id
    public function getOneByUser(){
        $sql = "SELECT p.id, p.coste FROM pedidos p "
            ."WHERE p.usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1";
        $pedido = $this->db->query($sql);
        
        return $pedido->fetch_object();
    }

    public function getProductsByPedido($id){
        /* $sql = "SELECT * FROM productos WHERE id IN "
                ."( SELECT producto_id FROM lineas_pedidos WHERE pedido_id = $id ) "; */

        $sql = "SELECT pr.* , lp.unidades FROM productos pr "
                ." INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
                ." WHERE pedido_id = $id ";

        $producto = $this->db->query($sql);
        
        return $producto;
    }

    public function save(){
        $sql = "INSERT INTO pedidos VALUES(null, '{$this->getUsuario_id()}', '{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm',CURDATE(),CURTIME() );";
        $save = $this->db->query($sql);

        $result = false;
        if($save){
            $result = true;
        }

        return $result;
    }

    // Guarda los datos del pedido y el producto en la tabla lineas_pedidos
    public function save_linea(){
        $sql = "SELECT LAST_INSERT_ID() as 'pedido' "; // Retorna id del ultimo insert que se hizo
        $query = $this->db->query($sql);
        $pedido_id = $query->fetch_object()->pedido;
        
        foreach( $_SESSION["carrito"] as $elemento ){
            $producto = $elemento["producto"];
            
            $inser = "INSERT INTO lineas_pedidos VALUES (NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']} )";
            $save = $this->db->query($inser);

            
        }

        $result = false;
        if( $save ){
            $result = true;
        }

        return $result;
    }

    public function edit(){
        $sql = "UPDATE pedidos SET estado = '{$this->estado}' ";
        $sql .= " WHERE id = {$this->id} ";

        $save = $this->db->query($sql);
        
        $result = false;
        if( $save ){
            $result = true;
        }

        return $result;
    }

} // Fin de la clase
