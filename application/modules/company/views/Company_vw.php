<div class="slim-mainpanel">
    <div class="container">
		<div class="slim-pageheader">
	        <ol class="breadcrumb slim-breadcrumb">
	          <li class="breadcrumb-item"><a href="#"><?= $headerData['pageName'] ?></a></li>
	          <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
	        </ol>
	        <h6 class="slim-pagetitle"><?= $headerData['pageName'] ?></h6>
		</div><!-- pageheader -->
	  
		<div class="section-wrapper">
	        <label class="section-title">Company Detail</label>
	        <form id="add-company-form" method="POST">
		        <div class="row">
		          	<div class="col-lg-6">
		            	<div class="form-group">
							<input class="form-control" type="text" name="companyName" placeholder="Company Name">
						</div>
		          	</div><!-- col-4 -->
		          	<div class="col-lg-6 mg-t-20 mg-lg-t-0">
		            	<div class="form-group">
							<input class="form-control" type="text" name="companyWebURL" placeholder="Website Link">
						</div>
		          	</div><!-- col-4 -->
		        </div><!-- row -->
		        <div class="row">
		        	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
		            	<button type="submit" class="btn btn-success add-company-btn mg-b-10">
		            		<i class="fas fa-pencil-alt"></i> Add <?= $headerData['pageName'] ?>
	            		</button>
		          	</div><!-- col-4 -->
		          	<div class="col-lg-4 mg-t-20 mg-lg-t-0"></div>
		          	<div class="col-lg-4 mg-t-20 mg-lg-t-0"></div>
		        </div><!-- row -->
	        </form> <!-- Add Company Form -->
	  	</div><!-- section-wrapper -->

	  	<!-- Company Table -->
		<div class="section-wrapper">		  
            <div class="table-responsive companyList"></div>
			<div class="companyPaginationLink"></div>
      	</div> <!-- end section wrapper -->
    </div><!-- container -->

    <!-- Update Company MODAL -->
	<div id="update-company-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update <?= $headerData['pageName'] ?></h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
		  	<form id="update-company-form">
			  <div class="form-layout">
				 <div class="row">
				 	<!-- Company Name -->
				 	<div class="col-md-12">
					  <div class="form-group">
						<input class="form-control updateCompanyName" type="text" name="companyName"  placeholder="Company Name" required="required">
					  </div>
					</div><!-- col-4 -->
					<div class="col-md-12">
					  <div class="form-group">
						<input class="form-control updateCompanyWebUrl" type="text" name="companyWebUrl"  placeholder="Company Web URL" required="required">
					  </div>
					</div><!-- col-4 -->
					<!-- Company Id -->
					<div class="col-md-4">
					  <div class="form-group">
						<input type="hidden" name="companyId" class="updateCompanyId">
					  </div>
					</div><!-- col-4 -->
			  	</div><!-- row -->	
			  	<!-- Main row end  -->
				  <div class="form-layout-footer bd pd-20 bd-t-0">
					<button type="submit" class="btn btn-success bd-0 submitBtn">Update <?= $headerData['pageName'] ?></button>
					<button type="reset" class="btn btn-danger bd-0">Reset</button>
				  </div><!-- form-group -->
				</div>
			</form>
		  </div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--Product Status modal -->
