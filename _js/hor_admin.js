/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */
$(function() {

	var horarios;
	var sel= 0;
	var j=1;
	
	mostrarHorarios();
	
	$('#buttonLogout').click(function() {
		params = {tipsol:'4'};
		postform('/acmuniandes_hor/_php/hor_auth.php',params);
	});
	
	$("#inputText").keypress(function(event) {
		if(event.which == 13) {
			crearHorario($(this).val());
		}
	});

	$("#inputText").focus(function() {
		$("#msgError").fadeOut(200);
		$(this).val('');
		$(this).css({
			color : 'black',
			fontStyle : 'normal'
		});
	});

	$("#inputText").focusout(function() {
		if(!$(this).val()) {
			$(this).val('nombre su nuevo horario');
			$(this).css({
				color : '#B3B3B3',
				fontStyle : 'italic'
			});
		}
	});
	
	$("#saveButton").click(function(){
		var input = $("#inputText").val();
		$("#msgError").hide();
		if(input != 'nombre su nuevo horario'){
			if(input.length > 8){
				$("#msgError").fadeIn(200);
			} else {
				crearHorario(input);
			}
		}
	});
	
	$("#addButton").click(function(){
		$(this).hide();
		$("#inputText").fadeIn(1000);
		$("#saveButton").fadeIn(1000);
	});
		
	function mostrarHorarios() {
		/*Conexión AJAX */
		vaciarResultados();
		parametros = {
			'tipsol' : '0'
		}

		$.ajax({
			url : '/acmuniandes_hor/_php/hor_core.php',
			dataType : 'json', //hace que se evalue el json que retorna el servidor como un objeto
			data : parametros,
			type : 'POST',
			success : function(response) {
				if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
				}
				else {
					if(response.length == 0){
						console.log(response);					
						$("#horarios"+j).append('<h2 style="color: #444444;"> No hay ningun horario guardado. <br />Agrega uno nuevo haciendo click en el boton (+) </h2>')
					} else {
						horarios = response;
						sel = 0;
						for(var i in horarios) {
							if(i<5*j){
								$("#horarios"+j).append('<div id="horario'+i+'" idbd="'+horarios[i].id_horario+'" class="horario"><button id="delButton'+i+'" class="delete">x</button><p><span style="font-size: 40px;">'+horarios[i].nombre+'</span> <br />Creditos: '+horarios[i].creditos_Totales+'<br /># Cursos: '+horarios[i].num_Cursos+'<br />Fecha de Creacion: '+horarios[i].fechaCreacion+'<br /></p></div>&nbsp&nbsp');
							}
							else{
								j++;
								$("#horcontent").append('<div id="horarios'+j+'" align="center" class="content"></div>');
								$("#horarios"+j).append('<div id="horario'+i+'" idbd="'+horarios[i].id_horario+'" class="horario"><button id="delButton'+i+'" class="delete">x</button><p><span style="font-size: 40px;">'+horarios[i].nombre+'</span> <br />Creditos: '+horarios[i].creditos_Totales+'<br /># Cursos: '+horarios[i].num_Cursos+'<br />Fecha de Creacion: '+horarios[i].fechaCreacion+'<br /></p></div>&nbsp&nbsp');
	
							}
							sel = i;
							$("#horario"+i).click(function(){
								abrirHorario(''+$(this).attr('idbd'));
							});
							$("#delButton"+i).click(function(event){
								event.stopPropagation();
								eliminarHorario(''+$("#horario"+i).attr('idbd'))
							});
						}
						inicilializar();					
					}
				}
			}
		});
	}

	
	function abrirHorario(id)
	{
		parametros = {
			'tipsol' : '6',
			'id_hor' : id
		};
		postform('/acmuniandes_hor/_php/hor_core.php',parametros)
	}
	
	
	function inicilializar() {
		$('.horario').hover(function() {
			$(this).css({
				opacity : 1
			})
			$(this).find('button').show();
		}, function() {
			$(this).css({
				opacity : 0.8
			})
			$(this).find('button').hide();
		});
	}

	function crearHorario(nombre) {
		/* Genera un dialogo para escribir el nombre del horario */
		/*Conexión AJAX */
		parametros = {
			'nomhor' : nombre,
			'tipsol' : '1'
		};
		$.ajax({
			url : '/acmuniandes_hor/_php/hor_core.php',
			data : parametros,
			dataType : 'json',
			type : 'POST',
			success : function(response) {
				if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
				}
				if(response) {
					restaurarBotones()
					$("#dialogConf").attr('title','Success!');
					$("#dialogConf").empty();
					$("#dialogConf").append("El horario ha sido creado con exito.");
					$("#dialogConf").dialog({
						modal : true
					});
					mostrarHorarios();
				} else {
					$("#dialogConf").attr('title','Oops!');
					$("#dialogConf").empty();
					$("#dialogConf").append("<p>El horario no ha sido creado.<br />Por favor intente de nuevo</p>");
					$("#dialogConf").dialog({
						modal : true
					});
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
			url : '/acmuniandes_hor/_php/hor_core.php',
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
					restaurarBotones();
					$("#dialogConf").attr('title','Success!');
					$("#dialogConf").empty();
					$("#dialogConf").append("El horario ha sido eliminado con exito.");
					$("#dialogConf").dialog({
						modal : true
					});
					if(sel == 5*(j-1)){
						j--;						
					}
					mostrarHorarios();
				}
				else{
					$("#dialogConf").attr('title','Oops!');
					$("#dialogConf").empty();
					$("#dialogConf").append("<p>El horario no ha sido eliminado.<br />Por favor intente de nuevo</p>");
					$("#dialogConf").dialog({
						modal : true
					});
				}
			}
		});

	}
	

	function vaciarResultados(){
		$("#horarios1").empty();
		$("#horarios1").siblings().remove();
		
	}
	
	function restaurarBotones(){
		$("#inputText").hide();
		$("#saveButton").hide();
		$("#addButton").fadeIn(1000);
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
