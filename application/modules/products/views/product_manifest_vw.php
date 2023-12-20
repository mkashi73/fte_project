<div class="slim-mainpanel">
  <div class="container">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Blank Page</li>
      </ol>
      <h6 class="slim-pagetitle">Reports</h6>
    </div><!-- slim-pageheader -->
    <div class="section-wrapper">
      <form id="generate-product-manifest"  method="POST" target="_blank">
        <label class="section-title">Generate Manifist</label> <br />          
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Search by Master AWB: <span class="tx-danger"></span></label>
                <input class="form-control" type="text" name="mabNumber" placeholder="Enter MAWB">
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Search By Origin: <span class="tx-danger"></span></label>
                <select name="countryId" class="form-control select2" data-placeholder="Choose Origin">
                  <option label="Choose country" disabled></option>
                  <option value="224">USA</option>
                  <option value="77">UK</option>   
                  <option value="01">All Countries</option>
                </select>
              </div>
            </div><!-- col-4 -->  
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Search by User <span class="tx-danger"></span></label>
                <select name="userID" class="form-control select2" data-placeholder="Select User">
                  <option label="Select User"></option>
                  <?php
                  foreach( $users AS $userRecord) :
                  ?>
                    <option value="<?= $userRecord['USER_ID'] ?>"><?= $userRecord['FULL_NAME'] ?></option>
                  <?php
                  endforeach;
                  ?>             
                </select>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                  <label class="form-control-label">From Date <span class="tx-danger"></span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                    </div>
                    <input type="text" name="fromDate" id="dbDateFormat" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                  </div>
              </div>
            </div><!-- col-4 -->
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                  <label class="form-control-label">To Date <span class="tx-danger"></span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                      </div>
                    </div>
                    <input type="text" name="toDate" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                  </div>
              </div>
            </div><!-- col-4 -->
          </div><!-- row -->
          <div class="form-layout-footer">
            <button type="submit" class="btn btn-primary bd-0 generate-manifest-btn">Generate Manifist</button>
            <button type="submit" class="btn btn-primary generate-excel-report">Generate Manifist Excel</button>
            <button type="submit" class="btn btn-primary generate-loadsheet">Generate Loadsheet</button>
          </div>
        </div>
      </form>
    </div><!-- section-wrapper -->
  </div><!-- container -->
