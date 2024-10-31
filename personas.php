<?php
session_start();
require_once("../../conexion.php");
require_once("../../libreria_menu.php");

// Consulta para obtener los datos de las personas

$sql = $db->Prepare("SELECT *
                     FROM personas
                     WHERE _estado <> 'X' 
                     /*AND id_persona > 1*/
                     ORDER BY id_persona DESC");

$rs = $db->GetAll($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Personas</title>
    <style>
        thead{
            color: black;
            background: #b5b5b5;
        }
        .card{
            margin: 20px;
        }
        tr{
            color: black;
        }
        .form-control{
            border-color: black;
        }
        .formita{
            padding: 25px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
           <h3>GESTIÓN PERSONAS</h3>
        </div>
       
        <div class="card-body">
        <form  action="#.php" method="post" name="formu" class="formita">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ci" class="form-label">(*) C.I.</label>
                                <input type="text" class="form-control" name="ci" id="ci" size="10" onKeyUp="buscar_personas()">
                            </div>
                            <div class="col-md-6">
                                  <label for="paterno" class="form-label">Paterno</label>
                                  <input type="text" class="form-control" name="paterno" id="paterno" size="20" onKeyUp="buscar_personas()">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="materno" class="form-label">Materno</label>
                                <input type="text" class="form-control" name="materno" id="materno" size="20" onKeyUp="buscar_personas()">
                            </div>
                            <div class="col-md-6">
                                <label for="nombres" class="form-label">(*) Nombres</label>
                                <input type="text" class="form-control" name="nombres" id="nombres" size="20" onKeyUp="buscar_personas()">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="fecha" id="fecha" size="20" onKeyUp="buscar_personas()">
                            </div>
                        </div>
                    </form>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="persona_nuevo.php" class="btn btn-success" role="button">Añadir Persona</a>
        </div>
        <p></p>
        <div id="personas1">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">C.I.</th>
                        <th scope="col">Paterno</th>
                        <th scope="col">Materno</th>
                        <th scope="col">Nombres</th>
                        <th scope="col"><img src='../../imagenes/modificar.gif'></th>
                        <th scope="col"><img src='../../imagenes/borrar.jpeg'  ></th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($rs) : ?>
                <?php $b = 1; ?>
                <?php foreach ($rs as $fila) : ?>

                    <tr>
                    <td><?php echo $b; ?></td>
                        <td><?php echo $fila['ci']; ?></td>
                        <td><?php echo $fila['ap']; ?></td>
                        <td><?php echo $fila['am']; ?></td>
                        <td><?php echo $fila['nombres']; ?></td>
                        <td>
                            <form name="formModif<?php echo $fila['id_persona']; ?>" method="post" action="persona_modificar.php" style="display:inline;">
                                <input type="hidden" name="id_persona" value="<?php echo $fila['id_persona']; ?>">
                                <button type="submit" class="btn btn-sm btn-primary btn-accion">Modificar</button>
                            </form>
                        </td>
                        <td>
                            <form name="formElimi<?php echo $fila['id_persona']; ?>" method="post" action="persona_eliminar.php" style="display:inline;">
                                <input type="hidden" name="id_persona" value="<?php echo $fila['id_persona']; ?>">
                                <button type="submit" class="btn btn-sm btn-danger btn-accion" onclick="return confirm('Desea realmente eliminar a la persona <?php echo $fila['nombres']; ?> <?php echo $fila['ap']; ?> <?php echo $fila['am']; ?> ?');">Eliminar</button>
                            </form>
                        </td>

                    </tr>
                <?php $b++; ?>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.table').DataTable({
                "paging": true,          // Habilita la paginación
                "searching": false,       // Habilita la búsqueda
                "info": false,            // Muestra la información de la tabla
                "lengthChange": true,    // Permite cambiar el número de filas mostradas
                "responsive": false       // Hace la tabla responsive
            });
        });
    </script>
</body>
</html>
