<style type="text/css">
	/* Add a right margin to each icon */
	.fa {
	  margin-left: -12px;
	  margin-right: 8px;
	}
</style>
<div class="slim-mainpanel">
	<div class="container">
		<div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			  <li class="breadcrumb-item"><a href="#">Home</a></li>
			  <li class="breadcrumb-item active" aria-current="page"><?= $headerData['pageName'] ?></li>
			</ol>
			<h6 class="slim-pagetitle"><?= $headerData['pageName'] ?></h6>
		</div><!-- slim-pageheader -->
		<div class="section-wrapper">	
			<form id="search-product-form">
				<div class="row no-gutters">
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="cnNumber" class="form-control" placeholder="Search CN">
						</div><!-- form-group -->
						<button class="btn btn-success btn-block search-product-btn">Search <?= $headerData['pageName'] ?></button>
					</div>
					<div class="offset-md-2 col col-md-4 search-product-data">
						
					</div>

				</div>
			</form>
			<hr>

			<div id="accordion" class="accordion-one stage-status-update" role="tablist" aria-multiselectable="true">
			</div>
			<br />
			
		</div>
	</div><!-- container -->