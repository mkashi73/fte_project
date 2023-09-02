$(function (){
	$('#user-detail').on('submit', (e) => {
		e.preventDefault();
		let	id = $('.select2').val();
		// $('.btn-success').html('<i class="fa fa-spinner fa-spin"></i> Searching');
		// alert(id);
    var formData = $( '#user-detail' ).serialize();


		$.ajax({

	      	url : base_url + "account/StationLedger/getRecords",
	      	method : "POST",
      		data : formData,
	      
	      // data : {id:id},
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
		      	getStationLedger();
		       
			}
		})
	})

	 // THIS FUNCTION IS USE  FOR TO GET PAYMENT STATUS 
	 function getLedger(id) {

	 	$.ajax({
	 		url:base_url +"account/StationLedger/payment",
	 		method: "POST",
	 		data : {id:id},
	 		success :function(data) {
	 			 		$('#show-payment').html(data);
	 			 	}
	 	});
	 }



})

// for station ledger report

function getStationLedger() {
        'use strict';
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        let user_id = $('#user_id').val();


        if (user_id !='') {



        $('#datatable1').DataTable({
          responsive: true,
          language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items',
          },
          // "ajax" : "<?= base_url('account/StationLedger/LedgerInDataTable');?>",
          "order" : [],
           'ajax': {
                    'url':  base_url + 'account/StationLedger/LedgerInDataTable',
                    'type': 'POST',
                    'data': {start:start, end:end, user_id: user_id}
                },



        });
    }
    else{
    	alert('kindly select a station');
    }
     }

 
