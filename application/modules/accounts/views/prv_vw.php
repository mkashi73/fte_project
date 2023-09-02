<div class="slim-mainpanel">
        <div class="container">
          <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Payment Receipt Voucher</li>
            </ol>
            <h6 class="slim-pagetitle">PRV</h6>
          </div><!-- slim-pageheader -->
			<div class="section-wrapper">	
				<div class='row'>
					<div class='col-md-8'>
						<h2>PRV Listing</h2>
					</div>
					<div class='col-md-4'>
						<form id='search-prv-by-id' >
							<input type='text' name='prv_id' class='form-control' placeholder='Search Prv' />
							<button type="submit" class='btn btn-primary btn-block mt-2 search-prv'>Search PRV</button>
						</form>
					</div>
				</div>
				<div class="table-responsive prvList" style="height: 430px;"></div>
				<div class="prvPaginationLink"></div>	  
				<!-- end of product table and pagination -->
				<div class="row no-gutters mt-4">
					<div class="col-md-4">
						<button type="button" class="btn btn-primary" href="" data-toggle="modal" data-target="#add-prv-modal">Add New PRV</button>
					</div>
				</div>
		  
		  </div>

        </div><!-- container -->
		
		<!-- Add Product Type MODAL -->
		<div id="add-prv-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add PRV</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="add-prv-form"  enctype="multipart/form-data" >
					<div class="form-layout">
					  <div class="form-layout-footer bd pd-20 bd-t-0 mt-3">
						<div class="row">
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="card bd-0">
								<div class="card-header tx-medium bd-0 tx-white bg-primary">
									PRV Information
								</div>
								</div>
							</div>
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Received From</label>
									<input class="form-control" type="text" name="receivedFrom" placeholder="Received From" required>
								</div>
							</div><!-- col-4 -->
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Received Amount</label>									
									<input class="form-control" type="text" name="receivedAmount" placeholder="Received Amount" required>
								</div>
							</div><!-- col-4 -->
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">PRV Type</label>
									<select id="select2-b" name="prvType" class="form-control" data-placeholder="PRV Type" required>
										<option label="Select"></option>
										<option value="CN">CN</option>
										<option value="Ledger">Ledger</option>
									</select>
								</div>
							</div><!-- col-4 -->
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Account Of</label>
									<input class="form-control" type="text" name="accountOf" placeholder="Account Of" required>
								</div>
							</div><!-- col-4 -->
						</div><!-- row -->

						<button type="submit" id="submitBtnCheck" class="btn btn-success bd-0 submitBtn add-prv-btn" >Save PRV</button>
						<button type="reset" class="btn btn-danger bd-0">Reset</button>
					  </div><!-- form-group -->
					</div>
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!--Product Type modal -->

		<!-- Update Product Type MODAL -->
		<div id="update-prv-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit PRV</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-prv-form" enctype="multipart/form-data">
				  	<div class="form-layout">
					  	<div class="row">
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="card bd-0">
								<div class="card-header tx-medium bd-0 tx-white bg-primary">
									PRV Information
								</div>
								</div>
							</div>
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Received From</label>
									<input class="form-control updateReceivedFrom" type="text" name="receivedFrom" placeholder="Received From">
								</div>
							</div><!-- col-4 -->
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Received Amount</label>									
									<input class="form-control updateReceivedAmount" type="text" name="receivedAmount" placeholder="Received Amount">
								</div>
							</div><!-- col-4 -->
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">PRV Type</label>
									<select id="select2-b" name="prvType" class="form-control updatePrvType" data-placeholder="PRV Type" required>
										<option label="Select"></option>
										<option value="CN">CN</option>
										<option value="Ledger">Ledger</option>
									</select>
								</div>
							</div><!-- col-4 -->
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Account Of</label>
									<input class="form-control updateAccountOf" type="text" name="accountOf" placeholder="Account Of">
								</div>
							</div><!-- col-4 -->
							<div class="col-md-4">
								<div class="form-group">
									<input type="hidden" name="prvId" class="updatePrvId">
								</div>
								</div><!-- col-4 -->
						</div><!-- row -->
						<div class="form-layout-footer bd pd-20 bd-t-0">
							<button type="submit" class="btn btn-success update-product-btn bd-0" >Update</button>
							<button class="btn btn-danger bd-0 cancel-btn">Cancel</button>
						</div><!-- form-group -->
					</div>
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!--Product Type modal -->
		