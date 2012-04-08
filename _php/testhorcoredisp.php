<?php

foreach (glob("_classes/*.php") as $filename){
	require_once $filename;
}

$hor = new Horario();

$hor -> setCreditosTotales(3);
$hor -> setFechaCreacion("05-05-05");
$hor -> setIdHorario("50");
$cursos = array();
$curso = new Curso();
$ocur = new Ocurrencia();
$ocur -> setDia("L");
$ocur -> setHoraFin("11:20");
$ocur -> setHoraInicio("10:00");
$ocur -> setSalon("R210");
$ocur -> setUnidadesDuracion(3);

$curso -> setOcurrencias(array($ocur));

$curso -> setCapacidad_Total(100);
$curso -> setCodigo_Curso("ADMI1523");
$curso -> setComplementarias(array());
$curso -> setCreditos(3);
$curso -> setCrn(55566);
$curso -> setCupos_Disponibles(50);
$curso -> setDepartamento("Administracion");
$curso -> setDias("L");
$curso -> setInPadre(null);
$curso -> setIndiceEnResultados(null);
$curso -> setNombre("Organizaciones");
$curso -> setNumCompl(0);
$curso -> setProfesores(array("Carlos Castro"));
$curso -> setSeccion(1);
$curso -> setTipo(null);

$cursos[] = $curso;

$hor -> setCursos($cursos);
$hor -> setNombre("Mi horario");
$hor -> setNumCursos(1);
$hor -> setUsuario("imbett");

echo json_encode($hor);
?>