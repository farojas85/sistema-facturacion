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
class EnvioWsLocal
{
const INSTACIA = "COLOQUE AQUI SU INSTANCIA DE FACTILIZA";
const URL_API_WS = "https://apiwsp.factiliza.com/v1/message/sendmedia/".self::INSTACIA;
public static function enviarWsLocal(){
 
$idcomp= $_POST['idComp'];
$numws= $_POST['numberws'];
$codnumws= $_POST['codnumberws'];
if(strlen(self::INSTACIA ) > 30 || self::INSTACIA == ""){
    echo "errorinstancia";
    exit();
}
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

$clientenr = $venta['tipocomp'] == '01' ? $cliente['razon_social'] : $cliente['nombre'];
            $mensaje = "*".$emisor['razon_social']."*".PHP_EOL;
            $mensaje .= "*RUC: ".$emisor['ruc']."*".PHP_EOL;
            $mensaje .= "===============================".PHP_EOL;
            $mensaje .= "*ESTIMADO CLIENTE,*\n". 
                         "Sr(es). ".$clientenr."".PHP_EOL;
            $mensaje .= "===============================".PHP_EOL;             
            $mensaje .= "*SE ADJUNTA SU COMPROBANTE EN FORMATO XML Y PDF*".PHP_EOL;
            $mensaje .= "===============================".PHP_EOL;
            $mensaje .= "Número de whatsapp solo para notificaciones, no responder a este mensaje".PHP_EOL;
                      
            $datos1 =array(
                "number" => $codnumws.$numws,
                "mediatype" => "document",
                "media" => $datos_base64_xml,
                "filename" => $nombrexml.'.xml',
                "caption" => $mensaje
            );
            $datos2 =array(
                "number" => $codnumws.$numws,
                "mediatype" => "document",
                "media" => $datos_base64_pdf,
                "filename" => $nombrepdf.'.pdf',
                "caption" => $mensaje
            );
            
            $curl = curl_init();
            
            curl_setopt_array($curl, [
              CURLOPT_URL => self::URL_API_WS,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($datos1) ,
              CURLOPT_HTTPHEADER => [
                "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzODMwNyIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6ImNvbnN1bHRvciJ9.DQbd2U-Tr21so4Sjg8zNo4AE68IJik6Dy6b5eDw1-8s",
                "Content-Type: application/json"
              ],
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
              $res = json_decode($response);
            if ($err) {
               echo "cURL Error #:" . $err;
            } else {
                if($res->succes == true){
             
                curl_setopt_array($curl, [
              CURLOPT_URL => self::URL_API_WS,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($datos2) ,
              CURLOPT_HTTPHEADER => [
                "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzODMwNyIsImh0dHA6Ly9zY2hlbWFzLm1pY3Jvc29mdC5jb20vd3MvMjAwOC8wNi9pZGVudGl0eS9jbGFpbXMvcm9sZSI6ImNvbnN1bHRvciJ9.DQbd2U-Tr21so4Sjg8zNo4AE68IJik6Dy6b5eDw1-8s",
                "Content-Type: application/json"
              ],
            ]);
            
            $response2 = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
            $res2 = json_decode($response2);
            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
                if($res2->succes == true){
                    echo 'ok';
        }

}
            
        }
    }
}
}
EnvioWsLocal::enviarWsLocal();