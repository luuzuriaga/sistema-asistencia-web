<?php
include 'header.php';
include_once '../../controlador/controlador_usuarios.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Mi Perfil</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" value="<?php echo explode(' ', $_SESSION['nombre'])[0]; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" value="<?php echo explode(' ', $_SESSION['nombre'])[1]; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" class="form-control" value="<?php echo $_SESSION['usuario']; ?>" disabled>
                    </div>
                    
                    <hr>
                    <h5>Cambiar Contraseña</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" name="password_actual" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" name="nueva_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" name="confirmar_password" required>
                    </div>
                    
                    <button type="submit" name="cambiar_password" class="btn btn-primary">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>