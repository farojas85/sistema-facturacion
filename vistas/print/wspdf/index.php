<?php
session_start();
require_once(dirname(__FILE__) . "/../../../pdf/vendor/autoload.php");
require_once(dirname(__FILE__) . "/../../../Controladores/cantidad_en_letras.php");
//clases de acceso a datos
require_once(dirname(__FILE__) . "/../../../vendor/autoload.php");

use Conect\Conexion;
use Controladores\ControladorClientes;
use Controladores\ControladorProductos;
use Controladores\ControladorVentas;
use Controladores\ControladorCategorias;
use Controladores\ControladorEnvioSunat;
use Controladores\ControladorResumenDiario;
use Controladores\ControladorEmpresa;
use Controladores\ControladorSucursal;
use Controladores\ControladorSunat;
use Controladores\ControladorUsuarios;
use Controladores\ControladorCuentasBanco;
use Spipu\Html2Pdf\Html2Pdf;

$files = glob('../../../api/wspdf/*'); //obtenemos el nombre de todos los ficheros
foreach($files as $file){
    $lastModifiedTime = filemtime($file);
    $currentTime = time();
    $timeDiff = abs($currentTime - $lastModifiedTime)/(60*60); //en horas
    if(is_file($file) && $timeDiff > 1) {
        unlink($file); //elimino el fichero
    }
}


$empresa = ControladorEmpresa::ctrEmisor();

$item = "id";
$valor = $_REQUEST["idComp"];
$venta = ControladorVentas::ctrMostrarVentas($item, $valor);



$item = 'idenvio';
$valor = $venta['idbaja'];
$ticket = ControladorEnvioSunat::ctrMostrarBaja($item, $valor);

$item = "id";
$valor = $venta['id_sucursal'];
$sucursal = ControladorSucursal::ctrMostrarSucursalTotal($item, $valor);

$item = "id";
$valor = $venta['codcliente'];
$cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

$emisor = ControladorEmpresa::ctrEmisor();

$item = "idventa";
$valor = $venta['id'];
$detalle = ControladorVentas::ctrMostrarDetallesProductos($item, $valor);

$item = "id_venta";
$valor = $venta['id'];
$ventaCredito = ControladorVentas::ctrMostrarVentasCredito($item, $valor);

$valor = $venta['tipocomp'];
$tipo_comprobante = ControladorSunat::ctrTipoComprobante($valor);

$item = "codigo";
$valor = $venta['metodopago'];
$metodo_pago = ControladorSunat::ctrMostrarMetodoPago($item, $valor);
//Consultar los datos necesarios para mostrar en el PDF - INICIO
$item = 'id';
$valor = $_SESSION['id'];
$vendedor = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);


$item = 'id';
$valor = $venta['id_cuenta'];
$cuentaBanco = ControladorCuentasBanco::ctrMostrarCuentasBanco($item, $valor);



ob_start();

    require_once("../invoiceA4.php");
    $nombrexml = $emisor['ruc'] . '-' . $venta['tipocomp'] . '-' . $venta['serie'] . '-' . $venta['correlativo'];
    $html = ob_get_clean();
    $html2pdf = new Html2Pdf('P', 'a4', 'fr', true, 'UTF-8', 0);
    // $html2pdf = new Html2Pdf('P', array(77.5, 300), 'fr', true, 'UTF-8', 0);


$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->setTestTdInOnePage(true);
$html2pdf->writeHTML($html);
$html2pdf->output(dirname(__FILE__) .  '/../../../api/wspdf/'. $nombrexml . '.pdf', 'F');
