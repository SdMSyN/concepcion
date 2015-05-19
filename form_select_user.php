<?php
session_start();
include('config/conexion.php');
include('header.php');
include ('menu.php');
if (!isset($_SESSION['sessA']))
    echo '<div class="row"><div class="col-sm-12 text-center"><h2>No ha iniciado sesión de Administrador</h2></div></div>';
else if ($_SESSION['perfil'] != "1")
    echo '<div class="row><div class="col-sm-12 text-center"><h2>No tienes permiso para entrar a esta sección</h2></div></div>';
else {
    $userId = $_SESSION['userId'];

    /* Obtenemos los usuarios activos */
    $sqlGetUsers = "SELECT id, CONCAT(nombre,' ',ap,' ',am) as nombre, (SELECT perfil FROM $tPerfil WHERE id=$tUser.perfil_id) as perfil, created FROM $tUser WHERE activo='1' ";
    $resGetUsers = $con->query($sqlGetUsers);
    $optUsers = '';
    if ($resGetUsers->num_rows > 0) {
        while ($rowGetUsers = $resGetUsers->fetch_assoc()) {
            $optUsers .= '<tr>';
            $optUsers .= '<td>' . $rowGetUsers['id'] . '</td>';
            $optUsers .= '<td>' . $rowGetUsers['nombre'] . '</td>';
            $optUsers .= '<td>' . $rowGetUsers['created'] . '</td>';
            $optUsers .= '<td>' . $rowGetUsers['perfil'] . '</td>';
            $optUsers .= '<td><a href="form_update_user.php?id='.$rowGetUsers['id'].'" >Modificar</a></td>';
            $optUsers .= '<td><a class="delete" data-id="'.$rowGetUsers['id'].'" >Dar de baja</a></td>';
            $optUsers .= '</tr>';
        }
    } else {
        $optUsers.='<tr><td colspan="4">No existen usuarios aún.</td></tr>';
    }
    
    /* Obtenemos los perfiles */
    $sqlGetPerfils="SELECT id, perfil FROM $tPerfil ";
    $resGetPerfils=$con->query($sqlGetPerfils);
    $optPerfils = '<option></option>';
    while($rowGetPerfils = $resGetPerfils->fetch_assoc()){
        $optPerfils .= '<option value="'.$rowGetPerfils['id'].'">'.$rowGetPerfils['perfil'].'</option>';
    }
    
    ?>

    <!-- Cambio dinamico -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 error"></div>
            <div class="col-md-12">
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAdd">
                    Nuevo Usuario
                </button>
            </div>	  
        </div>
        <table border="2">
            <thead>
                <tr>
                    <td>Id</td><td>Nombre</td><td>Fecha de creación</td><td>Perfil</td><td>Modificar</td><td>Eliminar</td>
                </tr>
            </thead>
            <tbody>
    <?= $optUsers; ?>
            </tbody>    
        </table>
        
        <!-- Modal -->
        <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
                        </div>
                        <form id="formAddUser" name="formAddUser" method="POST">
                            <div class="error"></div>
                            <legend>Añadir nuevo usuario</legend>
                            <label>Nombre</label>
                            <input type="text" id="inputNombre" name="inputNombre" >
                            <label>Apellido Paterno</label>
                            <input type="text" id="inputAP" name="inputAP" >
                            <label>Apellido Materno</label>
                            <input type="text" id="inputAM" name="inputAM" >
                            <label>Usuario</label>
                            <input type="text" id="inputUser" name="inputUser" >
                            <label>Contraseña</label>
                            <input type="text" id="inputPass" name="inputPass" >
                            <label>Perfil</label>
                            <select id="inputPerfil" name="inputPerfil">
                                <?= $$optPerfils; ?>
                            </select>
                            <label>Dirección</label>
                            <input type="text" id="inputDir" name="inputDir" >
                            <label>Número Interior</label>
                            <input type="text" id="inputNumInt" name="inputNumInt" >
                            <label>Número Exterior</label>
                            <input type="text" id="inputNumExt" name="inputNumExt" >
                            <label>Colonia</label>
                            <input type="text" id="inputCol" name="inputCol" >
                            <label>Municipio</label>
                            <input type="text" id="inputMun" name="inputMun" >
                            <label>Teléfono</label>
                            <input type="number" id="inputTel" name="inputTel" >
                            <label>Celular</label>
                            <input type="number" id="inputCel" name="inputCel" >
                            <label>Fecha de nacimiento</label>
                            <input type="date" id="inputNacimiento" name="inputNacimiento" >

                            <button type="submit" >Añadir</button>
                        </form>
                    </div>
                </div>
            </div>
        
        <!-- Modal Update -->
        <div class="modal fade" id="myModalUpd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
                        </div>
                        <div class="modal-body">
                            <form id="formAddUser" name="formAddUser" method="POST">
                                <input type="text" id="inputUserUpd" name="inputUserUpd">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div><!-- fin container -->

    <script type="text/javascript">
        $(document).ready(function () {
            
            $('.delete').click(function(){
                var idUserDel=$(this).data('id');
                alert("Eliminando..."+idUserDel);
            });
            
            $('#formAddUser').validate({
                rules: {
                    inputNombre: {required: true},
                    inputAP: {required: true},
                    inputAM: {required: true},
                    //inputUser: {required: true},
                    inputPass: {required: true, digits: true},
                    inputPerfil: {required: true},
                    //inputDir: {required: true},
                    //inputNumInt: {required: true},
                    //inputNumExt: {required: true},
                    //inputCol: {required: true},
                    //inputMun: {required: true},
                    inputTel: {digits: true},
                    inputCel: {digits: true}
                    //inputNacimiento: {required: true}
                },
                messages: {
                    inputNombre: "Nombre obligatorio",
                    inputAP: "Apellido paterno obligatorio",
                    inputAM: "Apellido materno obligatorio",
                    inputPass: {
                        required: "Contraseña obligatoria",
                        digits: "La contraseña solo permite dígitos"
                    },
                    inputPerfil: "Debes seleccionar un perfil para el usuario",
                    inputTel: "Solo se aceptan dígitos",
                    inputCel: "Solo se aceptan dígitos"
                },
                tooltip_options: {
                    inputCategory: {trigger: "focus", placement: 'bottom'},
                    inputCategory: {trigger: "focus", placement: 'bottom'},
                    inputNombre: {trigger: "focus", placement: 'bottom'},
                    inputAP: {trigger: "focus", placement: 'bottom'},
                    inputAM: {trigger: "focus", placement: 'bottom'},
                    inputPass: {trigger: "focus", placement: 'bottom'},
                    inputPerfil: {trigger: "focus", placement: 'bottom'},
                    inputTel: {trigger: "focus", placement: 'bottom'},
                    inputCel: {trigger: "focus", placement: 'bottom'}
                },
                submitHandler: function (form) {
                    $.ajax({
                        type: "POST",
                        url: "controllers/create_user.php",
                        data: $('form#formAddUser').serialize(),
                        success: function (msg) {
                            //alert(msg);
                            if (msg == "true") {
                                $('.error').html("Se creo el usuario con éxito.").css({color: "#00FF00"});
                                setTimeout(function () {
                                    location.href = 'form_select_user.php';
                                }, 3000);
                            } else {
                                $('.error').css({color: "#FF0000"});
                                $('.error').html(msg);
                            }
                        },
                        error: function () {
                            alert("Error al crear usuario ");
                        }
                    });
                }

            });
        });
    </script>

    <?php
}//fin else sesión
include ('footer.php');
?>