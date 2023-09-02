<div class="slim-mainpanel">
        <div class="container">
          <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
            </ol>
            <h6 class="slim-pagetitle">Add Menu</h6>
          </div><!-- slim-pageheader -->
		  	<form id="add-menu-form">
			  	<div class="section-wrapper">
	            	<label class="section-title">Mega Menu</label>
		            <div class="row">
		              	<div class="col-lg-4">
			                <div class="form-group">
								<input class="form-control" type="text" name="menuText" placeholder="Menu Name">
							</div>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
			                <div class="form-group">
								<input class="form-control" type="text" name="menuLink" placeholder="Menu Link">
							</div>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
							<div class="btn-group">
			                    <div class="form-group">                        
			                        <input class="form-control icp icp-auto" name="menuIcon" value="fas fa-anchor" type="text"/>
			                    </div>
							</div>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
						<select class="form-control" name="menuParent">
							<option value="NULL"><-- Select Parent Menu --></option>
							<?php 
							foreach ( $parentMenu as $p_menu ) :
							?>
								<option value="<?= $p_menu['MENU_ID'] ?>"><?= $p_menu['MENU_TEXT'] ?></option>
							<?php
							endforeach;
							?>
						</select>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4">
							<select class="role" name="menuRole[]" multiple="multiple">
								<?php 
								foreach ( $userRoles as $u_role ) :
								?>
									<option value="<?= $u_role['USER_ROLE_ID'] ?>"><?= $u_role['ROLE'] ?></option>
								<?php
								endforeach;
								?>
							</select>
		              	</div><!-- col-4 -->
		            </div><!-- row -->

		            <div class="row mg-t-20">
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
		                	<button type="submit" id="addMenuBtn" class="btn btn-success btn-block mg-b-10">Add Menu</button>
		              	</div><!-- col-4 -->
		            </div><!-- row -->
	          	</div><!-- section-wrapper -->
		  	</form>
		  <div class="section-wrapper">
		  	<div class="table-responsive" id="MenuList"></div>
			<div id="pagination-link"></div>
		  </div>

		  <div id="update-menu-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Menu Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-menu-form" method="post">
					<div class="form-layout form-layout-3">
					  <div class="row no-gutters">
						<div class="col-lg-4">
			                <div class="form-group">
								<input class="form-control updateMenuName" type="text" name="menuText" placeholder="Menu Name">
							</div>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
			                <div class="form-group">
								<input class="form-control updateMenuLink" type="text" name="menuLink" placeholder="Menu Link">
							</div>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
							<div class="btn-group">
			                    <div class="form-group">                        
			                        <input class="form-control icp icp-auto updateMenuIcon" name="menuIcon" value="fas fa-anchor" type="text"/>
			                    </div>
							</div>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4 mg-t-20 mg-lg-t-0">
						<select class="form-control updateMenuParent" name="menuParent">
							<option value="NULL"><-- Select Parent Menu --></option>
							<?php 
							foreach ( $parentMenu as $p_menu ) :
							?>
								<option value="<?= $p_menu['MENU_ID'] ?>"><?= $p_menu['MENU_TEXT'] ?></option>
							<?php
							endforeach;
							?>
						</select>
		              	</div><!-- col-4 -->
		              	<div class="col-lg-4">
							<select class="role udpateMenuRole" name="menuRole[]" multiple="multiple">
								<?php 
								foreach ( $userRoles as $u_role ) :
								?>
									<option value="<?= $u_role['USER_ROLE_ID'] ?>"><?= $u_role['ROLE'] ?></option>
								<?php
								endforeach;
								?>
							</select>
		              	</div><!-- col-4 -->
						<input type="hidden" class="updateMenuId" name="menuId">
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
