<div class="contenedor">
    <div class="logo"><img src="<?= base_url ?>img/DeliverySimplyCRUD.png" alt=""></div>
    <div class="formulario">
        <?php //var_dump($_SESSION['errors']) 
        ?>
        <form action="<?= base_url ?>pedido/pagar" method="POST">
            <div class="group">
                <label for="">Nombre Completo</label>
                <input type="text" name="nombreCompleto" id="nombre" placeholder="Escriba su Nombre Completo">
            </div>
            <div class="group2">
                <label for="">Direccion</label>
                <input type="text" name="direccion" id="direccion" placeholder="Escriba la Direccion para entregar pedido">
            </div>
            <div class="group2">
                <label for="">Departamento</label>
                <?php $departamentos = Utils::showDepartamentos(); ?>
                <select name="departamento" id="departamentos">
                    <option value="0">Seleccione el Departamento</option>
                    <?php while ($departamento = $departamentos->fetch_object()) : ?>
                        <option value="<?= $departamento->id ?>"><?= $departamento->departamento ?></option>
                    <?php endwhile ?>
                </select>
            </div>
            <div class="group2">
                <label for="">Ciudad</label>
                <select name="ciudad" id="ciudades">
                    <option value="0">Seleccione una Ciudad</option>
                </select>
            </div>
            <div class="group3">
                <label for="">Peso de la caja (Kilos)</label>
                <?php $pesos = Utils::pesoCaja(); ?>
                <select name="peso" id="peso">
                    <option value="0">Seleccione un peso</option>
                    <?php while($peso = $pesos->fetch_object()) : ?>
                        <option value="<?= $peso->id?>"><?= $peso->peso?></option>
                    <?php endwhile ?>
                </select>
            </div>
            <div class="group3">
                <label for="">Valor Asegurado</label>
                <?php $valor_asegurado = Utils::valorAsegurado(); ?>
                <select name="valor" id="valor">
                    <option value="0">Seleccione un valor</option>
                    <?php while($valor = $valor_asegurado->fetch_object()) : ?>
                        <option value="<?= $valor->valor?>"><?= $valor->valor?></option>
                    <?php endwhile ?>
                </select>
            </div>
            <div class="btnticket" onclick="Calc()"><a>Calcular Valor a Pagar</a></div>
            <div class="group4" id="total">
                <label for="">Valor total a pagar</label>
                <input type="text" name="totalpagar" id="inputPagar" readonly>
            </div>
            <button class="btncal" id="btnticket">Generar Ticket de Pago</button>
        </form>
    </div>
    <?php if (isset($_SESSION['ticket']) && $_SESSION['ticket'] != "" && $_SESSION['ticket']['nombrecompleto'] != "" && $_SESSION['ticket']['direccion'] != "") : ?>
        <div class="ticket">
            <div class="titulo">Ticket de Pago</div>
            <div class="nombre">Nombre del cliente: <p><?= $ticket['nombrecompleto'] ?></p>
            </div>
            <div class="direccion">Direccion: <p><?= $ticket['direccion'] ?></p>
            </div>
            <div class="ciudad"><?= $ticket['ciudad'] ?></div>
            <div class="departamento"><?= $ticket['departamento'] ?></div>
            <div class="filalabels">
                <div class="lblcant">Cantidad de Cajas</div>
                <div class="lblvvalorase">Valor Asegurado</div>
            </div>
            <div class="filavalores">
                <div class="cant"><?= $ticket['peso'] ?></div>
                <div class="valorase"><?= $ticket['valor'] ?></div>
            </div>

            <div class="lblvalorpag">Valor a Pagar</div>
            <div class="valorpag"><?= $ticket['total'] ?></div>
            <div class="btnticketconf"><a href="<?= base_url ?>pedido/confirmar" class="boton">Confirmar</a></div>
        </div>
    <?php endif ?>
