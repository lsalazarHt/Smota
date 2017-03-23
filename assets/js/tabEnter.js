var posActual='';

	$('.e').click(function(event){
		posActual = event.target.id;
	});

	$( ".e1" ).focus(function(event) {
		posActual = event.target.id;
	});

	$(".e1").focus();


	$(document).keydown(function(tecla){
	    if (tecla.keyCode == 13) { 
	        var numElements = $('.e').size();
	        var posAux = '';
	        $('.e').each(function(elm) {	        	
	        	var n = parseInt(elm+1);
	        	if( $('.e'+n).attr('id') ===  posActual && n<numElements ){
	        		// console.log(posActual);
	        		$('.e'+parseInt(n+1)).focus();
	        		if( $("#"+posActual).hasClass('key') === true){
	        			// console.log(posActual);
	        			pressEnter(posActual);
	        		}	      			        		
	        		posAux = $('.e'+parseInt(n+1)).attr('id');
	        		
	        	}
	        	if( $('.e'+n).attr('id') ===  posActual && n === numElements && $("#"+posActual).hasClass('key') === true ){
	        		pressEnter(posActual);
	        	}
			});
			posActual=posAux;
	    }
	});