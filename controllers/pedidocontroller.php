n<?php
require_once 'models/pedidos.php';
require_once 'config/func.php';

class PedidoController
{
    public function index(){
        $pedidos = new Pedido();
        $pagination = $pedidos->paginacion();
        //$pedidos = $pedidos->getAll();n
        if (isset($_SESSION['pedido']) && $_SESSION['pedido'] != "") {
            $pedido1 = $_SESSION['pedido'];
        }

        if (isset($_SESSION['ticketedicion']) && $_SESSION['ticketedicion'] != "") {
            $ticket = $_SESSION['ticketedicion'];
        }

        require_once 'views/pedido/index2.php';
    }


    public function crear()
    {
        if (isset($_SESSION['ticket']) && $_SESSION['ticket'] != "") {
            $ticket = $_SESSION['ticket'];
        }
        require_once 'views/pedido/index.php';
    }

    public function pagar()
    {
        if (isset($_POST)) {
            $nombrecompleto = $_POST['nombreCompleto'];
            $direccion = $_POST['direccion'];
            $departamento_id = $_POST['departamento'];
            $ciudad_id = $_POST['ciudad'];
            $pesocaja = $_POST['peso'];
            $valorasegurado = $_POST['valor'];
            $totalPagar = $_POST['totalpagar'];
            $departamento = new Pedido();
            $departamento->setDepartamento_id($departamento_id);
            $departamento->setCiudad_id($ciudad_id);
            $departamento = $departamento->getDepartamento();
            $_SESSION['ticket'] = array(
                "nombrecompleto" => $nombrecompleto,
                "direccion" => $direccion,
                "ciudad_id" => $ciudad_id,
                "departamento_id" => $departamento_id,
                "ciudad" => $departamento->ciudad,
                "departamento" => $departamento->departamento,
                "peso" => $pesocaja,
                "valor" => $valorasegurado,
                "total" => $totalPagar
            );
        }
        header('Location:' . base_url . 'pedido/crear');
    }

    public function confirmar()
    {
        if (isset($_SESSION['ticket'])) {
            $ticket = $_SESSION['ticket'];
            $nombrecompleto = $ticket['nombrecompleto'];
            $direccion = $ticket['direccion'];
            $departamento_id = $ticket['departamento_id'];
            $ciudad_id = $ticket['ciudad_id'];
            $pesocaja = $ticket['peso'];
            $valorasegurado = $ticket['valor'];
            $totalPagar = $ticket['total'];

            $ticket = new Pedido();
            $ticket->setNombrecompleto($nombrecompleto);
            $ticket->setDireccion($direccion);
            $ticket->setDepartamento_id($departamento_id);
            $ticket->setCiudad_id($ciudad_id);
            $ticket->setPesocaja($pesocaja);
            $ticket->setValorasegurado($valorasegurado);
            $ticket->setCosto($totalPagar);
            $ticket = $ticket->Ticket();
            if ($ticket) {
                unset($_SESSION['ticket']);
            }
        }
        header('Location:' . base_url . 'pedido/index&page=1');
    }

    public function deletesesion()
    {
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }

        header('Location:' . base_url . 'pedido/crear');
    }

    public function delete()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $pedidos = new Pedido();
            $pedidos->setId($id);
            $pedidos->delete();
        }
    }

    public function edit()
    {
        if (isset($_GET['id']) && isset($_GET['page'])) {
            $page = $_GET['page'];
            $id = $_GET['id'];
            $pedido = new Pedido();
            $pedido->setId($id);
            $_SESSION['pedido'] = $pedido->getOne();
            header('Location:' . base_url . 'pedido/index&page='.$page);
        }
    }

    public function cancelar()
    {
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        if (isset($_SESSION['pedido'])) {
            unset($_SESSION['pedido']);
        }

        if (isset($_SESSION['ticketedicion'])) {
            unset($_SESSION['ticketedicion']);
        }
        header('Location:' . base_url . 'pedido/index&page='.$page);
    }
}

    public function edicion()
    {
        if (isset($_POST) && isset($_GET['page'])) {
            $page = $_GET['page'];
            $id = $_POST['id'];
            $nombrecompleto = $_POST['nombreCompleto'];
            $direccion = $_POST['direccion'];
            $departamento_id = $_POST['departamento'];
            $ciudad_id = $_POST['ciudad'];
            $pesocaja = $_POST['peso'];
            $valorasegurado = $_POST['valor'];
            $totalPagar = $_POST['totalpagar'];
            $departamento = new Pedido();
            $departamento->setDepartamento_id($departamento_id);
            $departamento->setCiudad_id($ciudad_id);
            $departamento = $departamento->getDepartamento();
            $_SESSION['ticketedicion'] = array(
                "id" => $id,
                "nombrecompleto" => $nombrecompleto,
                "direccion" => $direccion,
                "ciudad_id" => $ciudad_id,
                "departamento_id" => $departamento_id,
                "ciudad" => $departamento->ciudad,
                "departamento" => $departamento->departamento,
                "peso" => $pesocaja,
                "valor" => $valorasegurado,
                "total" => $totalPagar
            );
        }
        header('Location:' . base_url . 'pedido/index&page='.$page);
    }

    public function confirmaredicion()
    {
        if (isset($_SESSION['ticketedicion']) && isset($_GET['page'])) {
            $page = $_GET['page'];
            //var_dump($_SESSION['ticketedicion']);die();
            $ticketedicion = $_SESSION['ticketedicion'];
            $id= $ticketedicion['id'];
            $nombrecompleto = $ticketedicion['nombrecompleto'];
            $direccion = $ticketedicion['direccion'];
            $departamento_id = $ticketedicion['departamento_id'];
            $ciudad_id = $ticketedicion['ciudad_id'];
            $pesocaja = $ticketedicion['peso'];
            $valorasegurado = $ticketedicion['valor'];
            $totalPagar = $ticketedicion['total'];

            $ticket = new Pedido();
            $ticket->setId($id);
            $ticket->setNombrecompleto($nombrecompleto);
            $ticket->setDireccion($direccion);
            $ticket->setDepartamento_id($departamento_id);
            $ticket->setCiudad_id($ciudad_id);
            $ticket->setPesocaja($pesocaja);
            $ticket->setValorasegurado($valorasegurado);
            $ticket->setCosto($totalPagar);
            $ticket = $ticket->TicketEdit();
            if ($ticket) {
                unset($_SESSION['ticketedicion']);
                unset($_SESSION['pedido']);
            }
        }
        header('Location:' . base_url . 'pedido/index&page='.$page);
    }
}
