var posActual='';

	$('.e').click(function(event){
		posActual = event.target.id;
	});

	$( ".e1" ).focus(function(event) {
		posActual = event.target.id;
	});

	$(document).keydown(function(tecla){
	    if (tecla.keyCode == 13) { 
	        var numElements = $('.e').size();
	        var posAux = '';
	        $('.e').each(function(elm) {	        	
	        	 var n = parseInt(elm+1);
	        	if( $('.e'+n).attr('id') ===  posActual && n<numElements ){
	        		$('.e'+parseInt(n+1)).focus();
	        		console.log(posActual);
	        		if( $("#"+posActual).hasClass('key') === true){
	        			console.log(posActual);
	        			$("#"+posActual).keypress();
	        		}	 
	        		console.log(posActual);       			        		
	        		posAux = $('.e'+parseInt(n+1)).attr('id');
	        		
	        	}
			});
			posActual=posAux;
	    }
	});