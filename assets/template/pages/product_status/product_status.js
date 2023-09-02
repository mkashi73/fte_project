/*****************************
AUTHOR : SALMAN BUKHARI
DATE   : 04/01/2019
DESCRIPTION : PRODUCT PAGE AJAX
*****************************/

/***********************
PRODUCT TABLE PAGINATION
***********************/
function getProductStatusPage ( page ) 
{
  $.ajax({
    url : base_url + "get/product/status/page/" + page,
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
      $(".productStatusList").html(data.ProductStatusList);

      $(".productStatusPaginationLink").html(data.ProductStatusPaginationLink);
    }
  });
}

getProductStatusPage(1)

$(document).on('click', '.pagination li a', function (e) {

  e.preventDefault();

  var page = $(this).data('ci-pagination-page');

  // console.log( page );
  getProductStatusPage(page);
}); // End of Count


/******************************
END OF PRODUCT TABLE PAGINATION
*******************************/

/************************
ADD BUTTON (PRODUCT PAGE)
************************/
$('#add-product-status-form').on('submit', function (e){
    e.preventDefault();

    let formData = new FormData(this)

    let page = $('.active').children().html() 
    // console.log(formData);
    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

    $.ajax({
        url  : base_url + "product/status/add",
        data : formData,
        method : 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success : function (res) {
            let data = JSON.parse(res);
            
            $('.pagination-table').load( base_url + "get/product/status/page/" + page, function (res) {
      
	          	let productStatusData = JSON.parse( res )

				$(".productStatusList").html(productStatusData.ProductStatusList);

				$(".productStatusPaginationLink").html(productStatusData.ProductStatusPaginationLink);

	        }) // refresh Country table after entry
            // console.log( data )

            if ( data.code == 200 ) 
            {
            
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
    });
});
/********************************
END OF ADD BUTTON (PRODUCT PAGE)
********************************/

/**************************
EDIT BUTTON (PRODUCT PAGE)
**************************/

/*************************************************
GET THE VALUE FOR EDIT PRODUCT FORM (PRODUCT PAGE)
*************************************************/
$(document).on('click', '.update-btn', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value;

  let data = {
    'productStatusId' : id
  }

  $.ajax({
    url  : base_url + "product/status/get/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {
        // PRODUCT STATUS NAME
        $('.updateStatusName').val( data.productStatusData.PRODUCT_STATUS_NAME)

        // PRODUCT STATUS ID
        $('.updateProductStatusId').val( data.productStatusData.PRODUCT_STATUS_ID)
      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-product-status-form').on('submit', function (e) {
  e.preventDefault()

  let formData = new FormData(this)

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  
  $.ajax({
    url  : base_url + "product/status/update",
    data : formData,
    method : 'POST',
    contentType: false,
    cache: false,
    processData:false,
    success : function ( data ) {
      if ( data.code == 200 ) 
      {
        $('.pagination-table').load( base_url + "get/product/status/page/" + page, function (res) {
      
          	let productStatusData = JSON.parse( res )

			$(".productStatusList").html(productStatusData.ProductStatusList);

			$(".productStatusPaginationLink").html(productStatusData.ProductStatusPaginationLink);

        }) // refresh Country table after entry

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

$(document).on('click', '.delete-btn', function (e) {
  e.preventDefault()

  let productStatusId = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let productStatusData = {
    'productStatusId' : productStatusId
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
        'url' : base_url + 'product/status/delete',
        'data' : JSON.stringify( productStatusData ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          	let data = JSON.parse(res);


			$('.pagination-table').load( base_url + "get/product/status/page/" + page, function (res) {

				let productStatusData = JSON.parse( res )

				$(".productStatusList").html(productStatusData.ProductStatusList);

				$(".productStatusPaginationLink").html(productStatusData.ProductStatusPaginationLink);

			}) // refresh Country table after entry

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