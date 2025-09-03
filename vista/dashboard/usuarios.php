<?php
include 'header.php';
include_once '../../controlador/controlador_usuarios.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Gestión de Usuarios</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearUsuario">
        <i class="fas fa-plus"></i> Nuevo Usuario
    </button>
</div>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (isset($exito)): ?>
<div class="alert alert-success"><?php echo $exito; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = $usuarios->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $usuario['id_usuario']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['usuario']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditarUsuario"
                                    data-id="<?php echo $usuario['id_usuario']; ?>"
                                    data-nombre="<?php echo $usuario['nombre']; ?>"
                                    data-apellido="<?php echo $usuario['apellido']; ?>"
                                    data-usuario="<?php echo $usuario['usuario']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <?php if ($usuario['id_usuario'] != $_SESSION['id_usuario']): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">
                                <button type="submit" name="eliminar_usuario" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="modalCrearUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellido" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" name="confirmar_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="crear_usuario" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="apellido" id="edit_apellido" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" class="form-control" name="usuario" id="edit_usuario" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña (opcional)</label>
                        <input type="password" class="form-control" name="password">
                        <div class="form-text">Dejar en blanco para mantener la contraseña actual</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="actualizar_usuario" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Script para cargar datos en el modal de edición
document.addEventListener('DOMContentLoaded', function() {
    const modalEditar = document.getElementById('modalEditarUsuario');
    modalEditar.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const apellido = button.getAttribute('data-apellido');
        const usuario = button.getAttribute('data-usuario');
        
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_apellido').value = apellido;
        document.getElementById('edit_usuario').value = usuario;
    });
});
</script>

<?php include 'footer.php'; ?>