<div class="slim-mainpanel">
        <div class="container">
          <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Expense Sheet</li>
            </ol>
            <h6 class="slim-pagetitle">Expense</h6>
          </div><!-- slim-pageheader -->
			<div class="section-wrapper">	
				<div class='row'>
					<div class='col-md-8'>
						<h2>Expense Listing</h2>
					</div>
					<div class='col-md-4'>
						<form id='search-expense-by-id' >
							<input type='text' name='expense_id' class='form-control' placeholder='Search Expense' />
							<button type="submit" class='btn btn-primary btn-block mt-2 search-expense'>Search Expense</button>
						</form>
					</div>
				</div>
				<div class="table-responsive expenseList" style="height: 430px;"></div>
				<div class="expensePaginationLink"></div>	  
				<!-- end of product table and pagination -->
				<div class="row no-gutters mt-4">
					<div class="col-md-4">
						<button type="button" class="btn btn-primary" href="" data-toggle="modal" data-target="#add-expense-modal">Add New Expense</button>
					</div>
				</div>
		  
		  </div>

        </div><!-- container -->
		
		<!-- Add Product Type MODAL -->
		<div id="add-expense-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Expense</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="add-expense-form"  enctype="multipart/form-data" >
					<div class="form-layout">
					  <div class="form-layout-footer bd pd-20 bd-t-0 mt-3">
						<div class="row">
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="card bd-0">
								<div class="card-header tx-medium bd-0 tx-white bg-primary">
									Expense Information
								</div>
								</div>
							</div>
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Expense Amount</label>
									<input class="form-control" type="text" name="expenseAmount" placeholder="Expense Amount" required>
								</div>
							</div><!-- col-4 -->

							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Expense Detail</label>
									<input class="form-control" type="text" name="expenseDetail" placeholder="Expense Detail" required>
								</div>
							</div><!-- col-4 -->
							
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Expense Type</label>
									<select id="select2-b" name="expenseType" class="form-control" data-placeholder="Expense Type" required>
										<option label="Select"></option>
										<option value="Deter Leadger ">Deter Leadger </option>
										<option value="DP">DP</option>
										<option value="Food">Food</option>
										<option value="Office Expense">Office Expense</option>
										<option value="Online">Online</option>
										<option value="Packing Material">Packing Material</option>
										<option value="Utility Bills">Utility Bills</option>
										<option value="Claim">Claim</option>
										<option value="Salary">Salary</option>
										<option value="Fuel">Fuel</option>
									</select>
								</div>
							</div><!-- col-4 -->
						</div><!-- row -->

						<button type="submit" id="submitBtnCheck" class="btn btn-success bd-0 submitBtn add-expense-btn" >Save Expense</button>
						<button type="reset" class="btn btn-danger bd-0">Reset</button>
					  </div><!-- form-group -->
					</div>
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!--Product Type modal -->

		<!-- Update Product Type MODAL -->
		<div id="update-expense-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Expense</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-expense-form" enctype="multipart/form-data">
				  	<div class="form-layout">
					  	<div class="row">
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="card bd-0">
								<div class="card-header tx-medium bd-0 tx-white bg-primary">
									Expense Information
								</div>
								</div>
							</div>
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Expense Amount</label>
									<input class="form-control updateExpenseAmount" type="text" name="expenseAmount" placeholder="Received From" required>
								</div>
							</div><!-- col-4 -->

							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Expense Detail</label>
									<input class="form-control updateExpenseDetail" type="text" name="expenseDetail" placeholder="Expense Detail" required>
								</div>
							</div><!-- col-4 -->
							
							<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								<div class="form-group">
									<label style="color: #000000de;">Expense Type</label>
									<select id="select2-b" name="expenseType" class="form-control updateExpenseType" data-placeholder="Expense Type" required>
										<option label="Select"></option>
										<option value="Deter Leadger ">Deter Leadger </option>
										<option value="DP">DP</option>
										<option value="Food">Food</option>
										<option value="Office Expense">Office Expense</option>
										<option value="Online">Online</option>
										<option value="Packing Material">Packing Material</option>
										<option value="Utility Bills">Utility Bills</option>
										<option value="Claim">Claim</option>
										<option value="Salary">Salary</option>
										<option value="Fuel">Fuel</option>
										<option value="UK Payment">UK Payment</option>
										<option value="USA Payment">USA Payment</option>
										<option value="Creditor">Creditor</option>
									</select>
								</div>
							</div><!-- col-4 -->

							
							<div class="col-md-4">
								<div class="form-group">
									<input type="hidden" name="expenseId" class="updateexpenseId">
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
		