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
    $userId = $_GET['id'];

    /* Obtenemos los usuarios activos */
    $sqlGetUser = "SELECT * FROM $tUser WHERE id='$userId' ";
    $resGetUser = $con->query($sqlGetUser);
    $rowGetUser = $resGetUser->fetch_assoc();
    
    /* Obtenemos los perfiles */
    $sqlGetPerfils="SELECT id, perfil FROM $tPerfil ";
    $resGetPerfils=$con->query($sqlGetPerfils);
    $optPerfils = '<option></option>';
    while($rowGetPerfils = $resGetPerfils->fetch_assoc()){
        if($rowGetPerfils['id'] == $rowGetUser['perfil_id'])
            $optPerfils .= '<option value="'.$rowGetPerfils['id'].'" selected>'.$rowGetPerfils['perfil'].'</option>';
        else
            $optPerfils .= '<option value="'.$rowGetPerfils['id'].'">'.$rowGetPerfils['perfil'].'</option>';
    }
    
    ?>

    <!-- Cambio dinamico -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 error"></div>
            <div class="col-md-12">
                <form id="formUpdUser" name="formUpdUser" method="POST">
                    <div class="error"></div>
                    <legend>Modificación de datos de: <?= $rowGetUser['nombre'].' '.$rowGetUser['ap'].' '.$rowGetUser['am']; ?></legend>
                    <input type="hidden" value="<?= $rowGetUser['id']; ?>" name="idUser">
                    <label>Nombre</label>
                    <input type="text" id="inputNombre" name="inputNombre" value="<?= $rowGetUser['nombre']; ?>">
                    <label>Apellido Paterno</label>
                    <input type="text" id="inputAP" name="inputAP" value="<?= $rowGetUser['ap']; ?>" >
                    <label>Apellido Materno</label>
                    <input type="text" id="inputAM" name="inputAM" value="<?= $rowGetUser['am']; ?>" >
                    <label>Usuario</label>
                    <input type="text" id="inputUser" name="inputUser" value="<?= $rowGetUser['user']; ?>" >
                    <label>Contraseña</label>
                    <input type="text" id="inputPass" name="inputPass" value="<?= $rowGetUser['password']; ?>" >
                    <label>Perfil</label>
                    <select id="inputPerfil" name="inputPerfil" >
                        <?= $$optPerfils; ?>
                    </select>
                    <label>Dirección</label>
                    <input type="text" id="inputDir" name="inputDir" value="<?= $rowGetUser['direccion']; ?>" >
                    <label>Número Interior</label>
                    <input type="text" id="inputNumInt" name="inputNumInt" value="<?= $rowGetUser['num_int']; ?>" >
                    <label>Número Exterior</label>
                    <input type="text" id="inputNumExt" name="inputNumExt" value="<?= $rowGetUser['num_ext']; ?>" >
                    <label>Colonia</label>
                    <input type="text" id="inputCol" name="inputCol" value="<?= $rowGetUser['colonia']; ?>" >
                    <label>Municipio</label>
                    <input type="text" id="inputMun" name="inputMun" value="<?= $rowGetUser['municipio']; ?>" >
                    <label>Teléfono</label>
                    <input type="number" id="inputTel" name="inputTel" value="<?= $rowGetUser['telefono']; ?>" >
                    <label>Celular</label>
                    <input type="number" id="inputCel" name="inputCel" value="<?= $rowGetUser['celular']; ?>" >
                    <label>Fecha de nacimiento</label>
                    <input type="date" id="inputNacimiento" name="inputNacimiento" value="<?= $rowGetUser['fec_nac']; ?>" >

                    <button type="submit" >Modificar</button>
                </form>
            </div>	  
        </div>
        
    </div><!-- fin container -->

    <script type="text/javascript">
        $(document).ready(function () {
            
            $('#formUpdUser').validate({
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
                        url: "controllers/update_user.php",
                        data: $('form#formUpdUser').serialize(),
                        success: function (msg) {
                            //alert(msg);
                            if (msg == "true") {
                                $('.error').html("Se modifico el usuario con éxito.").css({color: "#00FF00"});
                                setTimeout(function () {
                                    location.href = 'form_select_user.php';
                                }, 3000);
                            } else {
                                $('.error').css({color: "#FF0000"});
                                $('.error').html(msg);
                            }
                        },
                        error: function () {
                            alert("Error al modificar usuario ");
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