	<!-- jQuery 2.1.4 -->
	<script src="tools/plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<!-- Bootstrap 3.3.5 -->
	<script src="tools/bootstrap/js/bootstrap.min.js"></script>
	<!-- DataTables -->
    <script src="tools/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="tools/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="tools/plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="tools/plugins/fastclick/fastclick.min.js"></script>
	<!-- AdminLTE App -->
	<script src="tools/dist/js/app.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="tools/dist/js/demo.js"></script>
	<!-- Bootbox -->
	<script src="tools/dist/js/bootbox.min.js"></script>
	<script type="text/javascript">

	    $(document).ready(function () {
			$('#mActaInd').hover(function(){
				$('.liConsul').addClass('display-none');
				$('.liRepor').addClass('display-none');
				$('.liActaInd').removeClass('display-none');
			});
			$('#mConsultas').hover(function(){
				$('.liActaInd').addClass('display-none');
				$('.liRepor').addClass('display-none');
				$('.liConsul').removeClass('display-none');
			});
			$('#mReportes').hover(function(){
				$('.liActaInd').addClass('display-none');
				$('.liConsul').addClass('display-none');
				$('.liRepor').removeClass('display-none');
			});

			$('.mResto').hover(function(){
				$('.liActaInd').addClass('display-none');
				$('.liConsul').addClass('display-none');
				$('.liRepor').addClass('display-none');
				$('.liReportAlmac').addClass('display-none');
			});

			$('#mReportAlm').hover(function(){
				
				$('.liReportAlmac').removeClass('display-none');
			});
			$('.dropdown').click(function(){
				$('.liActaInd').addClass('display-none');
				$('.liConsul').addClass('display-none');
				$('.liRepor').addClass('display-none');
			});
		});

		/*var bPreguntar = true;
		window.onbeforeunload = preguntarAntesDeSalir;
		function preguntarAntesDeSalir(){
			if (bPreguntar)
			return '';
		}*/
	</script>
</html>