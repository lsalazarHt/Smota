$(document).on('change', 'select,input,textarea', function() {
  // Does some stuff and logs the event to the console
	cambiosDetectados(true);
});

document.getElementById("btnGuardar").onclick = function() {cambiosDetectados(false)};

function cambiosDetectados(SoN) {
	if(SoN===true){
		window.onbeforeunload = function() { return "You have unsaved changes."; }
	}else{
    	window.onbeforeunload = false;
	}
}