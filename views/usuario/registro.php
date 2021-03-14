<h1>Registrarse</h1>

<?php if ( isset($_SESSION["register"]) &&  $_SESSION["register"] == "complete" ) : ?>

    <strong class="alert_green">Registro completado correctamente</strong>

<?php elseif( isset($_SESSION["register"]) &&  $_SESSION["register"] == "failed" ) : ?>

    <strong class="alert_red">Registro fallido, introduce bien los datos</strong>

<?php endif; ?>
<!-- Borro la variable de session register con el metodo estatico de la clase Utils -->
<?php Utils::deleteSession("register"); ?>

<form action="<?= base_url ?>usuario/save" method="POST">

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" required>

    <label for="apellido">Apellido</label>
    <input type="text" name="apellidos" id="apellidos" required>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="password" id="password" required>

    <input type="submit" name="submit" value="Registrarse">
</form>