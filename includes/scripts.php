<!-- jQuery 3 -->

<!--script src="js/jquery.min.js"></script-->

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="js/bootstrap.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="js/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="js/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="js/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<!-- iCheck -->
<script src="js/icheck.min.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- date-range-picker -->
<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.js"></script>
<!-- select-picker -->
<script src="js/bootstrap-select.min.js"></script>
<!-- datatables -->
<!--script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<--script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script-->

<!--script type="text/javascript" src="plugins/DataTables/datatables.js"></script!-->
<script type="text/javascript" src="plugins/DataTables/DataTables-1.10.20/js/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
	//inicia las clases tipo datepicker
	$('.datepicker').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true,
		locale: {
			format: 'DD/MM/YYYY'
		}
	})
	
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#tabladatos').DataTable( {
        dom: 'Bfrtip',
		orientation: 'landscape',
        pageSize: 'LEGAL',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'pdfHtml5'
        ]
    } );
} );
	</script>
