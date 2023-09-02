$(function (){

	//  to download ledger for station

	

	$('#account-detail').on('submit', (e) => {
		e.preventDefault();
		let	id = $('.select2').val();
		// $('.btn-success').html('<i class="fa fa-spinner fa-spin"></i> Searching');
		// alert(id);
		$.ajax({

	      url : base_url + "account/LedgerReport/ledgerReport",
	      method : "POST",
	      // dataType : "JSON",
	      data : {id:id},
	      beforeSend : function() {
	      	
		      	$('.change-it').html('<i class="fa fa-spinner fa-spin"></i> Searching');
		       	$('.change-it').attr('disabled', true);

	      	},
	      success : function (data) 
	        {
	        	// alert(data);
		      	$('.change-it').html('Search');

		      	$('.change-it').attr('disabled', false);

		      	$('#Ledger-Report').html(data);
		      	// TO GET PAYMENT STATUS  HERER
		      	getLedger(id);
		      	// $('#detail-listing').html(data);
			}
		})
	})

	 // THIS FUNCTION IS USE  FOR TO GET PAYMENT STATUS 
	 function getLedger(id) {

	 	$.ajax({
	 		url:base_url +"account/LedgerReport/payment",
	 		method: "POST",
	 		data : {id:id},
	 		success :function(data) {
	 			 		$('#show-payment').html(data);
	 			 	}
	 	});
	 }



})

