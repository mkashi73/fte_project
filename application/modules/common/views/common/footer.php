			<div class="slim-footer mg-t-0">
		      <div class="container-fluid">
		        <p>Copyright 2018 &copy; All Rights Reserved. Slim Dashboard Template</p>
		        <p>Designed by: <a href="">ThemePixels</a></p>
		      </div><!-- container-fluid -->
		    </div><!-- slim-footer -->
		  </div><!-- slim-mainpanel -->
		</div><!-- slim-body -->
		<!-- jquery js -->
	    <script src="<?= base_url(); ?>assets/lib/jquery/js/jquery.js"></script>
	    <!-- popper js -->
	    <script src="<?= base_url(); ?>assets/lib/popper.js/js/popper.js"></script>
	    <!-- bootstrap js -->
	    <script src="<?= base_url(); ?>assets/lib/bootstrap/js/bootstrap.js"></script>
	    <!-- jquery cookie js -->
	    <script src="<?= base_url(); ?>assets/lib/jquery.cookie/js/jquery.cookie.js"></script>
	    <!-- perfect scrollbar js -->
	    <script src="<?= base_url(); ?>assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
	    <!-- slim js -->
	    <script src="<?= base_url(); ?>assets/js/slim.js"></script>
	    <script>
	    	alert('Hey');
			let base_url = "<?= base_url(); ?>";
			$(function (){
				$('#add-user-roles').on('submit', function (e){
					console.log('hey');
					e.preventDefault();

					var formData = $( this ).serialize();

					$.ajax({
						url  : base_url + "user/role/add",
						data : formData,
						method : 'POST',
						success : function () {

						}
					});
				});
			});
		</script>
        
  </body>
</html>