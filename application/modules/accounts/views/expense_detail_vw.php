<div class="slim-mainpanel">
  <div class="container">
    <div class="slim-pageheader">
      <ol class="breadcrumb slim-breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Expense Detail Report</li>
      </ol>
      <h6 class="slim-pagetitle">Reports</h6>
    </div><!-- slim-pageheader -->
    <div class="section-wrapper">
      <form id="generate-expense-report" action="<?= base_url('expense/report/generate') ?>" method="POST" target="_blank">
        <label class="section-title">Generate Expense Detail Report</label> <br />          
        <div class="form-layout">
          <div class="row mg-b-25">
            <div class="col-lg-4">
              <div class="form-group">
                <label class="form-control-label">Search by Expense Number: <span class="tx-danger"></span></label>
                <input class="form-control" type="text" name="expense_id" placeholder="Enter Expense Number">
              </div>
            </div><!-- col-4 -->
            
            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Search by Station <span class="tx-danger"></span></label>
                <select name="station" class="form-control select2" data-placeholder="Select STATION" <?php if ($userId != 1 && $userId != 51) echo "disabled" ?>>
                  <option label="Select Station"></option>
                  <?php
                  foreach( $users AS $userRecord) :
                  ?>
                    <option value="<?= $userRecord['STATION_NAME'] ?>" <?php if ($userRecord['STATION_NAME'] === $station_name && $userId != 1) echo 'selected="selected"'; ?>><?= $userRecord['STATION_NAME'] ?></option>
                  <?php
                  endforeach;
                  ?>             
                </select>
              </div>
            </div><!-- col-4 -->

            <div class="col-lg-4">
              <div class="form-group mg-b-10-force">
                <label class="form-control-label">Search by Account Head <span class="tx-danger"></span></label>
                <select name="head" class="form-control select2" data-placeholder="Select Head">
                  <option label="Select Head"></option>
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
            <button type="submit" class="btn btn-primary bd-0 generate-expense-report-btn">Generate Expense Detail Report</button>
            <button type="submit" class="btn btn-primary generate-excel-report">Generate Excel</button>
          </div>
        </div>
      </form>
    </div><!-- section-wrapper -->
  </div><!-- container -->
