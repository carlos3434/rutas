<?php
//header('Access-Control-Allow-Origin', '*');
//header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}


$rutas = [
	'una' => 'uno detalle',
        'dos' => 'uno detalle',
        'tres' => 'uno detalle',
        'cuatro' => 'uno detalle',
        'cinco' => 'uno detalle'
];
echo json_encode($rutas);
return;

//return echo json_encode($rutas);
?>
