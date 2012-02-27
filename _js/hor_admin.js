$(function() {

	$('#button-container.demo').hover(function() {
		$('#button-container.demo #arrow-container').addClass('rotate');
		$('#button-container.demo #arrow-triangle').addClass('change');
		$('#button-container.demo #arrow-rectangle').addClass('widen');
	}, function() {
		$('#button-container.demo #arrow-container').removeClass('rotate');
		$('#button-container.demo #arrow-triangle').removeClass('change');
		$('#button-container.demo #arrow-rectangle').removeClass('widen');
	});

	$('#button-container.download').hover(function() {
		$('#button-container.download #arrow-container').addClass('rotateDown');
	}, function() {
		$('#button-container.download #arrow-container').removeClass('rotateDown');
	});

	$('#button-container.digg').hover(function() {
		$('#button-container.digg #arrow-container').addClass('rotateDownMore');
		$('#button-container.digg #arrow-rectangle-handle').addClass('donut');
		$('#button-container.digg #arrow-rectangle-staff').addClass('skinny');
		$('#button-container.digg #arrow-triangle').addClass('shovel');
	}, function() {
		$('#button-container.digg #arrow-container').removeClass('rotateDownMore');
		$('#button-container.digg #arrow-rectangle-handle').removeClass('donut');
		$('#button-container.digg #arrow-rectangle-staff').removeClass('skinny');
		$('#button-container.digg #arrow-triangle').removeClass('shovel');
	});

	$('#button-container.email').hover(function() {
		$('#button-container.email #arrow-triangle').addClass('emailRotate');
		$('#button-container.email #arrow-rectangle').addClass('emailTranslate');
	}, function() {
		$('#button-container.email #arrow-triangle').removeClass('emailRotate');
		$('#button-container.email #arrow-rectangle').removeClass('emailTranslate');
	});

	$('#button-container.rss').hover(function() {
		$('#button-container.rss #arrow-triangle').addClass('rss');
		$('#button-container.rss #arrow-rectangle').addClass('rssDot');
	}, function() {
		$('#button-container.rss #arrow-triangle').removeClass('rss');
		$('#button-container.rss #arrow-rectangle').removeClass('rssDot');
	});
		
	function mostrarHorarios() {
		/*Conexión AJAX */
		parametros = {
			'tipsol' : 0
		}
		var horarios;
		$.ajax({
			url : '_php/hor_core.php',
			data : parametros,
			type : 'get',
			success : function(response) {
			}
		});
		/*Permite visualizar uno a uno los nuevos horarios */
		for(var i = 0; i < horarios.lenght; i++) {
			var nombreHorario = horarios[i].nombre;
			var creditosHorario = horarios[i].creditos_Totales;
			var fecha = horarios[i].fechaCreacion;
			var numeroCursos = horarios[i].num_Cursos;
			var cursosHorario = horarios[i].cursos;
			visualizarHorario(nombreHorario, creditosHorario, fecha, numeroCursos, cursosHorario, i);
		};
	}

	/*Permite visualizar cada uno de los horarios que el usuario posee */

	function visualizarHorario(nombre, creditos, fecha, numcursos, cursos, i) {
		//$('#horario' + i).show("slow");
		$("#resultados").append("<tr><td><p id=horario"+i+"> <br> Nombre: <br> Numero de Creditos: <br> Fecha Creacion: </p></td></tr>").show("slow");

	}

	function crearHorario() {
		/* Genera un dialogo para escribir el nombre del horario */
		/*Conexión AJAX */
		var horariocreado = false;
		parametros = {
			'tipsol' : '1'
		};
		$.ajax({
			url : '_php/hor_core.php',
			data : parametros,
			type : 'get',
			success : function(response) {
				horariocreado = true;
			}
		});

		if(horariocreado) {
			/*Codigo que permite modificar y crear el nuevo horario */
		};

	}

	/*Metodo que eliminar un horario */

	var j = 0;
	function eliminarHorario() {

		var horarioeliminado = false;
		parametros = {
			'tipsol' : '2'
		};
		$.ajax({
			url : '_php/hor_core.php',
			data : parametros,
			type : 'get',
			success : function(response) {
				horarioeliminado = true;
			}
		});

		if(horarioeliminado) {
			/*Elimina el horario de la visualizacíón */

		};

		for(var i = 0; i < horarios.lenght; i++) {
			$('#horario' + i).hide("slow");
		};

	}

});
