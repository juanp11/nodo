<div class="contenedortabla">
    <?php
    // var_dump($pagination);die();
    if ($pagination) {
        $page = false;
        $rango  = 10;
        $section_size = 4;
        $actual_section = 1;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if (!$page) {
            $start = 0;
            $page = 1;
        } else {
            $start = ($page - 1) * $rango;
        }

        $totalPages = ceil($pagination / $rango);
        $total_sections = ceil($totalPages / $section_size);
        $section_count = $section_size;
        do {
            if ($page > $section_count) {
                $section_count += $section_size;
                $actual_section++;
            }
        } while ($page > $section_count);

        $section_end = $actual_section * $section_size;
        $section_start = ($section_end - $section_size) + 1;
    }
    ?>
    <div class="logo2"><img src="<?= base_url ?>img/DeliverySimplyCRUD.png" alt=""></div>
    <div class="titulo">Lista de Pedidos</div>
    <div class="mas"><a class="icon-add" href="<?= base_url?>pedido/crear">Nuevo Pedido</a></div>
    <div class="tabla">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre Completo</th>
                    <th>Direccion</th>
                    <th>Departamento</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($start)) :
                    $pedidos = Utils::getPedidos($start); ?>
                <?php if ($pedidos->num_rows > 0) : ?>
                    <?php while ($pedido = $pedidos->fetch_object()) :  ?>
                        <tr>
                            <td><?= $pedido->id ?></td>
                            <td><?= $pedido->nombre ?></td>
                            <td><?= $pedido->direccion ?></td>
                            <td><?= $pedido->departamento ?></td>
                            <td><a onclick="eliminar(<?= $pedido->id ?>)" class="icon-trashcan links"></a> <a href="<?= base_url ?>pedido/edit&id=<?= $pedido->id ?>&page=<?=$page?>" class="icon-pencil2 links"></a></td>
                        </tr>
                    <?php endwhile ?>
                <?php endif ?>
                <?php endif ?>
            </tbody>
        </table>
        <section class="pagination">
                <ul class="pagination">
                    <?php if(isset($totalPages) && $totalPages != 0) : ?>
                    <?php if ($actual_section != 1) : ?>
                        <li><a class="icon-first_page icono" href="<?= base_url ?>pedido/index&page=1"></a></li>
                        <li><a class="icon-chevrons-left icono" href="<?= base_url ?>pedido/index&page=<?php echo ($page - 1); ?>"></a></li>
                    <?php endif; ?>

                    <?php for ($i = $section_start; $i <= $section_end; $i++) : ?>
                        <?php if ($i > $totalPages) : break;
                        endif; ?>
                        <?php $active = ($i == $page) ? "active" : ""; ?>
                        <li>
                            <a class="<?php echo $active; ?>" href="<?= base_url ?>pedido/index&page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($actual_section != $total_sections) : ?>
                        <li><a class="icon-chevrons-right icono" href="<?= base_url ?>pedido/index&page=<?php echo ($page + 1); ?>"></a></li>
                        <li><a class="icon-last_page icono" href="<?= base_url ?>pedido/index&page=<?php echo $totalPages; ?>"></a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                </ul>
        </section>
    </div>
    <?php if (isset($_SESSION['pedido']) && $_SESSION['pedido'] != "" || isset($_SESSION['ticketedicion']) && $_SESSION['ticketedicion'] != "" && $_SESSION['ticketedicion'] != $pedido1) : ?>
        <div class="contenedoredicion">
            <div class="tituloedicion">Edicion de Pedido No. <?= $pedido1->id ?></div>
            <div class="formulario">
                <?php //var_dump($_SESSION['ticketedicion']) 
                ?>
                <form action="<?= base_url ?>pedido/edicion&page=<?=$page?>" method="POST">
                    <input type="hidden" name="pagina" value="<?=$page?>">
                    <input type="hidden" name="id" id="id" value="<?= isset($pedido1) && is_object($pedido1) ? $pedido1->id : ''; ?>">
                    <input type="hidden" name="ciudadid" id="ciudadid" value="<?= isset($_SESSION['ticketedicion']) ? $ticket['ciudad_id'] : $pedido1->ciudad_id; ?>">
                    <div class="group">
                        <label for="">Nombre Completo</label>
                        <input type="text" name="nombreCompleto" id="nombre" placeholder="Escriba su Nombre Completo" value="<?= isset($_SESSION['ticketedicion'])  ? $ticket['nombrecompleto'] : $pedido1->nombrecompleto; ?>">
                    </div>
                    <div class="group2">
                        <label for="">Direccion</label>
                        <input type="text" name="direccion" id="direccion" placeholder="Escriba la Direccion para entregar pedido" value="<?= isset($_SESSION['ticketedicion']) ? $ticket['direccion'] : $pedido1->direccion; ?>">
                    </div>
                    <div class="group2">
                        <label for="">Departamento</label>
                        <?php $departamentos = Utils::showDepartamentos(); ?>
                        <select name="departamento" id="departamentos">
                            <option value="0">Seleccione el Departamento</option>
                            <?php while ($departamento = $departamentos->fetch_object()) : ?>
                                <?php if(isset($ticket) && $departamento->id == $ticket['departamento_id']) : ?>
                                    <option value="<?= $departamento->id ?>" selected><?= $departamento->departamento ?></option>
                                <?php elseif(isset($pedido1) && !isset($ticket) && $departamento->id == $pedido1->departamento_id) : ?>
                                    <option value="<?= $departamento->id ?>" selected><?= $departamento->departamento ?></option>
                                <?php else : ?>
                                    <option value="<?= $departamento->id ?>" ><?= $departamento->departamento ?></option>
                                <?php endif ?>
                                
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
                            <?php while ($peso = $pesos->fetch_object()) : ?>
                                <?php if (isset($ticket) && $peso->id == $ticket['peso']) : ?>
                                    <option value="<?= $peso->id ?>" selected><?= $peso->peso ?></option>
                                <?php elseif (isset($pedido1) && !isset($ticket) && $peso->id == $pedido1->pesocaja) : ?>
                                    <option value="<?= $peso->id ?>" selected><?= $peso->peso ?></option>
                                <?php else : ?>
                                    <option value="<?= $peso->id ?>"><?= $peso->peso ?></option>
                                <?php endif ?>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div class="group3">
                        <label for="">Valor Asegurado</label>
                        <?php $valor_asegurado = Utils::valorAsegurado(); ?>
                        <select name="valor" id="valor">
                            <option value="0">Seleccione un valor</option>
                            <?php while ($valor = $valor_asegurado->fetch_object()) : ?>
                                <?php if (isset($ticket) && $valor->valor == $ticket['valor']) : ?>
                                    <option value="<?= $valor->valor ?>" selected><?= $valor->valor ?></option>
                                <?php elseif (isset($pedido1) && !isset($ticket) && $valor->valor == $pedido1->valorasegurado) : ?>
                                    <option value="<?= $valor->valor ?>" selected><?= $valor->valor ?></option>
                                <?php else : ?>
                                    <option value="<?= $valor->valor ?>"><?= $valor->valor ?></option>
                                <?php endif ?>
                            <?php endwhile ?>
                        </select>
                    </div>
                    <div class="btnticket" onclick="Calc()"><a>Calcular Valor a Pagar</a></div>
                    <div class="group4" id="total">
                        <label for="">Valor total a pagar</label>
                        <input type="text" name="totalpagar" id="inputPagar" readonly value="<?= isset($_SESSION['ticketedicion']) ? $ticket['total'] : $pedido1->costo; ?>">
                    </div>
                    <button class="btncal" id="btnticket">Generar Ticket de Pago</button>
                </form>
            </div>
            <div class="ticket">
                <div class="titulo">Ticket de Pago</div>
                <div class="nombre">Nombre del cliente: <p><?= isset($_SESSION['ticketedicion'])  ? $ticket['nombrecompleto'] : $pedido1->nombrecompleto; ?></p>
                </div>
                <div class="direccion">Direccion: <p><?= isset($_SESSION['ticketedicion']) ? $ticket['direccion'] : $pedido1->direccion; ?></p>
                </div>
                <div class="ciudad"><?= isset($_SESSION['ticketedicion'])  ? $ticket['ciudad'] : $pedido1->ciudad; ?></div>
                <div class="departamento"><?= isset($_SESSION['ticketedicion']) ? $ticket['departamento'] : $pedido1->departamento; ?></div>
                <div class="filalabels">
                    <div class="lblcant">Cantidad de Cajas</div>
                    <div class="lblvvalorase">Valor Asegurado</div>
                </div>
                <div class="filavalores">
                    <div class="cant"><?= isset($_SESSION['ticketedicion']) ? $ticket['peso'] : $pedido1->pesocaja; ?></div>
                    <div class="valorase"><?= isset($_SESSION['ticketedicion']) ? $ticket['valor'] : $pedido1->valorasegurado; ?></div>
                </div>

                <div class="lblvalorpag">Valor a Pagar</div>
                <div class="valorpag"><?= isset($_SESSION['ticketedicion']) ? $ticket['total'] : $pedido1->costo; ?></div>
                <div class="btnticketconf"><a href="<?= base_url ?>pedido/confirmaredicion&page=<?=$page?>" class="boton">Confirmar</a></div>
                <div class="btnticketcancel"><a href="<?= base_url ?>pedido/cancelar&page=<?=$page?>" class="boton">Cancelar</a></div>
            </div>
        </div>
    <?php endif ?>
