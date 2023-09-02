<div class="slim-mainpanel">
        <div class="container">
          <div class="slim-pageheader">
            <ol class="breadcrumb slim-breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
            <h6 class="slim-pagetitle">Products</h6>
          </div><!-- slim-pageheader -->
			<div class="section-wrapper">	
				<div class='row'>
					<div class='col-md-8'>
						<h2>Product Listing</h2>
					</div>
					<div class='col-md-4'>
						<form id='search-product-cn-number' >
							<input type='text' name='cn_number' class='form-control' placeholder='Search CN' />
							<button type="submit" class='btn btn-primary btn-block mt-2 search-product'>Search Product</button>
						</form>
					</div>
				</div>
				<div class="table-responsive productList" style="height: 430px;"></div>
				<div class="productPaginationLink"></div>	  
				<!-- end of product table and pagination -->
				<div class="row no-gutters mt-4">
					<div class="col-md-4">
						<button type="button" class="btn btn-primary" href="" data-toggle="modal" data-target="#add-product-modal">Add New Product</button>
					</div>
				</div>
		  
		  </div>

        </div><!-- container -->
		
		<!-- Add Product Type MODAL -->
		<div id="add-product-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Product</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="add-product-form"  enctype="multipart/form-data" >
				  <div class="form-layout">
					 <div class="row">
					     <div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="card bd-0">
                              <div class="card-header tx-medium bd-0 tx-white bg-primary">
                                Sender Information
                              </div>
                            </div>
                         </div>
                      		                        <!-- Shipper Name -->
                        <div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper Name (Required)</label>
							<input class="form-control" type="text" name="shippername"  placeholder="Ex: Mu***** kas****" id="C_NAME">
						  </div>
						</div><!-- col-4 -->
						<!-- Shipper Phone -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper Phone</label>
							<input class="form-control" type="text" name="shipperphone" placeholder="Ex: 0300-*******" id="C_MOBILE">
						  </div>
						</div><!-- col-4 -->
                        
                        <!-- Shipper Email Address -->
						<div class="col-md-4">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Shipper Email Address</label>
							<input class="form-control" type="text" name="shipperEmailAddress" placeholder="mkas***@****.com" id="C_EMAIL">
						  </div>
						</div><!-- col-8 -->
						
						<!-- Shipper Country -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="scWrapper">
						      	<label style="color: #000000de;">Shipper Country (Required)</label>
						      	<select class="form-control countrySearch recieverCountrySearch" id="GetCountry"name="shipperCountryId" data-parsley-class-hanlder="#scWrapper" required>
								  	<option label="Select Country"></option>
								  	<?php foreach( $getCountry as $country) : ?>
									<option value="<?= $country['COUNTRY_ID'] ?>"> <?= $country['COUNTRY']; ?></option>							  		
								  	<?php endforeach; ?>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper State -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="statewrapper">
						      	<label style="color: #000000de; " >Shipper State (Required)</label>
								<select class="form-control stateSearch recieverStateSearch" name="shipperStateId" id="GetState" data-parsley-class-hanlder="#statewrapper" required>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper City -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="cityWrapper">
						      <label style="color: #000000de;">Shipper City (Required)</label>
								<select class="form-control citySearch receiverCitySearch" name="shipperCityId" id="GetCity" data-parsley-class-hanlder="#cityWrapper" required>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper Zip code -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper ZipCode</label>
							<input class="form-control" type="text" name="shipperzipcode" placeholder="Ex: 25000" id="C_CODE">
						  </div>
						</div><!-- col-4 --> 
						<!-- Used for CNIC -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper CNIC</label>
							<input class="form-control" type="text" name="productActualPrice" placeholder="*****-*******-*" id="C_CNIC">
						  </div>
						</div><!-- col-4 -->

						<!-- added by taimur -->
						<div class="col-md-4"> <!-- dropdown-->
						  <div class="form-group">
						      <label style="color: #000000de;">Client List</label>

						        <select name="CLIENT_ID" class="form-control select2 clientSearch" id="select-client" data-placeholder="Select Client">
	                 			 	<option label="Select Client"></option>
							      
							        	<?php foreach( $client AS $clientRecord) :?>
	                    			<option value="<?= $clientRecord['CLIENT_ID'] ?>"><?= $clientRecord['CLIENT_NAME'] ?> - <?= $clientRecord['CLIENT_MOBILE'] ?></option>
                  					<?php endforeach; ?>  
						        </select>
							<!-- <input class="form-control" type="text" name="vatNumber" placeholder=""> -->
						  </div>
						</div>
						<!-- Shipper Address -->
						<div class="col-md-8">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Shipper Address</label>
							<textarea class="form-control" type="text" name="shipperaddress" placeholder="Ex: House No **, Muhallah ******, Street No ****" id="C_ADDRESS"></textarea>
						  </div>
						</div><!-- col-8 -->
						
						
						<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
						
						<div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="card bd-0">
                              <div class="card-header tx-medium bd-0 tx-white bg-danger">
                                Receiver Information
                              </div>
                            </div>
                         </div>
                         
                         <!-- Consignee Name -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Consignee's Name</label>
							<input class="form-control" type="text" name="consigneername" placeholder="Ex: P**** Da***">
						  </div>
						</div><!-- col-4 -->
						<!-- Consignee Phone -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Consignee's Phone</label>
							<input class="form-control" type="text" name="consigneephone" placeholder="Ex: +91* ***** *****">
						  </div>
						</div><!-- col-4 -->
						
						<!-- Consignee Email Address -->
						<div class="col-md-4">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Consignee Email Address</label>
							<input class="form-control" type="text" name="consigneeEmailAddress" placeholder="mka*****@****.com">
						  </div>
						</div><!-- col-8 -->
						
						<!-- Shipper Country -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force  parsley-input" id="ccWrapper">
						      	<label style="color: #000000de;">Consignee Country (Required)</label>
						      	<select class="form-control countrySearch senderCountrySearch" name="consigneeCountryId"  data-parsley-class-hanlder="#ccWrapper" required>
								  	<option label="Select Country"></option>
								  	<?php foreach( $getCountry as $country) : ?>
									<option value="<?= $country['COUNTRY_ID'] ?>"> <?= $country['COUNTRY']; ?></option>							  		
								  	<?php endforeach; ?>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper State -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="cstateWrapper">
						      	<label style="color: #000000de;">Consignee State (Required)</label>
								<select class="form-control stateSearch senderStateSearch" name="consigneeStateId"  data-parsley-class-hanlder="#cstateWrapper" required>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper City -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-select" id="consgcityWrapper">
						      	<label style="color: #000000de;">Consignee City (Required)</label>
								<select class="form-control stateSearch senderCitySearch" name="consigneeCityId"  data-parsley-class-handler="#consgcityWrapper" required>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Consignee Zip code -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Consignee's ZipCode</label>
							<input class="form-control" type="text" name="consigneezipcode" placeholder="Ex: 32500">
						  </div>
						</div><!-- col-4 -->
						
						<!-- Consignee Address -->
						<div class="col-md-8">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Consignee's Address</label>
							<textarea class="form-control" type="text" name="consigneeaddress" placeholder="Ex: House No ***, Street No ****"></textarea>
						  </div>
						</div><!-- col-8 -->
						
						
						<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
						
						
						<div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="card bd-0">
                              <div class="card-header tx-medium bd-0 tx-white bg-purple">
                                Product Information
                              </div>
                            </div>
                         </div>
						
					 	<!-- Product Name -->
					 	<div class="col-md-4">
						  <div class="form-group">
						    <label style="color: #000000de;">Product Name</label>
							<input class="form-control" type="text" name="productname" placeholder="ABCD ****">
						  </div>
						</div><!-- col-4 -->
						<!-- Club Number -->
						<div class="col-md-4">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Club Number</label>
							<input class="form-control" type="text" name="clubNumber" placeholder="W*">
						  </div>
						</div><!-- col-8 -->
						
						<!-- CN Number -->
						<!-- <div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1 parsley-input" id="CNWrapper">
						      <label style="color: #000000de;">Enter CN# (Required)</label>
							<input class="form-control" type="text" name="cn_number" placeholder="Ex: 635***"  data-parsley-class-hanlder="#CNWrapper" required>
						  </div>
						</div> -->
						<!-- col-4 -->
						<!-- Product Weight -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Product Weight</label> <br />
							<input class="form-control" type="text" name="productweight" data-role="tagsinput">
						  </div>
						</div><!-- col-4 -->
						<!-- Product Net Weight -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Product Net Weight</label>
							<input class="form-control" type="text" name="productnetweight" placeholder="25KG">
						  </div>
						</div><!-- col-4 -->
						<!-- Product Dimension -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
						      <label style="color: #000000de;">Product Dimension</label><br />
							<input class="form-control" type="text" name="productdimension" data-role="tagsinput">
						  </div>
						</div><!-- col-4 -->
						<!-- No of pieces -->
						<div class="col-md-4 mg-t--1 mg-md-t-0">
						  <div class="form-group mg-md-l--1">
						      <label style="color: #000000de;">No of Pieces</label>
							<input class="form-control" type="text" name="noofpieces" placeholder="Ex: 8">
						  </div>
						</div><!-- col-4 -->
						<!-- Product Description -->
						<div class="col-md-8">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Description</label>
							<textarea class="form-control" type="text" name="Description" placeholder=""></textarea>
						  </div>
						</div><!-- col-8 -->
						<!-- Product Type Id -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="productType">
						      <label style="color: #000000de;">Product Type (Required)</label>
							<select id="select2-b" name="productType" class="form-control" data-placeholder=""  data-parsley-class-hanlder="#productType" required>
							  <option label="Select"></option>
							<?php 
							foreach ( $productType as $product ) :
							?>
							  <option value="<?= $product['PRODUCT_TYPE_ID'] ?>"><?= $product['PRODUCT_TYPE'] ?></option>
							<?php 
							endforeach;
							?>
							</select>
						  </div>				  
						</div><!-- col-4 -->
						<!-- External Tracking Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">External Tracking No</label>
							<input class="form-control" type="text" name="exttrackingno" placeholder="Ex: 254*****">
						  </div>
						</div><!-- col-4 -->
						<!-- Tracking Status -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="TrackingStatus">
						      <label style="color: #000000de;">Tracking Status (Required)</label>
							<select id="select2-b" name="trackingStatus" class="form-control" data-placeholder=""  data-parsley-class-hanlder="#TrackingStatus" required>
							  <option label="Select"></option>
							  	<?php 
								foreach ( $trackingStatus as $t_status ) :
								?>
								  <option value="<?= $t_status['TRACKING_ID'] ?>"><?= $t_status['TRACKING_CODE'] ?></option>
								<?php 
								endforeach;
								?>
							</select>
						  </div>				  
						</div><!-- col-4 -->
						<!-- Product Condition Id -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="productCondition">
						      <label style="color: #000000de;">Product Condition (Required)</label>
							<select id="select2-b" name="productCondition" class="form-control" data-placeholder=""  data-parsley-class-hanlder="#productCondition" required>
							  <option label="Select"></option>
							  	<?php 
								foreach ( $productCondition as $p_condition ) :
								?>
								  <option value="<?= $p_condition['PRODUCT_CONDITION_ID'] ?>"><?= $p_condition['PRODUCT_CONDITION'] ?></option>
								<?php 
								endforeach;
								?>
							</select>
						  </div>				  
						</div><!-- col-4 -->
						<!-- Product Status Id -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force parsley-input" id="paymentStatus">
						      <label style="color: #000000de;">Payment Status (Required)</label>
							<select id="select2-b" name="productStatus" class="form-control" data-placeholder=""  data-parsley-class-hanlder="#paymentStatus" required>
							  <option label="Select"></option>
							  	<?php 
								foreach ( $productStatus as $p_status ) :
								?>
								  <option value="<?= $p_status['PRODUCT_STATUS_ID'] ?>"><?= $p_status['PRODUCT_STATUS_NAME'] ?></option>
								<?php 
								endforeach;
								?>
							</select>
						  </div>				  
						</div><!-- col-4 -->
						<!-- Recieve Amount -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Received Amount</label>
							<input id="receivedAmountCheck" class="form-control receivedAmountCheck" type="text" name="receivedamount" placeholder="Ex: 32000">
						  </div>
						</div><!-- col-4 -->
						<!-- Balance Amount -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Balance Amount</label>
							<input class="form-control" type="text" name="balanceamount" placeholder="Ex: 25000">
						  </div>
						</div><!-- col-4 -->
						
						<!-- ////////////////////////     NEW FIELDS ADDED     ////////////////////////////////////////////// -->
						<!-- MAB Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">MAB Number</label>
							<input class="form-control" type="text" name="mabNumber" placeholder="">
						  </div>
						</div><!-- col-4 -->
						<!-- Bag Number -->


						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Bag Number</label> <br />
						    <input class="form-control"  type="text" name="bagNumber"  data-role="tagsinput">
						  </div>
						</div><!-- col-4 -->
						
						<!-- Form E -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Form E</label>
							<input class="form-control" type="text" name="formE" placeholder="">
						  </div>
						</div><!-- col-4 -->
						
						<!-- EORI Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">EORI Number</label>
							<input class="form-control" type="text" name="eoriNumber" placeholder="">
						  </div>
						</div><!-- col-4 -->
						
						<!-- VAT Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">VAT Number</label>
							<input class="form-control" type="text" name="vatNumber" placeholder="">
						  </div>
						</div><!-- col-4 -->
						
						
						<!-- Product File -->
						<div class="col-md-12">
						    <label style="color: #000000de;">Upload Pictures</label>
						    <div class="productFile dropzone">
							  <div class="fallback">
							      
							    <input name="file[]" type="file" id="productFile" multiple="multiple" />
							  </div>
							</div><!-- col-4 -->
						</div>
				  	</div><!-- row -->	
				  	<!-- Main row end  -->
					  <div class="form-layout-footer bd pd-20 bd-t-0 mt-3">
						<button type="submit" id="submitBtnCheck" class="btn btn-success bd-0 submitBtn" disabled >Save Product</button>
						<button type="reset" class="btn btn-danger bd-0">Reset</button>
					  </div><!-- form-group -->
					</div>
				</form>
			  </div><!-- modal-body -->			  
			</div>
		  </div><!-- modal-dialog -->
		</div><!--Product Type modal -->

		<!-- Update Product Type MODAL -->
		<div id="update-product-modal" class="modal fade">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content tx-size-sm">
			  <div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Product</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body pd-20">
			  	<form id="update-product-form" enctype="multipart/form-data">
				  <div class="form-layout">
					 <div class="row">
					     <div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="card bd-0">
                              <div class="card-header tx-medium bd-0 tx-white bg-primary">
                                Sender Information
                              </div>
                            </div>
                         </div>
					  	
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper Name</label>
							<input class="form-control" type="text" id="updateShipperName" name="shippername" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper Phone</label>
							<input class="form-control" type="text" id="updateShipperPhone" name="shipperphone" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						<!-- Shipper Email Address -->
						<div class="col-md-4">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Shipper Email Address</label>
							<input class="form-control" type="text" id="updateShipperEmailAddress" name="shipperEmailAddress" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						
						<!-- Shipper Country -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
						      <label style="color: #000000de;">Shipper Country</label>
								<select class="form-control" id="updateShipperCountry" name="shipperCountryId" <?= $disabledopt ?> >
								  	<option label="Select Country"></option>
								  	<?php foreach( $getCountry as $country) : ?>
									<option value="<?= $country['COUNTRY_ID'] ?>"> <?= $country['COUNTRY']; ?></option>							  		
								  	<?php endforeach; ?>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper State -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
						      	<label style="color: #000000de;">Shipper State</label>
								<select class="form-control " id="updateShipperState" name="shipperStateId" <?= $disabledopt ?> >
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Shipper City -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
						      	<label style="color: #000000de;">Shipper City</label>
								<select class="form-control " id="updateShipperCity" name="shipperCityId" <?= $disabledopt ?> >
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Shipper ZipCode</label>
							<input class="form-control" type="text" id="updateShipperZipcode" name="shipperzipcode" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						<!-- Used for CNIC -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">CNIC Shipper</label>
							<input class="form-control" type="text" name="productActualPrice" id="updateProductActualPrice" placeholder="" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->

						<div class="col-md-4"> <!-- dropdown-->
						  <div class="form-group">
						      <label style="color: #000000de;">Client List</label>
						        <select name="CLIENT_ID" class="form-control " data-placeholder="Select Client" id="updateClient" <?= $disabledopt ?>>
	                 			 	<option label="Select Client"></option>
							      
							        	<?php foreach( $client AS $clientRecord) :?>
	                    			<option value="<?= $clientRecord['CLIENT_ID'] ?>"><?= $clientRecord['CLIENT_NAME'] ?> - <?= $clientRecord['CLIENT_MOBILE'] ?></option>
                  					<?php endforeach; ?>  
						        </select>
							<!-- <input class="form-control" type="text" name="vatNumber" placeholder=""> -->
						  </div>
						</div>
						
						<div class="col-md-8">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Shipper Address</label>
							<textarea class="form-control" type="text" id="updateShipperAddress" name="shipperaddress" <?= $disabledopt ?> ></textarea>
						  </div>
						</div><!-- col-8 -->
						
						
					    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
					    
					    <div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="card bd-0">
                              <div class="card-header tx-medium bd-0 tx-white bg-danger">
                                Receiver Information
                              </div>
                            </div>
                         </div>
						
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Consignee's Name</label>
							<input class="form-control" type="text" id="updateConsigneeName" name="consigneername" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Consignee's Phone</label>
							<input class="form-control" type="text" id="updateConsigneePhone" name="consigneephone" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						<!-- Consignee Email Address -->
						<div class="col-md-4">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Consignee Email Address</label>
							<input class="form-control" type="text" id="updateConsigneeEmailAddress" name="consigneeEmailAddress" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						
						<!-- Consignee Country -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
						      <label style="color: #000000de;">Consignee Country</label>
								<select class="form-control" id="updateConsigneeCountry" name="consigneeCountryId" <?= $disabledopt ?> >
								  	<option label="Select Country"></option>
								  	<?php foreach( $getCountry as $country) : ?>
									<option value="<?= $country['COUNTRY_ID'] ?>"> <?= $country['COUNTRY']; ?></option>							  		
								  	<?php endforeach; ?>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Consignee State -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
						      <label style="color: #000000de;">Consignee State</label>
								<select class="form-control" id="updateConsigneeState" name="consigneeStateId" <?= $disabledopt ?> >
								  	<option label="Select State"></option>
								</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<!-- Consignee City -->
						<div class="col-md-4">
						  <div class="form-group mg-md-l--1 bd-t-0-force">
						      <label style="color: #000000de;">Consignee City</label>
								<select class="form-control" id="updateConsigneeCity" name="consigneeCityId" <?= $disabledopt ?> >
								  	<option label="Select City"></option>
							  	</select>
						  </div>				  
						</div><!-- col-4 -->
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Consignee's ZipCode</label>
							<input class="form-control" type="text" id="updateConsigneeZipcode" name="consigneezipcode" <?= $disabledopt ?> >
						  </div>
						</div><!-- col-4 -->
						
						
						<div class="col-md-8">
						  	<div class="form-group bd-t-0-force">
						  	    <label style="color: #000000de;">Consignee's Address</label>
								<textarea class="form-control" type="text" id="updateConsigneeAddress" name="consigneeaddress" <?= $disabledopt ?> ></textarea>
						  	</div>
						</div><!-- col-8 -->
						<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
						
						<div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="card bd-0">
                              <div class="card-header tx-medium bd-0 tx-white bg-purple">
                                Product Information
                              </div>
                            </div>
                         </div>
						
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Product Name</label>
							<input class="form-control" type="text" id="updateProductName" name="productname"  <?= $disabledopt ?>  >
						  </div>
						</div><!-- col-4 -->
						<!-- Club Number -->
						<div class="col-md-4">
						  <div class="form-group bd-t-0-force">
						      <label style="color: #000000de;">Club Number</label>
							<input class="form-control" type="text" id="updateClubNumber" name="clubNumber"  <?= $disabledopt ?>  >
						  </div>
						 </div><!-- col-4 -->
						  
						
						
					<!-- CN Number -->
					<!-- <div class="col-md-4 mg-t--1 mg-md-t-0">
					  <div class="form-group mg-md-l--1">
					      <label style="color: #000000de;">Enter CN#</label>
						<input class="form-control" type="text" id="updateCNNumber" name="cn_number">
					  </div>
					</div> -->
					<!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group">
					      <label style="color: #000000de;">Product Weight</label> <br />
						<input class="form-control" type="text" id="updateProductWeight" name="productweight" data-role="tagsinput">
					  </div>
					</div><!-- col-4 -->
					<!-- Product Net Weight -->
					<div class="col-md-4">
					  <div class="form-group">
					      <label style="color: #000000de;">Product Net Weight</label>
						<input class="form-control" type="text" id="updateProductNetWeight" name="productNetWeight">
					  </div>
					</div><!-- col-4 -->
					<div class="col-md-4 mg-t--1 mg-md-t-0">
					  <div class="form-group mg-md-l--1">
					      <label style="color: #000000de;">Product Dimension</label> <br />
						<input class="form-control" type="text" id="updateProductDimension" name="productdimension" data-role="tagsinput">
					  </div>
					</div><!-- col-4 -->
					<div class="col-md-4 mg-t--1 mg-md-t-0">
					  <div class="form-group mg-md-l--1">
					      <label style="color: #000000de;">No of Pieces</label>
						<input class="form-control" type="number" id="updateNoOfPieces" name="noofpieces">
					  </div>
					</div><!-- col-4 -->
					
					<div class="col-md-8">
					  <div class="form-group bd-t-0-force">
					      <label style="color: #000000de;">Description</label>
						<textarea class="form-control" type="text" id="updateDescription" name="Description" ></textarea>
					  </div>
					</div><!-- col-8 -->
					<div class="col-md-4">
					  <div class="form-group mg-md-l--1 bd-t-0-force">
					      <label style="color: #000000de;">Product Type</label>
						<select id="updateProductType" name="productType" class="form-control"  <?= $disabledopt ?>  >
						  <option label="Product Type"></option>
						<?php 
						foreach ( $productType as $product ) :
						?>
						  <option value="<?= $product['PRODUCT_TYPE_ID'] ?>"><?= $product['PRODUCT_TYPE'] ?></option>
						<?php 
						endforeach;
						?>
						</select>
					  </div>				  
					</div><!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group">
					      <label style="color: #000000de;">External Tracking No</label>
						<input class="form-control" type="text" id="updateExtTrackingno" name="exttrackingno"  <?= $disabledopt ?>  >
					  </div>
					</div><!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group mg-md-l--1 bd-t-0-force">
					      <label style="color: #000000de;">Tracking Status</label>
						<select id="updateTrackingStatus" name="trackingStatus" class="form-control">
						  <option label="Tracking Status"></option>
						  	<?php 
							foreach ( $trackingStatus as $t_status ) :
							?>
							  <option value="<?= $t_status['TRACKING_ID'] ?>"><?= $t_status['TRACKING_CODE'] ?></option>
							<?php 
							endforeach;
							?>
						</select>
					  </div>				  
					</div><!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group mg-md-l--1 bd-t-0-force">
					      <label style="color: #000000de;">Product Condition</label>
						<select id="updateProductCondition" name="productCondition" class="form-control" <?= $disabledopt ?>  >
						  <option label="Product Condition"></option>
						  	<?php 
							foreach ( $productCondition as $p_condition ) :
							?>
							  <option value="<?= $p_condition['PRODUCT_CONDITION_ID'] ?>"><?= $p_condition['PRODUCT_CONDITION'] ?></option>
							<?php 
							endforeach;
							?>
						</select>
					  </div>				  
					</div><!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group mg-md-l--1 bd-t-0-force">
					      <label style="color: #000000de;">Payment Status</label>
						<select id="updateProductStatus" name="productStatus" class="form-control" <?= $disabledopt ?> >
						  <option label="Product Status"></option>
						  	<?php 
							foreach ( $productStatus as $p_status ) :
							?>
							  <option value="<?= $p_status['PRODUCT_STATUS_ID'] ?>"><?= $p_status['PRODUCT_STATUS_NAME'] ?></option>
							<?php 
							endforeach;
							?>
						</select>
					  </div>				  
					</div><!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group">
					      <label style="color: #000000de;">Received Amount</label>
						<input class="form-control" type="text" id="updateRecieveAmount" name="receivedamount" <?= $disabledopt ?> >
					  </div>
					</div><!-- col-4 -->
					<div class="col-md-4">
					  <div class="form-group">
					      <label style="color: #000000de;">Balance Amount</label>
						<input class="form-control" type="text" id="updateBalanceAmount" name="balanceamount" <?= $disabledopt ?> >
					  </div>
					</div><!-- col-4 -->
					<!-- ////////////////////////     NEW FIELDS ADDED     ////////////////////////////////////////////// -->
						<!-- MAB Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">MAB Number</label>
							<input class="form-control" type="text" name="mabNumber" id="updateMabNumber" placeholder="">
						  </div>
						</div><!-- col-4 -->
						<!-- Bag Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Bag Number</label> <br />
							    <input type="text" id="updateBagNumber" name="bagNumber" data-role="tagsinput">
						  </div>
						</div><!-- col-4 -->
						
						<!-- Form E -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">Form E</label>
							<input class="form-control" type="text" name="formE" id="updateFormE" placeholder="">
						  </div>
						</div><!-- col-4 -->
						
						<!-- EORI Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">EORI Number</label>
							<input class="form-control" type="text" name="eoriNumber" id="updateEoriNumber" placeholder="">
						  </div>
						</div><!-- col-4 -->
						
						<!-- VAT Number -->
						<div class="col-md-4">
						  <div class="form-group">
						      <label style="color: #000000de;">VAT Number</label>
							<input class="form-control" type="text" name="vatNumber" id="updateVatNumber" placeholder="">
						  </div>
						</div><!-- col-4 -->
						
						
					<!-- Product File -->
					<div class="col-md-12">
					    <label style="color: #000000de;">Upload Pictures</label>
					    <div class="updateProductFile dropzone">
						  <div class="fallback">
						    <input name="updateFile[]" type="file" id="productFile" multiple="multiple" />
						  </div>
						</div><!-- col-4 -->
					</div>
					<!-- Product File -->
					<div class="col-md-4">
					  <div class="form-group">
						<input type="hidden" class="updateProductId" id="updateProductId" name="productId" >
						<input type="hidden" name="cn_number" id="updateCNNumber">
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
		
		
		<script>
		
		document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('receivedAmountCheck');
            var button = document.getElementById('submitBtnCheck'); // Replace 'yourButtonId' with the actual ID of your button
            
            input.addEventListener('keyup', function() {
                var amount = parseFloat(input.value);
                
                if (amount > 0) {
                    button.disabled = false; // Enable the button
                } else {
                    button.disabled = true; // Disable the button
                }
            });
        });
		    
		</script>