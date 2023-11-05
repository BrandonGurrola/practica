<?php

require_once "vendor/econea/nusoap/src/nusoap.php";

$namespace = "Practica";
$server = new soap_server();
$server->configureWSDL("Prueba",$namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'cliente',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'tarjeta' => array('name' => 'tarjeta', 'type'=>'xsd:string'),
        'nombre' => array('name' => 'nombre', 'type'=>'xsd:string'),
        'apellido' => array('name' => 'apellido', 'type'=>'xsd:string'),
        'puesto' => array('name' => 'puesto', 'type'=>'xsd:string')
    )
);

$server->wsdl->addComplexType(
    'response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'numeroDeafilacion' => array('name'=>'numeroDeafilacion', 'type'=>'xsd:string'),
        'Resultado' => array('name' => 'Resultado', 'type' => 'xsd:boolean')
    )
);

$server->register(
    'guardartarjetadecliente',
    array('name' => 'tns:cliente'),
    array('name' => 'tns:response'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Recibe la tarjeta de cliente y regresa un numero de afilacion'
);

function guardartarjetadecliente($request){
    return array(
        "numeroDeafilacion" => "La tarjeta de cliente es: ".$request["tarjeta"]." ha sido afiliado con el numero ". rand(10, 50),
        "Resultado" => true
    );
}

$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();