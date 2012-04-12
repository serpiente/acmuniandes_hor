$(function() {

		var horarios;
		var sel= "";
		
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
	
	$('#buttonCons').click(mostrarHorarios);
	$('#buttonCreate').click(vizualizacionCreacion);
		
	function mostrarHorarios() {
		/*Conexión AJAX */
		vaciarTablaHorarios();
		parametros = {
			'tipsol' : '0'
		}

		$.ajax({
			/*url : '_php/hor_core.php',*/
			url : '_php/testhoradmin.php',
			dataType : 'json', //hace que se evalue el json que retorna el servidor como un objeto
			data : parametros,
			type : 'POST',
			success : function(response) {
				if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
				}
				else {
					horarios = response;
					for(var i = 0; i < 1; i++) {
						visualizarHorario(horarios[i].nombre, horarios[i].creditos_Totales, horarios[i].fechaCreacion, horarios[i].num_Cursos, horarios[i].cursos, i,horarios[i].id_horario);
					};
					inicilializar();					
				}
			}
		});
	}

	
	function vizualizacionCreacion ()
	{
		vaciarTablaHorarios();
		$("#result").append("<tr><td>&nbsp</td></tr>");
		$("#result").append("<tr> <td> Nombre del Horario: </td> <td> <input type='text' id ='nombreHorario'> </input> </td> </tr>  ");
		$("#result").append("<tr> <td></td><td><button id='buttonCreateHorario'> Crear Nuevo Horario</button></td> </tr>");	
		$("#buttonCreateHorario").click(function(){
			crearHorario($('#nombreHorario').val())
		});
	}
	
	function vaciarTablaHorarios() {
		$("#result").find("tr").remove();
	}

	/*Permite visualizar cada uno de los horarios que el usuario posee */

	function visualizarHorario(nombre, creditos, fecha, numcursos, cursos, id,i) {
		$("#result").append("<tr><td>&nbsp</td></tr>");
		$("#result").append("<tr class=\"celda1\" id=cell"+(i)+"><td width=\"12%\"> <span class='horarioResultado' id="+(id)+" >" +nombre+"</span></td><td width=\"88%\"></td><td width=\"3%\"> <button id=eli"+(i)+" > X</button></td></tr>");
		console.log($("#"+id))
		$("#"+id).click(function(){
			abrirHorario(''+i)
		});
		$("#eli"+i).click(function(){
			eliminarHorario(''+i)
		});
	}
	
	function abrirHorario(id)
	{
		alert('abrir '+id);
		parametros = {
			'tipsol' : '6',
			'id_hor' : id
		};
		$.ajax({
			url : '_php/hor_core.php',
			data : parametros,
			dataType : 'json',
			type : 'POST',
			success : function(response) {
				if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
				}
			}
		});
	}
	
	function inicilializar(){
		$('.horarioResultado').poshytip({
			content : contenidoTTip,
			className : 'tip-twitter',
			showTimeout : 20,
			alignTo : 'cursor',
			alignX : 'center',
			offsetY : 20,
			allowTipHover : false,
			fade : true,
			slide : true
		});
		
		$('.horarioResultado').hover(function() {
			sel = ($(this).attr('id'));
			document.body.style.cursor = 'pointer';
		}, function(){
			document.body.style.cursor = 'auto';
		});
	}

	function contenidoTTip(){
		if(sel){
			return $("<span>Creditos: "+horarios[sel].creditos_Totales + "<br>" +"Numero de Cursos: "+horarios[sel].num_Cursos 
			+"<br> Fecha de Creacion: "+horarios[sel].fechaCreacion +"</span>");
		}
	}
	function crearHorario(nombre) {
		/* Genera un dialogo para escribir el nombre del horario */
		/*Conexión AJAX */
		alert("hola"+nombre);
		var horariocreado = false;
		parametros = {
			'nomhor' : nombre,
			'tipsol' : '1'
		};
		$.ajax({
			url : '_php/hor_core.php',
			data : parametros,
			dataType : 'json',
			type : 'POST',
			success : function(response) {
				if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
				}
				else{
					horariocreado = response;
				}
			}
		});

		if(horariocreado) {
			alert("Creado");
			vaciarTablaHorarios();
		}
		else {
			alert("Error al crear el horario");
			vaciarTablaHorarios();
		}

	}

	/*Metodo que eliminar un horario */

	var j = 0;
	function eliminarHorario(id) {
	alert("elminar "+id);
		var horarioeliminado = false;
		parametros = {
			'tipsol' : '2',
			'id_hor':id
		};
		$.ajax({
			url : '_php/hor_core.php',
			data : parametros,
			dataType : 'json',
			type : 'POST',
			success : function(response) {
				if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
				}
				else{
					horarioeliminado = response;					
				}
			}
		});

		if(horarioeliminado) {
			/*Elimina el horario de la visualizacíón */
			alert("Eliminado");
			vaciarTablaHorarios();
		}
		else{
			alert("Error al eliminar el horario");
			vaciarTablaHorarios();
		};


	}

});
