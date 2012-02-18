$(function() {
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
		{nombre:"APO1",cod:"ISIS-1501",sec:"1",prof:"Juan Tejada",disp:"12",salon:"ML505",depto:"Ing. Sistemas",crn:"44001",cred:"3",tipo:"ord"},
		{nombre:"Introduccion",cod:"IIND-1101",sec:"1",prof:"Carlos Ballen",disp:"9",salon:"LL101",depto:"Ing. Industrial",crn:"22332",cred:"3",tipo:"ord"}
	];
	function Horario(){
		this.id_horario;
		this.usuario;
		this.creditos_Totales = 0;
		this.fechaCreacion;
		this.guardado;
		this.nombre;
		this.numCursos = 0;
		this.cursos = [];
	}
	var horarioActual = new Horario();
	
	
	/**
	 * Retorna la fecha (i.e. Feb 22/2012) de la semana actual que corresponde al dia de la semana dado por parametro
	 * El proposito de esta funcion es obtener fechas que puedan ser pasadas al objeto calendario y renderizadas correctamente
	 * @param diaSem dia de la semana del cual se quiere conocer la fecha en la semana actual {1,2,3,4,5,6}
	 */
	function darFecha(diaSem){
		return new Date(date.getFullYear(), date.getMonth(), date.getDate()-(date.getDay()-diaSem));
	}	
	
	/**
	 * Consulta cursos con el servidor dado una entrada del usuario y los muestra en el campo indicado
	 */
	function obtenerResultados(input){
		//TODO Realizar consulta al servidor y obtener y mostrar los resultados obtenidos dado la consulta del usuario
		resultGrid.jqGrid('clearGridData',this);
		for(var i=0;i<=myData.length;i++)
            resultGrid.jqGrid('addRowData',i + 1, myData[i]);
        
        inicializarResultadosDraggable();
	}
	
	/**
	 * Inicializa la interacción de draggable en los nuevos elementos recibidos del servidor
	 */
	function inicializarResultadosDraggable(){
		$("#1").draggable({
			addClasses : true,
			revert : true,
			helper: function(event) {
				console.log($(event.target));
				return $('<div class="helper"><table></table></div>').find('table').append($(event.target).closest('tr').clone()).end().appendTo('body');
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
		colNames : ["Nombre","Cod.","Sec.","Profesor","Disp.","Salon","Depto.","CRN","Creds.","Tipo"],
		colModel : [	
			{name:'nombre',index:'nombre',width:70},
			{name:'cod',index:'cod',width:70},
			{name:'sec',index:'sec',width:70},
        	{name:'prof',index:'prof',width:70},
        	{name:'disp',index:'disp',width:70},
        	{name:'salon',index:'salon',width:70},
        	{name:'depto',index:'depto',width:70},
        	{name:'crn',index:'crn',width:70}, 
        	{name:'cred',index:'cred',width:70},
        	{name:'tipo',index:'tipo',width:70}
    	],
		gridview: true,
    	caption: "Resultados",
    	shrinkToFit: false,
    	width: 315,
    	height : 525
	});
	
	// var eventData = {
		// events : [
		   // {"id":1, "start": new Date(year, month, day, 12), "end": new Date(year, month, day, 13, 35),"title":"Lunch with Mike"},
		   // {"id":2, "start": new Date(year, month, day, 14), "end": new Date(year, month, day, 14, 45),"title":"Dev Meeting"},
		   // {"id":3, "start": new Date(year, month, day + 1, 18), "end": new Date(year, month, day + 1, 18, 45),"title":"Hair cut"},
		   // {"id":4, "start": new Date(year, month, day - 1, 8), "end": new Date(year, month, day - 1, 9, 30),"title":"Team breakfast"},
		   // {"id":5, "start": new Date(year, month, day + 1, 14), "end": new Date(year, month, day + 1, 15),"title":"Product showcase"}
		// ]
	// };
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
         if (calEvent.end.getTime() < new Date().getTime()) {
            $event.css("opacity", "0.5");
         }
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
			calendar.weekCalendar("updateEvent",{id:1, start: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 12), end: new Date(date.getFullYear(), date.getMonth(), date.getDate(), 13, 35),title:"Lunch with Mike"});
		},
		out: function(){
			calendar.weekCalendar("removeEvent",1);
		},
		drop: function(){
			calendar.weekCalendar("updateEvent",{id:1});
		}
	});
});
