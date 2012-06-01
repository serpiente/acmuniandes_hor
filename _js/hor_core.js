/**
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes. Liderado por Juan Tejada y Jorge Lopez.
 */
$(function() {
	var bigIndex = 0;
	var sel = -1;
	var date = new Date();
	var calendar = $('#scheduleContainer');
	var resultGrid = $('#searchResults');
	var mapaDias = {
		L : darFecha(1),
		M : darFecha(2),
		I : darFecha(3),
		J : darFecha(4),
		V : darFecha(5),
		S : darFecha(6)
	};
	var resultdos = [];
	
	function Horario(obj) {
		if(obj){
			for (var i in obj) {
        		if (!obj.hasOwnProperty(i)) continue;
        		this[i] = obj[i];
    		}
		}
		else{
			this.id_horario = "";
			this.usuario = "";
			this.creditos_Totales = 0;
			this.fechaCreacion = "";
			this.guardado = "";
			this.nombre = "";
			this.num_Cursos = 0;
			this.cursos = [];
		}
	}

	function OcurCalendar(curso, ocur, i, j, ie, numocur) {
		this.id = "" + i + "-" + j;

		var hmi = {0:ocur.horaInicio.substring(0,2), 1:ocur.horaInicio.substring(2,ocur.horaInicio.length)};
		var fecha = mapaDias[ocur.dia];
		this.start = fecha.setHours(hmi[0], hmi[1]);

		var hmf = {0:ocur.horaFin.substring(0,2), 1:ocur.horaFin.substring(2,ocur.horaFin.length)};
		this.end = fecha.setHours(hmf[0], hmf[1]);

		this.title = curso.nombre + "<br>" + ocur.salon;
		this.opac = "0.5";
		if(curso.persistido) this.persistido = curso.persistido;
		else this.persistido = false;
		
		this.indiceEnResultados = ie;
		this.numocur = numocur;
		this.curso = curso;
	}

	var horarioActual;
	abrirHorario();
	
	/**
	 * Hace un llamado al servidor para abrir un horario seleccionado previemanente por el usuario.
	 * Si no hay un horario para abrir inicializa un nuevo horario vacio
	 */
	function abrirHorario() {
		$.ajax({
			url : '/acmuniandes_hor/_php/hor_core.php',
			dataType : 'json',
			data : {
				'tipsol' : '7',
			},
			type : 'POST',
			success : function(response) {
				if(response) {
					if(response.redirect) {
						// data.redirect contains the string URL to redirect to
						document.location = response.redirect;
					}
					else{
						horarioActual =  new Horario(response);
						for(var key in horarioActual.cursos){
							sel = "p"+key;
							horarioActual.cursos[key].id = "p"+key;
							horarioActual.cursos[key].persistido = true;
							agregarCursoCalendar(horarioActual.cursos[key], false, null);
						}
					}
				} else {
					horarioActual = new Horario();
				}
			}
		});
	}


	/**
	 * Retorna la fecha (i.e. Feb 22/2012) de la semana actual que corresponde al dia de la semana dado por parametro
	 * El proposito de esta funcion es obtener fechas que puedan ser pasadas al objeto calendario y renderizadas correctamente
	 * @param diaSem dia de la semana del cual se quiere conocer la fecha en la semana actual {1,2,3,4,5,6}
	 */
	function darFecha(diaSem) {
		if(date.getDay() == 0) {
			return new Date(date.getFullYear(), date.getMonth(), (date.getDate() - (date.getDay() - diaSem)) - 7);
		}
		return new Date(date.getFullYear(), date.getMonth(), date.getDate() - (date.getDay() - diaSem));
	}

	/**
	 * Consulta cursos con el servidor dado una entrada del usuario y los muestra en el campo indicado
	 */
	function obtenerResultados(input) {
		if(input){			
			$.ajax({
				url : '/acmuniandes_hor/_php/hor_conslt.php',
				dataType : 'json',
				data : {
					'valcon' : input,
					'cbuflag': false //TODO hace falta incluir selector de cbu
				},
				type : 'GET',
				success : function(response) {
					if(response) {
						if(response.redirect) {
							// data.redirect contains the string URL to redirect to
							document.location = response.redirect;
						} else if(response.message){
							$("#dialogConf").empty();
							$("#dialogConf").append(response.message);
							$("#dialogConf").dialog({
								modal: true
							});
						}
						else{
							resultados = response;
							resultGrid.jqGrid('clearGridData', this);
							for(var i = 0; i < resultados.length; i++) {
								resultados[i].profesor = "" + resultados[i].profesores[0];
								resultados[i].id = bigIndex;
								resultGrid.jqGrid('addRowData', bigIndex, resultados[i]);
								$('#'+bigIndex).attr('ie',i);
								bigIndex++;
							}
							inicializarResultados();
						}
					} else {
						alert("La busqueda ha fallado, por favor intente de nuevo");
					}
				}
			});
		}
		else{
			$("#dialogConf").empty();
			$("#dialogConf").append("Se debe ingresar una consulta");
			$("#dialogConf").dialog({
				modal: true
			});
		}
				
		inicializarResultados();
	}

	/**
	 * Inicializa todos los eventos necesarios sobre los nuevos resultados
	 */
	function inicializarResultados() {
		
		$('.jqgrow').attr('addbl','true');
		
		$('.jqgrow').dblclick(function(){
			if(!$("#"+sel).attr('confl')){
				agregarCursoCalendar(null, false, $(this));
				agregarCursoHorario(resultados[$(this).attr('ie')]);
			}
		});
		
		$('.jqgrow').hover(function() {
			sel = $(this).attr('id');
			if(verificarConflictoHorario(resultados[$(this).attr('ie')])){
				agregarCursoCalendar(null, true, $(this));
			}
			else{
				$("#"+sel).attr('confl','true');
				$("#"+sel).css({'background':'#E42217','opacity': 0.9});
			}
		}, function() {
			if(!$(this).attr('out'))
			{
				$("#"+sel).removeAttr('confl');
				$("#"+sel).css({'background':'', 'opacity':1});
				removerCursoCalendar(true, false, $(this).attr('ie'), resultados[$(this).attr('ie')].ocurrencias.length);
			}
				
		});

		$('.jqgrow').poshytip({
			content : contenidoTTip,
			className : 'tip-twitter',
			showTimeout : 500,
			alignTo : 'cursor',
			alignX : 'center',
			offsetY : 20,
			allowTipHover : false,
			fade : false,
			slide : true
		});
	}

	/**
	 * Agrega un curso al jq-week-calendar con todas sus ocurrencias respectivas
	 * @param curso objeto curso a ser agregado. Si es nulo se agrega el curso que este actualmente seleccionado dentro del arreglo de resultados con el indice sel.
	 * @param vistaprevia booleano indicando si el curso se va a agregar al calendario como vista previa o no
	 * @param row el objeto gráfico (del DOM) que representa la fila dentro de la lista de resultados que muestra la informacion del curso
	 */
	function agregarCursoCalendar(curso, vistaprevia, row) {
		
		var cursoAAgregar;
		if(curso != null){
			cursoAAgregar = curso;
		}
		else{
			cursoAAgregar = resultados[row.attr('ie')];
		}
		for(var k = 0; k < cursoAAgregar.ocurrencias.length; k++) {
			// if(new Date(cursoAAgregar.ocurrencias[k].fechaini) < date && new Date(cursoAAgregar.ocurrencias[k].fechafin) > date){
				var ocur = new OcurCalendar(cursoAAgregar, cursoAAgregar.ocurrencias[k], cursoAAgregar.id, k, cursoAAgregar.indiceEnResultados, cursoAAgregar.ocurrencias.length);
				if(!vistaprevia) ocur.opac = 1;
				calendar.weekCalendar("updateEvent", ocur);
			// }
		}
		if(!vistaprevia){
			if(row != null){
				row.hide();
				row.attr('out', 'true');
			}
		}
	}


	/**
	 * Remueve un curso del jq-week-calendar con todas sus ocurrencias respectivas
	 */
	function removerCursoCalendar(vistaprevia, persistido, indiceEnResultados, numocur) {
		
		if(persistido){
			for(var k = 0; k < horarioActual.cursos[sel.substring(1,sel.length)].ocurrencias.length; k++) {
				calendar.weekCalendar("removeEvent", "" + sel + "-" + k);
			}
		}
		else{
			for(var k = 0; k < numocur; k++) {
				calendar.weekCalendar("removeEvent", "" + sel + "-" + k);
			}	
		}
		
		if(!vistaprevia) {
			if($('#' + sel)){
				$('#' + sel).show(500);
				$('#' + sel).removeAttr('out');
			}
		}
	}
	
	/**
	 * Agrega un curso al horario del usuario
	 * @param curso el objeto de tipo curso a ser agregado
	 */
	function agregarCursoHorario(curso){
		horarioActual.cursos[horarioActual.num_Cursos]=curso;
		horarioActual.num_Cursos++;
		horarioActual.creditos_Totales = parseInt(horarioActual.creditos_Totales)+ parseInt(curso.creditos);
	}
	
	/**
	 * Remover un curso del horario del usuario
	 * @param curso el objeto de tipo curso a ser removido
	 */
	function removerCursoHorario(curso){
		var encontro = false;
		var pos = 0;
		while(!encontro)
		{
			if(horarioActual.cursos[pos] != null && horarioActual.cursos[pos].crn == curso.crn)
				encontro = true;
			else
				pos++;
		}
		
		horarioActual.cursos[pos] = null;
		horarioActual.num_Cursos--;
		horarioActual.creditos_Totales -= curso.creditos;
	}
	
	/**
	 * Guarda el horario actual de un usuario en el servidor. Si encuentra problemas de complementarias envía una alerta.
	 */
	function guardarHorario(){
		if(horarioActual.cursos.length == 0){
			$("#dialogConf").empty();
			$("#dialogConf").append("El horario actual se encuentra vacio");
			$("#dialogConf").dialog({
				modal: true
			});
		}
		else{
			
			var probs = verificarHorario()
			if(probs.length > 0){
				
				var info = "El horario actual contiene los siguientes cursos inscritos <b>sin</b> sus respectivas complementarias o magistrales: <br>"
				
				for(var i=0,j=probs.length; i<j; i++){
				  info += "<li>"+probs[i]+"</li>";
				};
				
				info += "</ul><br>"
				info += "Desea continuar guardando su horario?"
				
				$("#dialogConf").empty();
				$("#dialogConf").append(info);
				$("#dialogConf").dialog({
					modal: true,
					buttons: {
						"Si": function(){
							$(this).dialog("close")
							$.ajax({
								url : '/acmuniandes_hor/_php/hor_core.php',
								data : {'tipsol':'5','horario':horarioActual},
								dataType : 'json',
								type : 'POST',
								success : function(response) {
									if(response){
										if(response.redirect) {
											// data.redirect contains the string URL to redirect to
											document.location = response.redirect;
										} else { 
											alert("El horario ha sido guardado correctamente.")
										}
									}
									else{
										alert("El horario NO ha sido guardado correctamente.Por favor intente de nuevo")					
									}
								}
							});
						},
						"No": function(){ $(this).dialog("close")}
					}				
				});
			} else {
				$.ajax({
					url : '/acmuniandes_hor/_php/hor_core.php',
					data : {
						'tipsol' : '5',
						'horario' : horarioActual
					},
					dataType : 'json',
					type : 'POST',
					success : function(response) {
						if(response) {
							if(response.redirect) {
								// data.redirect contains the string URL to redirect to
								document.location = response.redirect;
							} else {
								alert("El horario ha sido guardado correctamente.")
							}
						} else {
							alert("El horario NO ha sido guardado correctamente.Por favor intente de nuevo")
						}
					}
				});
			}
		}		
	}
	
	/**
	 * Verifica que en el horario actual esten inscritas las complementarias para los cursos que los requieran y
	 * que esten las magistrales de los cursos complementarios inscritos.
	 * @return arreglo con los nombres de los cursos que presentan problemas
	 */
	function verificarHorario(){
		var probs = [];
		
		for(var i=0,j=horarioActual.cursos.length; i<j; i++){
			if(horarioActual.cursos[i] != null){				
				if(horarioActual.cursos[i].numcompl > 0){
			  		var encontro = false;
			  		for(var k=horarioActual.cursos[i].indiceEnResultados+1,l=k+horarioActual.cursos[i].numcompl; k<l && !encontro; k++){
						for(var m=0,n=horarioActual.cursos.length; m<n; m++){
					  		if(horarioActual.cursos[m].crn == resultados[k].crn && m!=i){
					  			encontro = true;
					  		}
						}	
					}
					if(!encontro){
						probs[probs.length] = horarioActual.cursos[i].nombre;
					}
			  	} else if(horarioActual.cursos[i].inpadre != null){
			  		var encontro = false;
			  		for(var k=0,l=horarioActual.cursos.length; k<l; k++){
						if(k!=i && horarioActual.cursos[k].crn == resultados[horarioActual.cursos[i].inpadre].crn){
							encontro = true
						}
					}
					if(!encontro){
						probs[probs.length] = horarioActual.cursos[i].nombre;
					}
			 	}
			}
		}
		return probs;
	}
	
	/**
	 * Verifica si el curso seleccionado (al calendario de)que será agregado como evento al calendario de eventos)
	 * presenta un conflicto de horario con un curso ya existente dentro del horario.
	 * @param curso objeto tipo Curso que será agregado al calendario.
	 * @return si es valido agregar el curso seleccionado o no
	 */
	function verificarConflictoHorario(curso){
		
		agregar = true;
		nuevasOcurrencias = curso.ocurrencias;
		
		for(i = 0; agregar && i < horarioActual.cursos.length; i++)
		{
			if(horarioActual.cursos[i] != null){
				ocurrenciasActuales = horarioActual.cursos[i].ocurrencias;
				for(j = 0; agregar && j < ocurrenciasActuales.length; j++)
				{
					ocurrenciaActual = ocurrenciasActuales[j];
					for(k = 0; agregar && k < nuevasOcurrencias.length; k++)
					{
						ocurrenciaNueva = nuevasOcurrencias[k];
						if(ocurrenciaNueva.dia == ocurrenciaActual.dia)
						{
							inicioOcurrenciaNueva = darNumeroHora(ocurrenciaNueva.horaInicio);
							finOcurrenciaNueva = darNumeroHora(ocurrenciaNueva.horaFin);
							inicioOcurrenciaActual = darNumeroHora(ocurrenciaActual.horaInicio);
							finOcurrenciaActual = darNumeroHora(ocurrenciaActual.horaFin);
							
							if(inicioOcurrenciaNueva >= inicioOcurrenciaActual && inicioOcurrenciaNueva <= finOcurrenciaActual)
								agregar = false;
							else if(inicioOcurrenciaActual >= inicioOcurrenciaNueva && finOcurrenciaActual <= inicioOcurrenciaNueva)
								agregar = false;
						}
					}
				}
			}
		}
		
		return agregar;
		
	}
	
	
	/**
	 * Retorna la version numerica de una hora de una ocurrencia
	 * @return double con la hora de la ocurrencia
	 */
	function darNumeroHora(hora)
	{
		temp = hora.split(':');
		return temp[0] + (temp[1]/60);
	}

	/**
	 * Retorna el contenido del curso actualmente seleccionado al tooltip para ser mostrado
	 * @return contenido html que se mostrará dentro del tooltip
	 */
	function contenidoTTip() {
		return $("<span>Seccion: " + resultados[$("#"+sel).attr('ie')].seccion + "<br>" + "Codigo: " + resultados[$("#"+sel).attr('ie')].codigo_Curso + "<br>" + "Creditos: " + resultados[$("#"+sel).attr('ie')].creditos + "<br>" + "Departamento: " + resultados[$("#"+sel).attr('ie')].departamento + "<br>" + "Capacidad: " + resultados[$("#"+sel).attr('ie')].capacidad_Total + "</span>");
	}

	//---------INICIALIZACION DE GRID Y CALENDAR---------------
	resultGrid.jqGrid({
		datatype : "local",
		cmTemplate : {
			title : false,
			sortable : false
		},
		colNames : ["Nombre", "Profesor", "Disp.", "CRN"],
		colModel : [{
			name : 'nombre',
			width : 100
		}, {
			name : 'profesor',
			width : 100
		}, {
			name : 'cupos_Disponibles',
			width : 30
		}, {
			name : 'crn',
			width : 37
		}],
		gridview : true,
		hoverrows:true,
		caption : "Cursos Encontrados",
		shrinkToFit : true,
		width : 375,
		height : 536,
		scrollOffset : 0,
		beforeSelectRow : function() {
			return false;
		}
	});

	calendar.weekCalendar({
		timeslotsPerHour : 2,
		firstDayOfWeek : 1,
		businessHours : {
			start : 7,
			end : 20,
			limitDisplay : true
		},
		daysToShow : 6,
		longDays : ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		allowCalEventOverlap : false,
		overlapEventsSeparate: true,
		buttons : false,
		title : '',
		dateFormat : '',
		readonly : true,
		height : function($calendar) {
			return 600;
		},
		displayOddEven : true,
		eventRender : function(calEvent, $event) {
			$event.css({
				'opacity' : calEvent.opac
			});
			$event.attr('id', calEvent.id);

			$event.prepend($('<div class="icon"><img alt="close" src="/acmuniandes_hor/_images/close.png" /></div>').hide().click(function() {
				if(calEvent.persistido){
					removerCursoCalendar(true, true, calEvent.indiceEnResultados, calEvent.numocur);
					removerCursoHorario(calEvent.curso);
				} else {
					removerCursoCalendar(false, false, calEvent.indiceEnResultados, calEvent.numocur);
					removerCursoHorario(calEvent.curso);
				}
			}));
			// $event.find('.wc-time').css({
			// 'background': '#F53400'
			// });
			$event.hover(function() {
				sel = calEvent.id.substring(0,calEvent.id.indexOf("-"));
				calendar.find('[id|="' + sel + '"]').find('.icon').show();
			}, function() {
				calendar.find('[id|="' + sel + '"]').find('.icon').hide();
			});
		}
	});

	//---------INICIALIZACION DE EVENTOS---------------
	$("#searchButton").click(function() {
		obtenerResultados($("#searchInputText").val());
	});

	$("#searchInputText").keypress(function(event) {
		if(event.which == 13) {
			obtenerResultados($("#searchInputText").val());
		}
	});

	$("#searchInputText").focus(function() {
		$(this).val('');
		$(this).css({
			color : 'black',
			fontStyle : 'normal'
		});
	});

	$("#searchInputText").focusout(function() {
		if(!$(this).val()) {
			$(this).val('ingrese cualquier busqueda');
			$(this).css({
				color : '#B3B3B3',
				fontStyle : 'italic'
			});
		}
	});
	
	$("#saveButton").click(function(){
		guardarHorario();
	});
	
	$("#adminButton").click(function(){
		document.location = '/acmuniandes_hor/hor_admin.html';
	});
	
	$("#logoutButton").click(function(){
		params = {tipsol:'4'};
		postform('/acmuniandes_hor/_php/hor_auth.php',params);
	});
	
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
