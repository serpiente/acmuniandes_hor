$(function() {
	// var dropped = false;
	var sel = -1;
	var date = new Date();
	var calendar = $('#scheduleContainer');
	var resultGrid = $("#searchResults");
	var mapaDias = {
		L : darFecha(1),
		M : darFecha(2),
		I : darFecha(3),
		J : darFecha(4),
		V : darFecha(5),
		S : darFecha(6)
	}
	var resultados = [{
		"capacidad_Total" : 25,
		"codigo_Curso" : "ISIS2203",
		"creditos" : 3,
		"crn" : "45663",
		"cupos_Disponibles" : 15,
		"departamento" : "Ingenieria de Sistemas",
		"nombre" : "Lenguajes y Maquinas",
		"seccion" : 1,
		"tipo" : null,
		"complementarias" : [],
		"ocurrencias" : [{
			"dia" : "L",
			"horaInicio" : "10:00",
			"horaFin" : "11:20",
			"salon" : "O201",
			"unidades_Duracion" : 3
		},{
			"dia" : "I",
			"horaInicio" : "10:00",
			"horaFin" : "11:20",
			"salon" : "O201",
			"unidades_Duracion" : 3
		}],
		"profesores" : ["Rodrigo Cardoso"],
		"dias" : "LI",
		"numcompl": 1,
		"inpadre": null
	},{
		"capacidad_Total" : 15,
		"codigo_Curso" : "ISIS2203",
		"creditos" : 0,
		"crn" : "45663",
		"cupos_Disponibles" : 5,
		"departamento" : "Ingenieria de Sistemas",
		"nombre" : "Compl. L y M",
		"seccion" : 1,
		"tipo" : null,
		"complementarias" : [],
		"ocurrencias" : [{
			"dia" : "V",
			"horaInicio" : "10:00",
			"horaFin" : "11:20",
			"salon" : "O301",
			"unidades_Duracion" : 3
		}],
		"profesores" : ["Jaime Beltran"],
		"dias" : "V",
		"numcompl": 0,
		"inpadre": 0	
	},{
		"capacidad_Total" : 30,
		"codigo_Curso" : "IIND3306",
		"creditos" : 3,
		"crn" : "33321",
		"cupos_Disponibles" : 15,
		"departamento" : "Ingenieria Industrial",
		"nombre" : "Finanzas",
		"seccion" : 1,
		"tipo" : null,
		"complementarias" : [],
		"ocurrencias" : [{
			"dia" : "M",
			"horaInicio" : "10:00",
			"horaFin" : "11:20",
			"salon" : "R209",
			"unidades_Duracion" : 3
		},{
			"dia" : "J",
			"horaInicio" : "10:00",
			"horaFin" : "11:20",
			"salon" : "R209",
			"unidades_Duracion" : 3
		}],
		"profesores" : ["Julio Villareal"],
		"dias" : "MJ",
		"numcompl": 0,
		"inpadre": null
	}];
	
	function Horario() {
		this.id_horario = "";
		this.usuario = "";
		this.creditos_Totales = 0;
		this.fechaCreacion = "";
		this.guardado = "";
		this.nombre = "";
		this.numCursos = 0;
		this.cursos = new Array();
	}

	function OcurCalendar(ocur, i, j) {
		// console.log(i);
		this.id = "" + i + "-" + j;

		var hmi = ocur.horaInicio.split(":");
		var fecha = mapaDias[ocur.dia];
		this.start = fecha.setHours(hmi[0], hmi[1]);
		// console.log(this.start);

		var hmf = ocur.horaFin.split(":");
		this.end = fecha.setHours(hmf[0], hmf[1]);
		// console.log(this.end);

		this.title = resultados[i].nombre + "<br>" + ocur.salon;
		this.opac = "0.5";
		// console.log(mapaDias);
	}

	var horarioActual = new Horario();

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
		//TODO Realizar consulta al servidor y obtener y mostrar los resultados obtenidos dado la consulta del usuario
		resultGrid.jqGrid('clearGridData', this);
		rowindex = 0;
		for(var i = 0; i < resultados.length; i++) {
			resultados[i].profesor = resultados[i].profesores[0];
			resultGrid.jqGrid('addRowData', i, resultados[i]);
		}
				
		inicializarResultados();
	}

	/**
	 * Inicializa todos los eventos necesarios sobre los nuevos resultados
	 */

	function inicializarResultados() {
		// $('.jqgrow').draggable({
			// addClasses : false,
			// revert : true,
			// //helper: "clone",
			// //appendTo: "#helper",
			// helper : function(event) {
				// sel = $(this).attr('id');
				// return $(this).clone().appendTo('#helper');
			// },
			// start : function(event, ui) {
				// dropped = false;
				// $(this).hide();
			// },
			// stop : function(event) {
				// if(!dropped) {
					// $(this).show();
				// }
			// },
			// zIndex : 100
		// });
		$('.jqgrow').attr('addbl','true');
		
		$('.jqgrow').dblclick(function(){
			agregarCursoCalendar(false, $(this));
		});
		
		//TODO Fix This!!
		$('.jqgrow').hover(function() {
			sel = $(this).attr('id');
			agregarCursoCalendar(true);
			//setTimeout(agregarCursoCalendar,'500');
		}, function() {
			if(!$(this).attr('out'))
				removerCursoCalendar(true);
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
	 * @param opac La opacidad que deben tener las ocurrencias del curso al agregarlas al calendar
	 */
	function agregarCursoCalendar(vistaprevia, row) {
		if(!vistaprevia){
			if($('#' + sel).attr('addbl') == 'false') {
				alert("Se debe agregar una de las clases complementarias de la magistral, o la clase magistral correspondiente");
				removerCursoCalendar(true);
			}
			else{
				if(resultados[sel].inpadre >= 0) {
					// console.log('here this be');
					// console.log('.jqgrow:gt(' + resultados[sel].inpadre + '):lt(' + resultados[sel].inpadre + ')')
					// console.log($('.jqgrow:gt(' + resultados[sel].inpadre + '):lt(' + resultados[sel].inpadre + ')'));
					$('.jqgrow:gt(' + resultados[sel].inpadre + '),.jqgrow:lt(' + resultados[sel].inpadre + ')').attr('addbl', 'false');
				} else if(resultados[sel].numcompl > 0) {
					$('.jqgrow:lt(' + sel + '),.jqgrow:gt(' + (sel + resultados[sel].numcompl) + ')').attr('addbl', 'false');
				}
				for(var k = 0; k < resultados[sel].ocurrencias.length; k++) {
					var ocur = new OcurCalendar(resultados[sel].ocurrencias[k], sel, k);
					ocur.opac = 1;
				
					calendar.weekCalendar("updateEvent", ocur);
				};
				row.hide();
				row.attr('out','true');
			}
		}
		else{
			for(var k = 0; k < resultados[sel].ocurrencias.length; k++) {
				var ocur = new OcurCalendar(resultados[sel].ocurrencias[k], sel, k);

				calendar.weekCalendar("updateEvent", ocur);
			};			
		}
	}
	
	/**
	 * Agrega un curso al horario del usuario
	 */
	function agregarCursoHorario(curso){
		
		horarioActual.cursos[horarioActual.numCursos]=curso;
		horarioActual.numCursos++;
		horarioActual.creditos_Totales += curso.creditos;
	}
	
	/**
	 * Remover un curso del horario del usuario
	 */
	function removerCursoHorario(curso){
		
		var encontro = false;
		var pos = 0;
		while(!encontro)
		{
			if(horarioActual.cursos[pos].crn == curso.crn)
				encontro = true;
			else
				pos++;
		}
		
		horarioActual.cursos.splice(pos,1);
		horarioActual.numCursos--;
		horarioActual.creditos_Totales -= curso.creditos;
	}

	/**
	 * Remueve un curso del jq-week-calendar con todas sus ocurrencias respectivas
	 */
	function removerCursoCalendar(vistaprevia) {
		for(var k = 0; k < resultados[sel].ocurrencias.length; k++) {
			calendar.weekCalendar("removeEvent", "" + sel + "-" + k);
		};
		if(!vistaprevia) {
			//TODO define time
			$('#' + sel).show(500);
			$('#' + sel).removeAttr('out');
		}
	}

	/**
	 * Retorna el contenido del curso actualmente seleccionado al tooltip para ser mostrado
	 */
	function contenidoTTip() {
		return $("<span>Seccion: " + resultados[sel].seccion + "<br>" + "Codigo: " + resultados[sel].codigo_Curso + "<br>" + "Creditos: " + resultados[sel].creditos + "<br>" + "Departamento: " + resultados[sel].departamento + "<br>" + "Capacidad: " + resultados[sel].capacidad_Total + "</span>");
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
			width : 30
		}],
		gridview : true,
		caption : "Cursos Encontrados",
		shrinkToFit : true,
		width : 375,
		height : 536,
		scrollOffset : 0,
		// onSelectRow: function(id) {
		// sel = id;
		// },
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
		buttons : false,
		title : '',
		dateFormat : '',
		readonly : true,
		height : function($calendar) {
			return 600;
		},
		displayOddEven : true,
		eventRender : function(calEvent, $event) {
			// console.log($event);
			$event.css({
				'opacity' : calEvent.opac
				// 'background-color': '#F53400'
			});
			$event.attr('id', calEvent.id);

			$event.prepend($('<div class="icon"><img alt="close" src="_images/close.png" /></div>').hide().click(function() {
				removerCursoCalendar(false);
			}));
			// $event.find('.wc-time').css({
			// 'background-color': '#F53400'
			// });
			// animate({
			// opacity:calEvent.opac
			// }, 500);
			$event.hover(function() {
				sel = calEvent.id.charAt(0);
				// console.log(sel);
				// console.log('[id|="' + sel + '"]');
				// console.log(calendar.find('[id|=' + sel + ']'));
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

	// calendar.droppable({
		// accept : ".jqgrow",
		// over : function() {
			// agregarCursoCalendar(true);
		// },
		// out : function() {
			// removerCursoCalendar(true);
// 
		// },
		// drop : function(event, ui) {
			// dropped = true;
			// $.ui.ddmanager.current.cancelHelperRemoval = false;
			// ui.helper.hide();
			// agregarCursoCalendar(false);
		// }
	// });
});
