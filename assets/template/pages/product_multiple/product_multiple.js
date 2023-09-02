
$(function (){
	$('#addbutton').on('click', (e) => {
		e.preventDefault()
		
		var element = '<div class="boxes">' +
							'<ul class="list-group">' +
							  	'<li class="list-group-item">' +
								  	'<div class="row">' +
										'<div class="col-md-4">' +
											'<label style="color: black">Product Name</label><br />' + 
											'<input type="text" name="productName[]" class="form-control" >' +
										'</div>' +
										'<div class="col-md-4">' +
											'<label style="color: black">No of Pieces</label><br />' +
											'<input type="text" name="productNoOfPieces[]" class="form-control" >' +
										'</div>' +
										'<div class="col-md-4">' +
											'<label style="color: black">Price (Single Piece)</label><br />' +
											'<input type="text" name="productPricePerPiece[]" class="form-control" >' +
										'</div>' +
								  	'</div>' +
								'</li>' +
							'</ul>' +
						'</div>' ;
		$(".boxes-parent").append(element);
	})

	$(document).on('click','.del', function(e){
		e.preventDefault()

		if ( $('.boxes-parent .boxes').length > 1 )
		{
			$('.boxes-parent .boxes:last-child').remove()
		}
   	})

   	$('#add-multiple-form').on('submit', (e) => {
   		e.preventDefault()

   		$.ajax({
	      url : base_url + "product/multiple/add",
	      method : "POST",
	      dataType : "JSON",
	      data : $('#add-multiple-form').serializeArray(),
	      beforeSend : function() {
	      	
	      	$('.add-product-btn').html('<i class="fa fa-spinner fa-spin"></i> Saving')
	       	$('.add-product-btn').attr('disabled', true)

	      },
	      success : function (data) 
	      {
	      	$('.add-product-btn').attr('disabled', false)

	      	$('.add-product-btn').html('Save Product')

	      	if ( data.code == 200 )
	      	{
	      		$('#add-multiple-form')[0].reset()
	      		
      			$('.search-product-multiple-btn').trigger('click')

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
})


$('#product-multiple-form').on('submit', function (e){

	e.preventDefault()

	$.ajax({
    url : base_url + "product/multiple/show",
    method : "POST",
    data : $(this).serializeArray(),
    beforeSend : function() {
    	$('.search-product-multiple-btn').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) 
    {
    	let data = JSON.parse( res )

    	$('.search-product-multiple-btn').html('Search Product')

    	if ( data.code == 200 ) 
    	{
    		// $('.search-product-multiple-btn').trigger('click')

    		$('.search-product-multiple-data').html(data.ProductMultipleData)
    		
    		$('.product-multiple-listing').html(data.ProductMultipleListing)

    		$('.updateCNNumber').val( data.CNNumber.toString() )
    	}
    	else
    	{
			$('.search-product-multiple-data').html(
										'<div class="alert alert-danger">' 
										+ data.message + 
										'</div>'
									)
			$('.stage-status-update').html('')
			$('.product-multiple-listing').html('')
    	}
    } 
  });
})


/**************************
EDIT BUTTON (PRODUCT MULTIPLE PAGE)
**************************/

/*************************************************
GET THE VALUE FOR EDIT PRODUCT FORM (PRODUCT MULTIPLE PAGE)
*************************************************/
$(document).on('click', '.edit-multiple-product', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value;

  let data = {
    'id' : id
  }

  $.ajax({
    url  : base_url + "product/multiple/get",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {
        // PRODUCT NAME
        $('.updateProductName').val( data.productMultipleData.PRODUCT_NAME)

        // PRODUCT QUANTITY
        $('.updateProductQuantity').val( data.productMultipleData.PRODUCT_QUANTITY)

		// PRODUCT UNTI PRICE
        $('.productUnitPrice').val( data.productMultipleData.PRODUCT_PRICE)

        // SET PRODUCT MULTIPLE ID 
        $('.updateProductMultipleId').val( data.productMultipleData.PRODUCT_MULTIPLE_ID)

      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-product-multiple-form').on('submit', function (e) {
  e.preventDefault()

  let formData = new FormData(this)

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  
  $.ajax({
    url  : base_url + "product/multiple/update",
    data : formData,
    method : 'POST',
    contentType: false,
    cache: false,
    processData:false,
    success : function ( data ) {
      if ( data.code == 200 ) 
      {

		$('#update-product-multiple-form')[0].reset()

      	$('.search-product-multiple-btn').trigger('click')

        const toast = Swal.mixin({
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
        const toast = Swal.mixin({
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
/********************************
END OF EDIT BUTTON (PRODUCT PAGE)
********************************/

/**************************
DELETE BUTTON (PRODUCT PAGE)
**************************/

$(document).on('click', '.delete-multiple-product', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let data = {
    'id' : id
  }

  // console.log( productData )

  // return

  Swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      // return 
      $.ajax({
        'url' : base_url + 'product/multiple/delete',
        'data' : JSON.stringify( data ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          	let data = JSON.parse(res);

          if ( data.code == 200 ) 
          {

          	$('.search-product-multiple-btn').trigger('click')

            Swal(
                'Deleted!',
                data.message,
                'success'
              )
          }
          else
          {
            Swal(
                'Deleted!',
                data.message,
                'success'
              )
          }
        }
      });
    }
  })
})