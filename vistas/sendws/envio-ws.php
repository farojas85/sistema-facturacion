<?php
session_start();
require_once(dirname(__FILE__) . "/../../vendor/autoload.php");

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
class EnvioWs
{
// const URL_API_WS = 'http://localhost/apiTechMultiServ/send-whatsap.php';
const URL_API_WS = 'https://apitech.apifacturacion.com/v2/send-whatsap';
public static function enviarWs(){

$idcomp= $_POST['idComp'];
$numws= $_POST['numberws'];
$codnumws= $_POST['codnumberws'];
if($numws == "" || strlen($numws) < 9 || $codnumws == ""){
    echo "error";
    exit();
}
$emisor = ControladorEmpresa::ctrEmisor();
$item = "id";
$valor = $idcomp;
$venta = ControladorVentas::ctrMostrarVentas($item, $valor);

$item = "id";
$valor = $venta['codcliente'];
$cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

// Obtiene los datos binarios del archivo XML
$nombrexml = $emisor['ruc'] . '-' . $venta['tipocomp'] . '-' . $venta['serie'] . '-' . $venta['correlativo'];
$archivoxml = __DIR__ . '/../../api/xml/' . $nombrexml . '.XML';
$datos_binarios_xml = file_get_contents($archivoxml);

// Convierte los datos binarios a base64
$datos_base64_xml = base64_encode($datos_binarios_xml);


$nombrepdf = $emisor['ruc'] . '-' . $venta['tipocomp'] . '-' . $venta['serie'] . '-' . $venta['correlativo'];
$archivopdf = __DIR__ . '/../../api/wspdf/' . $nombrepdf . '.pdf';
$datos_binarios_pdf = file_get_contents($archivopdf);

// Convierte los datos binarios a base64
$datos_base64_pdf = base64_encode($datos_binarios_pdf);
//==============================================================
$licenciaFile = '../../LICENCIA';
if(file_exists($licenciaFile)){
   $archivo = file($licenciaFile);
}else{
   echo "NO ELIMINAR NI MODIFICAR EL ARCHIVO DE LICENCIA";
   exit();
}  

$licencia = $archivo;
$datos = array(
    'numws' => $numws,
    'codnumws' => $codnumws,
    "venta" => $venta,
    "emisor" => $emisor,
    "cliente" => $cliente,
    "licencia" => $licencia,
    'nombrexml' => $nombrexml,
    'nombrepdf' => $nombrepdf,
    "xml" => $datos_base64_xml,
    "pdf" => $datos_base64_pdf
 );
$options = array(
    CURLOPT_URL => self::URL_API_WS,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => http_build_query($datos)
);

$ch = curl_init();
curl_setopt_array($ch, $options);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo $response;
}

curl_close($ch);

}

}
EnvioWs::enviarWs();