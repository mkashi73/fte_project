		  <div class="section-wrapper">
			<div class="table-responsive userList"></div>
			<div class="userPaginationLink"></div>	
			<div class="row no-gutters">
				<div class="col-md-4">
					<button type="button" class="btn btn-success" href="" data-toggle="modal" data-target="#add-user">Add New User</button>
				</div>
			</div>
		  </div>
		  
        </div><!-- container -->
		<!-- LARGE MODAL -->
		<div id="add-user" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add User Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="add-user-form" method="post">
					<div class="form-layout form-layout-3">
					  <div class="row no-gutters">
						<div class="col-md-4">
						  <div class="form-group">
							<input class="form-control" type="text" name="full_name" placeholder="Enter Full Name" required="required">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
							<input class="form-control updatePassword" type="password" name="password" placeholder="Enter Password" required="required">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
							<input class="form-control updateRetypePassword" type="password" name="re_type_pwd" placeholder="Retype Password" required="required">
							<span id="confirmMessage" class="confirmMessage"></span>
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
							<input class="form-control email" type="email" name="email" placeholder="Email" required="required">
							<span class="success-notification status"></span>
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
							<select name="role"  class="form-control" data-placeholder="Select Role" required="required">
							  <option label="Select Role"></option>
							  <?php 
							  foreach ( $usersRole as $role) :
							  ?>
							  	<option value="<?= $role['USER_ROLE_ID'] ?>"><?= $role['ROLE'] ?></option>
							  <?php
							  endforeach;
							  ?>
							</select>
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
							<select class="form-control" name="status" data-placeholder="Select Status" required="required">
							  <option label="Choose Select Status"></option>
							  <option value="1">Active</option>
							  <option value="0">InActive</option>
							</select>
						  </div>
						</div>
					  </div><!-- row -->
					  <div class="form-layout-footer bd pd-20 bd-t-0">
						<button class="btn btn-primary bd-0">Submit</button>
						<button class="btn btn-secondary bd-0" data-dismiss="modal" >Cancel</button>
					  </div><!-- form-group -->
					</div><!-- form-layout -->
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!-- modal -->
		<div id="update-user-roles" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit User Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-user-form" method="post">
					<div class="form-layout form-layout-3">
					  <div class="row no-gutters">
						<div class="col-md-4">
						  <div class="form-group">
							<input class="form-control" type="text" name="full_name" id="updateFullName" placeholder="Enter Full Name" required="required">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
							<input class="form-control updatePassword" type="password" id="updatePassword"  name="password" placeholder="Enter Password" required="required">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
							<input class="form-control updateRetypePassword" type="password" name="re_type_pwd" id="updateRetypePassword" placeholder="Retype Password" required="required">
							<span class="success-notification status"></span>
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
							<input class="form-control" type="email" id="updateEmail" name="email" placeholder="Email" required="required">
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
							<select name="role" id="updateRole" class="form-control" data-placeholder="Select Role" required="required">
							  <option label="Select Role"></option>
							  <?php 
							  foreach ( $usersRole as $role) :
							  ?>
							  	<option value="<?= $role['USER_ROLE_ID'] ?>"><?= $role['ROLE'] ?></option>
							  <?php
							  endforeach;
							  ?>
							</select>
						  </div>
						</div><!-- col-4 -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
							<select id="updateStatus" class="form-control" name="status" data-placeholder="Select Status" required="required">
							  <option label="Choose Select Status"></option>
							  <option value="1">Active</option>
							  <option value="0">In Active</option>
							</select>
						  </div>
						</div>
						<input type="hidden" name="user_id" id="updateUserId" value="">
					  </div><!-- row -->
					  <div class="form-layout-footer bd pd-20 bd-t-0">
						<button class="btn btn-success bd-0">Update</button>
						<button class="btn btn-danger bd-0" data-dismiss="modal" >Cancel</button>
					  </div><!-- form-group -->
					</div><!-- form-layout -->
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!-- modal -->

