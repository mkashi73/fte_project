


$(function (){
	$('#account-detail').on('submit', (e) => {
		e.preventDefault();
		let	id = $('.select2').val();
		// $('.btn-success').html('<i class="fa fa-spinner fa-spin"></i> Searching');
		// alert(id);
		$.ajax({

	      url : base_url + "account/AccountController/account_details",
	      method : "POST",
	      // dataType : "JSON",
	      data : {id:id},
	      beforeSend : function() {
	      	
		      	$('.btn-success').html('<i class="fa fa-spinner fa-spin"></i> Searching');
		       	$('.btn-success').attr('disabled', true);

	      	},
	      success : function (data) 
	        {
		      	$('.btn-success').attr('disabled', false);

		      	$('.btn-success').html('Search');
		      	$('#detail-listing').html(data);
			}
		})
	})
})
/***********************
PRODUCT TABLE PAGINATION
***********************/
function getProductPage ( page ) 
{
  $.ajax({
    url : base_url + "account/AccountController/getProductPagination/" + page,
    method : "GET",
    dataType : "JSON",
    beforeSend : function() {
      $('.country-table').css({ 
        "opacity" : "0.6" 
      });

    },
    success : function (data) 
    {
      // console.log( data )
      $("#detail-listing").html(data.DetailListing);

      $(".productPaginationLink").html(data.ProductPaginationLink);
    }
  });
}

getProductPage(1)

$(document).on('click', '.pagination li a', function (e) {

  e.preventDefault();

  var page = $(this).data('ci-pagination-page');

  // console.log( page );
  getProductPage(page);
}); // End of Country Pagination Display

/******************************
END OF PRODUCT TABLE PAGINATION
*******************************/

$(document).on('click', '.delete-btn', function (e) {
  e.preventDefault()

  let productId = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let productData = {
    'productId' : productId
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
        'url' : base_url + 'delete/product',
        'data' : JSON.stringify( productData ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)

          // $('#detail-listing').load(base_url + "get/product/page/" + page, function (res) {
            
          //   let productData = JSON.parse( res )
          //   $("#detail-listing").html(data.DetailListing);
            
          // })
          
          if ( data.code == 200 ) 
          {
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


