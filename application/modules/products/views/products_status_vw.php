<div class="slim-mainpanel">
    <div class="container">
      	<div class="slim-pageheader">
		<ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item"><a href="./welcome">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page"><?= $headerData['pageName'] ?></li>
		</ol>
        <h6 class="slim-pagetitle"><?= $headerData['pageName'] ?></h6>
      	</div><!-- slim-pageheader -->
		<div class="section-wrapper">	
			<div class="table-responsive productStatusList"></div>
			<div class="productStatusPaginationLink"></div>	  
			<!-- end of product table and pagination -->
			<div class="row no-gutters">
				<div class="col-md-4">
					<button type="button" class="btn btn-success" href="" data-toggle="modal" data-target="#add-product-status-modal">Add New Product Status</button>
				</div>
			</div>
	  	</div>
    </div><!-- container -->

    <!-- Add Product Status MODAL -->
	<div id="add-product-status-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add <?= $headerData['pageName'] ?></h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
		  	<form id="add-product-status-form">
			  <div class="form-layout">
				 <div class="row">
				 	<!-- Product Status Name -->
				 	<div class="col-md-12">
					  <div class="form-group">
						<input class="form-control" type="text" name="productStatusName"  placeholder="Product Status Name" required="required">
					  </div>
					</div><!-- col-4 -->
			  	</div><!-- row -->	
			  	<!-- Main row end  -->
				  <div class="form-layout-footer bd pd-20 bd-t-0">
					<button type="submit" class="btn btn-success bd-0 submitBtn">Save <?= $headerData['pageName'] ?></button>
					<button type="reset" class="btn btn-danger bd-0">Reset</button>
				  </div><!-- form-group -->
				</div>
			</form>
		  </div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--Product Status modal -->

	<!-- Update Product Status MODAL -->
	<div id="update-product-status-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Update <?= $headerData['pageName'] ?></h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
		  	<form id="update-product-status-form">
			  <div class="form-layout">
				 <div class="row">
				 	<!-- Product Status Name -->
				 	<div class="col-md-12">
					  <div class="form-group">
						<input class="form-control updateStatusName" type="text" name="productStatusName"  placeholder="Product Status Name" required="required">
					  </div>
					</div><!-- col-4 -->
					<!-- Product Status Id -->
					<div class="col-md-4">
					  <div class="form-group">
						<input type="hidden" name="productStatusId" class="updateProductStatusId">
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
