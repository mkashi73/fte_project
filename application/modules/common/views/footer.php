			<div class="slim-footer mg-t-0">
		      <div class="container-fluid">
		        <p>Copyright <?= date('Y') ?> &copy; All Rights Reserved.</p>
		        <p>Developed &amp; Designed by: <a href="https://webicians.com/">Webicians</a></p>
		      </div><!-- container-fluid -->
		    </div><!-- slim-footer -->
		  </div><!-- slim-mainpanel -->
		</div><!-- slim-body -->
		<script type="text/javascript">let base_url = "<?= base_url(); ?>";</script>
		<!-- jquery js -->
	    <script src="<?= base_url(); ?>assets/lib/jquery/js/jquery.js"></script>
		<!-- <script src="//code.jquery.com/jquery-2.2.1.min.js"></script> -->
		<!-- Moment JS for datepicker -->
	    <script src="<?= base_url(); ?>assets/lib/moment/js/moment.js"></script>
	    <!-- jQuery UI -->
	    <script src="<?= base_url(); ?>assets/lib/jquery-ui/js/jquery-ui.js"></script>
	    <!-- sweetalert 2 -->
	    <script src="<?= base_url(); ?>assets/lib/sweetAlert2/sweetalert2.all.min.js"></script>
	    <!-- popper js -->
	    <script src="<?= base_url(); ?>assets/lib/popper.js/js/popper.js"></script>
	    <!-- bootstrap js -->
	    <script src="<?= base_url(); ?>assets/lib/bootstrap/js/bootstrap.js"></script>
		<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

	    <!-- jquery cookie js -->
	    <script src="<?= base_url(); ?>assets/lib/jquery.cookie/js/jquery.cookie.js"></script>
	    <!-- perfect scrollbar js -->
	    <script src="<?= base_url(); ?>assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
        <!-- Dropzone JS -->
        <script src="<?= base_url(); ?>assets/lib/dropzone/dropzone.js"></script>
      
      	<!-- select 2 JS -->
      	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->
		<script src="<?= base_url(); ?>assets/lib/jquery/js/select2.min.js"></script>

      	<!-- custom js -->
	    <script src="<?= base_url(); ?>assets/template/pages/<?= $filepath; ?>"></script>
	    <!-- slim js -->
	    <script src="<?= base_url(); ?>assets/js/slim.js"></script>
	    <!-- Icons Plugin JS -->
	    <script src="<?= base_url(); ?>assets/lib/icons-plugin/js/fontawesome-iconpicker.js"></script>
	    <!-- Tags Input JS -->
	    <script src="<?= base_url(); ?>assets/lib/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>
	    
	    <!-- for datatable -->
	    <script src="<?= base_url(); ?>assets/lib/datatables/js/jquery.dataTables.js"></script>

    	<script src="<?= base_url(); ?>assets/lib/datatables-responsive/js/dataTables.responsive.js"></script>
	    <script>
      $(function(){
        'use strict'

        // Datepicker
        $('.fc-datepicker').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true
        });

        $('#datepickerNoOfMonths').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
          numberOfMonths: 2
        });

      });
    </script>


  </body>
</html>