</div>
<script>
    function eliminarregistro(id) {
        $.ajax({
            data: "id=" + id,
            url: ".<?php base_url ?>./pedido/delete",
            type: "POST",
            beforeSend: function() {},
            success: function() {
                swal("El Registro ha sido eliminado con exito!", {
                    icon: "success",
                }).then((result) => {
                    if (result) {
                        $('body').load('.<?php base_url ?>./pedido/index');
                    }
                });
                /*setTimeout(function() {
                    $('body').load('.<?php base_url ?>./pedido/index');
                }, 1500);*/

            }
        });
    }

    function eliminar(id) {
        swal({
            title: "¿Estas Seguro?",
            text: "Deseas eliminar el registro!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((result) => {
            if (result) {
                eliminarregistro(id)
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $("#departamentos").each(function() {
            var ciudades = $("#ciudades");
            var ciudad = $("#ciudadid");

            var departamentos = $(this);
            if ($(this).val() != '' && ciudad.val() != "") {
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
                            if (v.id == ciudad.val()) {
                                ciudades.append('<option value="' + v.id + '" selected="selected" >' + v.ciudad + '</option>');
                            } else {
                                ciudades.append('<option value="' + v.id + '">' + v.ciudad + '</option>');
                            }

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

        $("#departamentos").change(function() {
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
    // $("#total").hide();
    // $("#btnticket").hide();
    // $("#error1").hide();

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
            let nuevo = errores.push('Por favor llene todos los campos. Gracias');
        }

        if (departamentos.val() == 0) {
            let nuevo = errores.push('Por favor seleccione el Departamento y la Ciudad. Gracias');
        }

        if (peso.val() == 0) {
            let nuevo = errores.push('Por favor seleccione el peso de la caja. Gracias');
        }

        if (valor.val() == 0) {
            let nuevo = errores.push('Por favor seleccione el valor asegurado. Gracias');
        } else if (peso.val() == 0 && valor.val() == 0) {
            let nuevo = errores.push('Por favor seleccione el peso de la caja y valor asegurado. Gracias');
        }

        const list = document.createElement('ul');
        const listItem = document.createElement('li');
        errores.forEach(function(elemento, indice, array) {
            const listItem = document.createElement('li');
            listItem.innerHTML = elemento;
            list.appendChild(listItem);
        })
        if (errores.length >= 1) {
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