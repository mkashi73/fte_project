<div class="slim-mainpanel">
	<div class="container">
		<div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item"><a href="#">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Blank Page</li>
			</ol>
			<h6 class="slim-pagetitle">Update Product Stages</h6>
		</div><!-- slim-pageheader -->
		<div class="section-wrapper">	
			<form id="product-multiple-form">
				<div class="row no-gutters">
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="CNNumber" class="form-control" placeholder="Search CN">
						</div><!-- form-group -->

						<button type="submit" class="btn btn-success btn-block search-product-multiple-btn">Search Product</button>
					</div>
				  	<div class="offset-md-2 col col-md-4 search-product-multiple-data">
				  	</div>
				</div>
			</form>
			<hr>
			<div class="product-multiple-listing"></div>
			<form id="add-multiple-form">
				<div class="boxes-parent">
					<div class="boxes">
						<ul class="list-group">
						  <li class="list-group-item">
							  <div class="row">
								<div class="col-md-4">
									<label style="color: black">Product Name</label><br />
									<input type="text" name="productName[]" class="form-control" >
								</div>
								<div class="col-md-4">
									<label style="color: black">No of Pieces</label><br />
									<input type="text" name="productNoOfPieces[]" class="form-control" >
								</div>
								<div class="col-md-4">
									<label style="color: black">Price (Single Piece)</label><br />
									<input type="text" name="productPricePerPiece[]" class="form-control" >
								</div>
							  </div>
							</li>
						</ul>
						<br />
					</div>
				</div>
				<input type="hidden" name="getCNNumber" class="updateCNNumber">
				<div class="col-md-6">
					<div class="row">
						<button class="btn btn-success mt-3 mb-3 mr-3" id="addbutton">Add Product</button>
						<button class="btn btn-danger mt-3 mb-3 mr-3 del">Remove Product</button>
					</div>
					<div class="row">
						<button type="submit" class="btn btn-success add-product-btn">Save Product</button>
					</div>
				</div>
			</form>
		</div>
	</div><!-- container -->
	<!-- Product Type MODAL -->
		<div id="modaleditmultipleproducts" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Multiple Products</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-product-multiple-form">
				  	<div class="form-layout">
						<div class="row">
						  	<div class="col-md-4">
							  <div class="form-group">
								<input class="form-control updateProductName" type="text" name="productname" placeholder="Product Name">
							  </div>
							</div><!-- col-4 -->
							<div class="col-md-4">
							  <div class="form-group">
								<input class="form-control updateProductQuantity" type="text" name="noofpieces" placeholder="No of Pieces">
							  </div>
							</div><!-- col-4 -->
							
							<div class="col-md-4">
							  <div class="form-group">
								<input class="form-control productUnitPrice" type="text" name="unitprice" placeholder="Unit Price">
							  </div>
							</div><!-- col-4 -->
					  	</div><!-- row -->	
					  	<input type="hidden" name="productMultipleId" class="updateProductMultipleId">
				  		<div class="form-layout-footer bd pd-20 bd-t-0">
							<button type="submit" class="btn btn-success bd-0">Update Product</button>
							<button class="btn btn-danger bd-0" data-dismiss='modal'>Close</button>
					  	</div><!-- form-group -->
					</div>
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!--Product Type modal -->