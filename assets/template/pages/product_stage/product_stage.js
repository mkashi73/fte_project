/*****************************
AUTHOR : SALMAN BUKHARI
DATE   : 04/01/2019
DESCRIPTION : PRODUCT PAGE AJAX
*****************************/

/************************************
PRODUCT SEARCH IN PRODUCT STAGES FORM 
************************************/

$('#search-product-form').on('submit', function (e){

	e.preventDefault()

	$.ajax({
    url : base_url + "product/search",
    method : "POST",
    data : $(this).serializeArray(),
    beforeSend : function() {
    	$('.search-product-btn').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) 
    {
    	let data = JSON.parse( res )

    	// console.log(data)

    	$('.search-product-btn').html('Search Product')

    	if ( data.code == 200 ) 
    	{
    		$('.search-product-data').html(data.ProductStageData.productInformation)

    		let productStageData = {
    			'productId' : $('#productId').val()
    		}

    		$.ajax({
    			url : base_url + 'product/stage/get/data',
		  		data : JSON.stringify(productStageData),
		  		method : 'POST',
		  		success : function ( res ) {
		  			let data = JSON.parse( res )

	  				$('.stage-status-update').html(data.message)

            $('.fc-datepicker').datepicker({
              dateFormat: 'dd-mm-yy',
              showOtherMonths: true,
              selectOtherMonths: true
            });
		  		}
			})
    	}
    	else
    	{
			$('.search-product-data').html(
										'<div class="alert alert-danger">' 
										+ data.ProductStageData + 
										'</div>'
									)
			$('.stage-status-update').html('')
    	}
    } 
  });
})
$(document).on('submit', '.add-product-stage-form', function (e) {
  	e.preventDefault()

  	let data = $(this).serializeArray()

  	data.push({ 
  		name : 'productId', value : $('#productId').val()
  	})

  	$.ajax({
  		url : base_url + 'product/stage/add',
  		data : data,
  		method : 'POST',
  		success : function ( res ) {
  			let addProductResponse = JSON.parse( res )

  			if ( addProductResponse.code == 200 ) 
  			{
  				$('.product-stage').load( base_url + "product/stage/get/data", data, function (res) {

  					let data = JSON.parse( res )

  					$('.stage-status-update').html(data.message)

				  }) // refresh Country table after entry
  				const toast = swal.mixin({
  					toast: true,
  					position: 'top-end',
  					showConfirmButton: false,
  					timer: 3000
          });
          toast({
          	type: 'success',
          	title: addProductResponse.message
          })
  			}
  			else
  			{
  				const toast = swal.mixin({
  					toast: true,
  					position: 'top-end',
  					showConfirmButton: false,
  					timer: 3000
				  });
  				toast({
  					type: 'error',
  					title: addProductResponse.message
  				})
  			}
  		}
  	})
})

$(document).on('submit', '#update-product-data', function (e) {
  e.preventDefault()

  let data = $(this).serializeArray()

    data.push({ 
      name : 'productId', value : $('#productId').val()
    })

    $.ajax({
      url : base_url + 'product/stage/update/data',
      data : data,
      method : 'POST',
      success : function ( res ) {
        let data = JSON.parse( res )

        if ( data.code == 200 ) 
        {
          const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          toast({
            type: 'success',
            title: data.message
          })
        }
        else
        {
          const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          toast({
            type: 'error',
            title: data.message
          })
        }
      }
  })
})