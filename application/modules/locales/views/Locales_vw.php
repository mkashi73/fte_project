<div class="slim-mainpanel">
    <div class="container">
      <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">country-state-city</li>
        </ol>
        <h6 class="slim-pagetitle">Enter Country/State/City</h6>
      </div><!-- slim-pageheader -->
	  <!-- Country listing AJAX -->
	  <!------------------------------------------- COUNTRY LISTING ----------------------------------->
	  <div class="section-wrapper">
	  	<div class='row'>
	  		<div class="col-md-8">
	  			<h2>Country Listing</h2>
	  		</div>
			<div class='col-md-4 mb-4'>
				<form id='search-country-form'>
					<input type='text' name='countryName' id="searchCountryName" class='form-control' onkeyup="this.value = this.value.toUpperCase();" placeholder='Search Country Name' />
					<button type="submit" class='btn btn-success btn-block mt-2 search-btn'>Search Country</button>
				</form>
			</div>
		</div>
	  	<div class="table-responsive CountryList"></div>
		<div class="countryPaginationLink"></div>
		<div class="row no-gutters mt-3">
			<div class="col-md-4">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-country-modal">Add Country</button>
			</div>
		</div>
	  </div>
	  <br />

	  <!------------------------------------------- STATE LISTING ----------------------------------->
	  <div class="section-wrapper">
		<div class='row'>
	  		<div class="col-md-8">
	  			<h2>State Listing</h2>
	  		</div>
			<div class='col-md-4 mb-4'>
				<form id='search-state-form'>
					<input onkeyup="this.value = this.value.toUpperCase();" type='text' name='stateName' id="searchStateName" class='form-control' placeholder='Search State Name' />
					<button type="submit" class='btn btn-success btn-block mt-2 search-state-btn'>Search State</button>
				</form>
			</div>
		</div>
	  	<div class="table-responsive StateList"></div>
		<div class="StatePaginationLink"></div>
		<div class="row no-gutters mt-3">
			<div class="col-md-4">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-state-modal">Add State</button>
			</div>
		</div>
	  </div>
	  <br />

	  <!------------------------------------------- CITY LISTING ----------------------------------->
	  <div class="section-wrapper">
		<div class='row'>
	  		<div class="col-md-8">
	  			<h2>City Listing</h2>
	  		</div>
			<div class='col-md-4 mb-4'>
				<form id='search-city-form'>
					<input onkeyup="this.value = this.value.toUpperCase();" type='text' name='cityName' id="searchCityName" class='form-control' placeholder='Search City Name' />
					<button type="submit" class='btn btn-success btn-block mt-2 search-btn'>Search City</button>
				</form>
			</div>
		</div>
		<div class="table-responsive CityList"></div>
		<div class="CityPaginationLink"></div>
		<div class="row no-gutters mt-3">
			<div class="col-md-4">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-city-modal">Add City</button>
			</div>
		</div>
	  </div>

    </div><!-- container -->
	
	<!-- Country MODAL -->
	<div id="add-country-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  	<div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add Country Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  	<span aria-hidden="true">&times;</span>
				</button>
		 	</div>
		  	<div class="modal-body pd-20">
			  	<form id="add-country-form">
			  		<div class="form-layout form-layout-3">
					  	<div class="row">
							<div class="col-md-12">
							  <div class="form-group">
								<input onkeyup="this.value = this.value.toUpperCase();" class="form-control countryNameInput" type="text" name="countryname" placeholder="Country Name">
							  </div>
							</div><!-- col-6 -->
					  	</div>
						<div class="form-layout-footer bd pd-20 bd-t-0">
							<button type="submit" class="btn btn-primary bd-0 add-btn">Add Country</button>
							<button class="btn btn-secondary bd-0" data-dismiss="modal">Cancel</button>
						</div><!-- form-group -->
					</div>
				</form>
		  	</div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--Country modal -->

	<!-- Update Country Form -->
	<div id="update-country-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  	<div class="modal-header pd-x-20">
				<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit Country Record</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  	<span aria-hidden="true">&times;</span>
				</button>
		 	</div>
		  	<div class="modal-body pd-20">
			  	<form id="update-country-form">
			  		<div class="form-layout form-layout-3">
					  	<div class="row">
							<div class="col-md-12">
							  <div class="form-group">
								<input onkeyup="this.value = this.value.toUpperCase();" class="form-control" type="text" id="updateCountryName" name="countryname" placeholder="Country Name" value="">

							  </div>
							</div><!-- col-6 -->
					  	</div>
					  	<input type="hidden" name="countryId" id="countryId" value="">
						<div class="form-layout-footer bd pd-20 bd-t-0">
							<button type="submit" class="btn btn-success bd-0 update-btn">Update Country</button>
							<button class="btn btn-secondary bd-0" data-dismiss="modal">Cancel</button>
						</div><!-- form-group -->
					</div>
				</form>
		  	</div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--Country modal -->

	<!------------------ END OF COUNTRY MODAL --------------------->

	<!------------------------------------ STATE MODALS ------------------------------------>

	<!-- State MODAL -->
	<div id="add-state-modal" class="modal fade" >
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add State Record</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
		  	<form id="add-state-form">
				<div class="form-layout">
				  <div class="row">
					<div class="col-md-12">
					  <div class="form-group">
						<div class="form-group mg-md-l--1 bd-t-0-force">
							<select class="countrySearch" class="form-control" name="countryId" data-placeholder="Select Country">
							  	<option label="Select Country"></option>
							  	<?php foreach( $getCountry as $country) : ?>
								<option value="<?= $country['COUNTRY_ID'] ?>"> <?= $country['COUNTRY']; ?></option>							  		
							  	<?php endforeach; ?>
							</select>
						  </div>
					  </div>
					</div><!-- col-6 -->
					<div class="col-md-12">
					  <div class="form-group">
						<input onkeyup="this.value = this.value.toUpperCase();" class="form-control" type="text" name="stateName" placeholder="State Name">
					  </div>
					</div><!-- col-6 -->
				  </div>
				  <div class="form-layout-footer bd pd-20 bd-t-0">
					<button class="btn btn-success bd-0 add-state-btn">Add State</button>
					<button class="btn btn-secondary bd-0">Cancel</button>
				  </div><!-- form-group -->
				</div>
		  	</form>
		  </div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--State modal -->
	
	<!-- State MODAL -->
	<div id="update-state-modal" class="modal fade" >
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit State Record</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
			<form id="update-state-form">
				<div class="form-layout">
				  <div class="row">
					<div class="col-md-12">
					  <div class="form-group">
						<div class="form-group mg-md-l--1 bd-t-0-force">
							<select class="form-control countrySearch" name="countryId" data-placeholder="Select Country">
							  	<option label="Select Country"></option>
							  	<?php foreach( $getCountry as $country) : ?>
								<option value="<?= $country['COUNTRY_ID'] ?>"> <?= $country['COUNTRY']; ?></option>							  		
							  	<?php endforeach; ?>
							</select>
						  </div>
					  </div>
					</div><!-- col-6 -->
					<div class="col-md-12">
					  <div class="form-group">
						<input onkeyup="this.value = this.value.toUpperCase();" class="form-control updateStateName" type="text" name="stateName" placeholder="State Name">
					  </div>
					</div><!-- col-6 -->
				  </div>
				  	<!-- SET STATE ID VIA JS -->
		  			<input type="hidden" name="stateId" class="stateId" value="">

				  <div class="form-layout-footer bd pd-20 bd-t-0">
					<button type="submit" class="btn btn-success bd-0">Update State</button>
					<button class="btn btn-danger bd-0" date-dismiss='modal'>Cancel</button>
				  </div><!-- form-group -->
				</div>
			</form>
		  </div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--State modal -->

	<!------------------------------------ END OF STATE MODALS -------------------------------------->

	<!-- Add City MODAL -->
	<div id="add-city-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add City Record</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
		  	<form id="add-city-form">
				<div class="form-layout">
				  <div class="row">
					<div class="col-md-12">
					  <div class="form-group">
						<div class="form-group mg-md-l--1 bd-t-0-force">
							<select  class="form-control stateSearchOption" name="stateName" data-placeholder="Select State">
								<option label="Select State"></option>
							<?php
							foreach ( $getState as $state ) : 
							?>
							  <option value="<?= $state['STATE_ID'] ?>"><?= $state['STATE'] ?></option>		  
							<?php 
							endforeach;
							?>
							</select>
					  	</div>
					  </div>
					</div><!-- col-12 -->
					<div class="col-md-12">
					  <div class="form-group">
						<input onkeyup="this.value = this.value.toUpperCase();" class="form-control" type="text" name="cityName" placeholder="City Name">
					  </div>
					</div><!-- col-12 -->
				  </div>
				  <div class="form-layout-footer bd pd-20 bd-t-0">
					<button type="submit" class="btn btn-success bd-0 add-btn">Add City</button>
					<button class="btn btn-danger bd-0" data-dismiss="modal">Cancel</button>
				  </div><!-- form-group -->
				</div>
			</form>
		  </div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--City modal -->

	<!-- Update City Modal -->
	<div id="update-city-modal" class="modal fade">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content tx-size-sm">
		  <div class="modal-header pd-x-20">
			<h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit City Record</h6>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body pd-20">
		  	<form id="update-city-form">
				<div class="form-layout">
				  <div class="row">
					<div class="col-md-12">
					  <div class="form-group">
						<div class="form-group mg-md-l--1 bd-t-0-force">
							<select class="form-control stateSearchOption" name="stateName">
							  	<option label="Select State"></option>
							  	<?php
								foreach ( $getState as $state ) : 
								?>
								  <option value="<?= $state['STATE_ID'] ?>"><?= $state['STATE'] ?></option>		  
								<?php 
								endforeach;
								?>							  
							</select>
						  </div>
					  </div>
					</div><!-- col-6 -->
					<div class="col-md-12">
					  <div class="form-group">
						<input onkeyup="this.value = this.value.toUpperCase();" class="form-control updateCityName" type="text" name="cityName" placeholder="City Name">
					  </div>
					</div><!-- col-6 -->
				  	<input type="hidden" name="cityId" class="cityId" value="">
					
					
				  </div>
				  <div class="form-layout-footer bd pd-20 bd-t-0">
					<button class="btn btn-success bd-0 update-city-btn">Update City</button>
					<button class="btn btn-danger bd-0" data-dismiss="modal">Cancel</button>
				  </div><!-- form-group -->
				</div>
			</form>
		  </div><!-- modal-body -->			  
		</div>
	  </div><!-- modal-dialog -->
	</div><!--City modal -->

	<!------------------------------------ CITY MODAL ------------------------------------->