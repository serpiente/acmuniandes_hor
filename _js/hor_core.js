$(function() {
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
	var myData = [
		{nombre:"APO1",cod:"ISIS-1501",sec:"1",prof:"Juan Tejada",disp:"12",depto:"Ing. Sistemas",crn:"44001",cred:"3",tipo:"ord"},
		{nombre:"Introduccion",cod:"IIND-1101",sec:"1",prof:"Carlos Ballen",disp:"9",depto:"Ing. Industrial",crn:"22332",cred:"3",tipo:"ord"}
	];
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
		}],
		"profesores" : ["Rodrigo Cardoso"],
		"dias" : "LMI"
	}];
	function Horario(){
		this.id_horario = "";
		this.usuario = "";
		this.creditos_Totales = 0;
		this.fechaCreacion = "";
		this.guardado = "";
		this.nombre = "";
		this.numCursos = 0;
		this.cursos = [];
	}
	function CursoGrid(curso, i){
		this.nombre = curso.nombre;
		this.cod = curso.codigo_Curso;
		this.sec = curso.seccion;
		this.prof = curso.profesores[0];
		this.disp = curso.cupos_Disponibles;
		this.depto = curso.departamento;
		this.crn = curso.crn;
		this.cred = curso.creditos;
		if(curso.tipo) this.tipo = curso.tipo;
		else this.tipo = "N/A";
		this.i=i;
	}
	function OcurCalendar(ocur,i,j){
		console.log(i);
		this.id = ""+i+""+j;
		
		var hmi = ocur.horaInicio.split(":");
		var fecha = mapaDias[ocur.dia];
		this.start = fecha.setHours(hmi[0],hmi[1]);
		console.log(this.start);
		
		var hmf = ocur.horaFin.split(":");
		this.end = fecha.setHours(hmf[0],hmf[1]);
		console.log(this.end);
		
		this.title = resultados[i].nombre+"\n"+ocur.salon;
		this.opac = "0.5";
		console.log(mapaDias);
	}
	var horarioActual = new Horario();	
	
	/**
	 * Retorna la fecha (i.e. Feb 22/2012) de la semana actual que corresponde al dia de la semana dado por parametro
	 * El proposito de esta funcion es obtener fechas que puedan ser pasadas al objeto calendario y renderizadas correctamente
	 * @param diaSem dia de la semana del cual se quiere conocer la fecha en la semana actual {1,2,3,4,5,6}
	 */
	function darFecha(diaSem){
		if(date.getDay()==0){
			return new Date(date.getFullYear(), date.getMonth(), (date.getDate()-(date.getDay()-diaSem))-7);
		}
		return new Date(date.getFullYear(), date.getMonth(), date.getDate()-(date.getDay()-diaSem));
	}	
	
	/**
	 * Consulta cursos con el servidor dado una entrada del usuario y los muestra en el campo indicado
	 */
	function obtenerResultados(input){
		//TODO Realizar consulta al servidor y obtener y mostrar los resultados obtenidos dado la consulta del usuario
		resultGrid.jqGrid('clearGridData',this);
		// for (var j=0; j < 60; j++) {
		  for(var i=0;i<resultados.length;i++)
            resultGrid.jqGrid('addRowData',i + 1, new CursoGrid(resultados[i],i));
		// };
        
        inicializarResultadosDraggable();
	}
	
	/**
	 * Inicializa la interacción de draggable en los nuevos elementos recibidos del servidor
	 */
	function inicializarResultadosDraggable(){
		$("#1").draggable({
			addClasses : true,
			revert : true,
			// helper: "clone",
			// appendTo: "#helper",
			helper: function(event) {
				console.log(sel);
				return $('#helper').append(resultados[sel].nombre);
			},
			start: function(event, ui) {
				$(this).hide();
			},
			stop: function(event) {
               	$(this).show();
        	}
		});	
	}

	//---------INICIALIZACION DE GRID Y CALENDAR---------------
	resultGrid.jqGrid({
		datatype: "local",
		colNames : ["Nombre","Cod.","Sec.","Profesor","Disp.","Depto.","CRN","Creds.","Tipo"],
		colModel : [	
			{name:'nombre',index:'nombre',width:70},
			{name:'cod',index:'cod',width:70},
			{name:'sec',index:'sec',width:70},
        	{name:'prof',index:'prof',width:70},
        	{name:'disp',index:'disp',width:70},
        	{name:'depto',index:'depto',width:70},
        	{name:'crn',index:'crn',width:70}, 
        	{name:'cred',index:'cred',width:70},
        	{name:'tipo',index:'tipo',width:70}
    	],
		gridview: true,
    	caption: "Cursos Disponibles",
    	shrinkToFit: false,
    	width: 375,
    	height : 536,
		onSelectRow: function(id) {
			console.log(id);
			sel = id-1;
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
     		$event.animate({
               	opacity:calEvent.opac
            }, 500);
      	}
		//data : eventData
	});
	
	
	//---------INICIALIZACION DE EVENTOS---------------
	$("#searchButton").click(function(){
		obtenerResultados($("#searchInputText").val());
	});
	
	$("#searchInputText").keypress(function(event){
		if ( event.which == 13 ){
			obtenerResultados($("#searchInputText").val());
		}
	});
	
	calendar.droppable({
		//accept: ".helper",
		over: function(){
			//TODO
			for (var k=0; k < resultados[sel].ocurrencias.length; k++) {
				var ocur = new OcurCalendar(resultados[sel].ocurrencias[k],sel,k);
				console.log(ocur);
				calendar.weekCalendar("updateEvent",ocur);
			};
		},
		out: function(){
			for (var k=0; k < resultados[sel].ocurrencias.length; k++) {
				calendar.weekCalendar("removeEvent",""+sel+""+k);
			};
			
		},
		drop: function(event,ui){
			for(var k = 0; k < resultados[sel].ocurrencias.length; k++) {
				var ocur = new OcurCalendar(resultados[sel].ocurrencias[k], sel, k);
				ocur.opac = "1";
				calendar.weekCalendar("updateEvent",ocur);
			}
			ui.helper.hide();
		}
	});
});
