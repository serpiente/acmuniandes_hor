$(function() {
	var date = new Date();
	var mapaDias = {
		L : darFecha(1),
		M : darFecha(2),
		I : darFecha(3),
		J : darFecha(4),
		V : darFecha(5),
		S : darFecha(6)
	}
	
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
		
	}
	
	$("#searchButton").click(function(){
		obtenerResultados($("#searchInputText").val());
	});
	
	$("#searchInputText").keypress(function(event){
		if ( event.which == 13 ){
			obtenerResultados($("#searchInputText").val());
		}
	});
	
	
	$("#searchResults").jqGrid({
		dataType : "json",
		colNames : ["Nombre","CRN","Profesor"],
		colModel : [	
			{name:'nombre', index:'nombre', width:90, sortable:false},
			{name:'crn', index:'crn', width:90, sortable:false}, 
        	{name:'prof', index:'prof', width:80, sortable:false}, 
    	],
		gridview: true,
    	caption: "Resultados"
	});
	
	var data = { 
  	"total": "1", 
  	"page": "1", 
  	"records": "2",
  	"rows" : [
    		{"nombre" :"Juan", "crn" : "2008", "prof": "Tejada"},
    		{"nombre" :"Carlos", "crn" : "20087888", "prof": "Ed"}
    	]
	};
	
	console.log(data);
	console.log($("#searchResults"));
	//$("#searchResults")[0].addJSONData(data);
	//console.log(mapaDias['L']);
		
		
	
	// var eventData = {
		// events : [
		   // {"id":1, "start": new Date(year, month, day, 12), "end": new Date(year, month, day, 13, 35),"title":"Lunch with Mike"},
		   // {"id":2, "start": new Date(year, month, day, 14), "end": new Date(year, month, day, 14, 45),"title":"Dev Meeting"},
		   // {"id":3, "start": new Date(year, month, day + 1, 18), "end": new Date(year, month, day + 1, 18, 45),"title":"Hair cut"},
		   // {"id":4, "start": new Date(year, month, day - 1, 8), "end": new Date(year, month, day - 1, 9, 30),"title":"Team breakfast"},
		   // {"id":5, "start": new Date(year, month, day + 1, 14), "end": new Date(year, month, day + 1, 15),"title":"Product showcase"}
		// ]
	// };
	var calendar = $('#scheduleContainer');
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
			return 700;
     	},
		//data : eventData
	});
});
