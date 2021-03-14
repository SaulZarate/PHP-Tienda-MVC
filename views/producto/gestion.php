<h1>Gestion de productos</h1>

<a href="<?=base_url?>producto/crear" class="button button-small">Crear producto</a>

<?php if( isset($_SESSION["producto"]) && $_SESSION["producto"] == "complete" ):?>
    <strong class="alert_green" >El producto se a creado correctamente</strong>
<?php elseif( isset($_SESSION["producto"]) && $_SESSION["producto"] != "complete" ): ?>
    <strong class="alert_red">El producto No se ha agregado</strong>
<?php endif;?>
<?php Utils::deleteSession("producto") ?>

<?php if( isset($_SESSION["delete"]) && $_SESSION["delete"] == "complete" ):?>
    <strong class="alert_green" >El producto se a borrado</strong>
<?php elseif( isset($_SESSION["delete"]) && $_SESSION["delete"] != "complete" ): ?>
    <strong class="alert_red">El producto no se a borrado</strong>
<?php endif;?>
<?php Utils::deleteSession("delete") ?>

<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>PRECIO</th>
        <th>STOCK</th>
        <th>ACCIONES</th>
    </tr>
    <?php while ($pro = $productos->fetch_object()) : ?>
        <tr>
            <td><?=$pro->id;?></td>
            <td><?=$pro->nombre;?></td>
            <td><?=$pro->precio;?></td>
            <td><?=$pro->stock;?></td>
            <td>
                <!-- Al enviar el id por GET hay que tener en cuenta que es la TERCER VARIABLE POR GET
                     y que debido a esto, hay que utilizar & para poder recibirlo en la ptra pagina -->
                <a href="<?=base_url?>producto/editar&id=<?=$pro->id?>" class="button button-gestion">Editar</a>
                <a href="<?=base_url?>producto/eliminar&id=<?=$pro->id?>" class="button button-gestion button-red">Eliminar</a>
            </td>

        </tr>
    <?php endwhile; ?>
</table>