</div>
<script>
    $(document).ready(function() {


        $("#departamentos").change(function() {
            //alert("Bienvenido al curso de fundamentos de programación"); 
            var ciudades = $("#ciudades");

            var departamentos = $(this);

            if ($(this).val() != '') {

                $.ajax({
                    type: "POST",
                    //url: ".<?php base_url ?>./cliente/ciudad",
                    url: "http://localhost/nodo/views/pedido/ciudades.php",
                    data: "id=" + departamentos.val(),
                    dataType: "json",
                    beforeSend: function() {
                        departamentos.prop('disabled', true);
                    },
                    success: function(r) {
                        departamentos.prop('disabled', false);

                        ciudades.find('option').remove();

                        $(r).each(function(i, v) {
                            ciudades.append('<option value="' + v.id + '" >' + v.ciudad + '</option>');
                        })
                    },
                    error: function() {
                        alert('Ocurrio un error en el servidor ..');
                        departamentos.prop('disabled', false);
                    }
                });
            } else {
                ciudades.find('option').remove();
            }
        });
    });
</script>

<script>
    $("#total").hide();
    $("#btnticket").hide();
    $("#error1").hide();

    function Calc() {
        var peso = $("#peso");
        var valor = $("#valor");
        var total = $("#total");
        var btnticket = $("#btnticket");
        var nombre = $("#nombre");
        var direccion = $("#direccion");
        var departamentos = $("#departamentos");
        let errores = [];

        if (nombre.val() == "" || direccion.val() == "") {
            let  nuevo = errores.push('Por favor llene todos los campos. Gracias');
        }

        if (departamentos.val() == 0) {
            let  nuevo = errores.push('Por favor seleccione el Departamento y la Ciudad. Gracias');
        }

        if (peso.val() == 0) {
            let  nuevo = errores.push('Por favor seleccione el peso de la caja. Gracias');
        }

        if (valor.val() == 0) {
            let  nuevo = errores.push('Por favor seleccione el valor asegurado. Gracias');
        }

        else if (peso.val() == 0 && valor.val() == 0) {
            let  nuevo = errores.push('Por favor seleccione el peso de la caja y valor asegurado. Gracias');
        }

        const list = document.createElement('ul');
            const listItem = document.createElement('li');
            errores.forEach(function(elemento, indice, array) {
                const listItem = document.createElement('li');
                listItem.innerHTML = elemento;
                list.appendChild(listItem);
            })
        if (errores.length >=1) {
            swal(list, {
                button: "Aceptar",
            });
        }   
            


        if (peso.val() != 0 && valor.val() != 0) {
            switch (peso.val()) {
                case '1':
                    switch (valor.val()) {
                        case '$ 10.000':
                            totalpagar = "$ 25.000";
                            break;
                        case '$ 20.000':
                            totalpagar = "$ 24.000";
                            break;

                        case '$ 30.000':
                            totalpagar = "$ 23.000";
                            break;

                        case '$ 40.000':
                            totalpagar = "$ 22.000";
                            break;

                        case '$ 50.000':
                            var totalpagar = "$ 21.000";
                            break;

                        case '$ 60.000':
                            totalpagar = "$ 20.000";
                            break;

                        default:
                            break;
                    }
                    break;

                case '2':
                    switch (valor.val()) {
                        case '$ 10.000':
                            totalpagar = "$ 45.000";
                            break;
                        case '$ 20.000':
                            totalpagar = "$ 44.000";
                            break;

                        case '$ 30.000':
                            totalpagar = "$ 43.000";
                            break;

                        case '$ 40.000':
                            totalpagar = "$ 42.000";
                            break;

                        case '$ 50.000':
                            totalpagar = "$ 41.000";
                            break;

                        case '$ 60.000':
                            totalpagar = "$ 40.000";
                            break;

                        default:
                            break;
                    }
                    break;

                case '3':
                    switch (valor.val()) {
                        case '$ 10.000':
                            totalpagar = "$ 60.000";
                            break;
                        case '$ 20.000':
                            totalpagar = "$ 59.000";
                            break;

                        case '$ 30.000':
                            totalpagar = "$ 58.000";
                            break;

                        case '$ 40.000':
                            totalpagar = "$ 57.000";
                            break;

                        case '$ 50.000':
                            totalpagar = "$ 56.000";
                            break;

                        case '$ 60.000':
                            totalpagar = "$ 55.000";
                            break;

                        default:
                            break;
                    }
                    break;
                default:
                    break;
            }
            $("#total").show(1000);
            $("#btnticket").show(1000);
            $("#inputPagar").val(totalpagar);
        }

    }

    function aceptar() {
        $("#error1").hide();
    }
</script>