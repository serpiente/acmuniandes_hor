/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */
$(function() {

	var horarios;
	var sel= "";
	
	$('#buttonCons').click(mostrarHorarios);
	$('#buttonCreate').click(vizualizacionCreacion);
	
	$('#buttonLogout').click(function() {
		params = {tipsol:'4'};
		postform('_php/hor_auth.php',params);
	}); 

		
	function mostrarHorarios() {
		/*Conexión AJAX */
		vaciarTablaHorarios();
		parametros = {
			'tipsol' : '0'
		}

		$.ajax({
			url : '_php/hor_core.php',
			//url : '_php/testhoradmin.php',
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
					for(var i in horarios) {
						visualizarHorario(horarios[i].nombre, horarios[i].creditos_Totales, horarios[i].fechaCreacion, horarios[i].num_Cursos, horarios[i].cursos, i,horarios[i].id_horario);
					}
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
		$("#"+id).click(function(){
			abrirHorario(''+i)
		});
		$("#eli"+i).click(function(){
			eliminarHorario(''+i)
		});
	}
	
	function abrirHorario(id)
	{
		parametros = {
			'tipsol' : '6',
			'id_hor' : id
		};
		postform('_php/hor_core.php',parametros)
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
				if(response) {
					alert("Creado");
					vaciarTablaHorarios();
				}
				else {
					alert("Error al crear el horario");
					vaciarTablaHorarios();
				}
			}
		});

	}

	/*Metodo que eliminar un horario */
	function eliminarHorario(id) {
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
				
				if(response) {
					/*Elimina el horario de la visualizacíón */
					alert("Eliminado");
					vaciarTablaHorarios();
				}
				else{
					alert("Error al eliminar el horario");
					vaciarTablaHorarios();
				}
			}
		});

	}
	
	function postform(path, params){
		var form = document.createElement("form");
		form.setAttribute("method", "POST");
		form.setAttribute("action", path);
		
		for(var key in params) {
			if(params.hasOwnProperty(key)) {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);

				form.appendChild(hiddenField);
			}
		}

		document.body.appendChild(form);
		form.submit();
	}
});
