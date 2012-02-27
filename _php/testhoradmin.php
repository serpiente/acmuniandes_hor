<?php

foreach (glob("_classes/*.php") as $filename){
	require_once $filename;
}

$hor = new Horario();

$hor -> setCreditosTotales(3);
$hor -> setFechaCreacion("05-05-05");
$hor -> setIdHorario("0");
$hor -> setCursos(array());
$hor -> setNombre("Mi horario");
$hor -> setNumCursos(1);
$hor -> setUsuario("imbett");

echo json_encode(array($hor));
?>