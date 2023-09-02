		  <div class="section-wrapper">
			<div class="table-responsive userRolesList"></div>
			<div class="userRolesPaginationLink"></div>	
			<div class="row no-gutters">
				<div class="col-md-4">
					<button type="button" class="btn btn-success" href="" data-toggle="modal" data-target="#add-roles">Add Roles</button>
				</div>
			</div>
		  </div>
		  
        </div><!-- container -->
		<!-- LARGE MODAL -->
		<div id="add-roles" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="add-user-roles-form" method="post">
					<div class="form-layout form-layout-3">
					  <div class="row no-gutters">
						<div class="col-md-6">
						  <div class="form-group">
							<input class="form-control" type="text" id="add-role" name="role" placeholder="Enter Role" required="required">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-6">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
							<select id="add-status" class="form-control" name="active_flag" data-placeholder="Select Status" required="required">
							  <option label="Choose Select Status"></option>
							  <option value="Y">Active</option>
							  <option value="N">InActive</option>
							</select>
						  </div>
						</div>
					  </div><!-- row -->
					  <div class="form-layout-footer bd pd-20 bd-t-0">
						<button class="btn btn-success bd-0">Submit</button>
						<button class="btn btn-danger bd-0" data-dismiss="modal" >Cancel</button>
					  </div><!-- form-group -->
					</div><!-- form-layout -->
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!-- modal -->

		<div id="update-roles" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-user-roles-form" method="post">
					<div class="form-layout form-layout-3">
					  <div class="row no-gutters">
						<div class="col-md-6">
						  <div class="form-group">
							<input class="form-control" type="text" id="updateRole" name="role" placeholder="Enter Role">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-6">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
							<select class="form-control" id="updateActiveFlag" name="active_flag" data-placeholder="Select Status">
							  <option label="Choose Select Status"></option>
							  <option value="Y">Active</option>
							  <option value="N">InActive</option>
							</select>
						  </div>
						</div>
					  </div><!-- row -->
					  <input type="hidden" name="userRoleId" id="userRoleId">
					  <div class="form-layout-footer bd pd-20 bd-t-0">
						<button class="btn btn-success bd-0">Submit</button>
						<button class="btn btn-danger bd-0" data-dismiss="modal" >Cancel</button>
					  </div><!-- form-group -->
					</div><!-- form-layout -->
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!-- modal -->
