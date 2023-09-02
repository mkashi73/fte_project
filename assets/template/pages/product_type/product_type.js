/*****************************
AUTHOR : SALMAN BUKHARI
DATE   : 04/01/2019
DESCRIPTION : PRODUCT PAGE AJAX
*****************************/

/***********************
PRODUCT TYPE TABLE PAGINATION
***********************/
function getProductTypePage ( page ) 
{
  $.ajax({
    url : base_url + "get/product/type/page/" + page,
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
      $(".productTypeList").html(data.ProductTypeList);

      $(".productTypePaginationLink").html(data.ProductTypePaginationLink);
    }
  });
}

getProductTypePage(1)

$(document).on('click', '.pagination li a', function (e) {

  e.preventDefault();

  var page = $(this).data('ci-pagination-page');

  // console.log( page );
  getProductTypePage(page);
}); // End of Count


/******************************
END OF PRODUCT TABLE PAGINATION
*******************************/

/************************
ADD BUTTON (PRODUCT PAGE)
************************/
$('#add-product-type-form').on('submit', function (e){
    e.preventDefault();

    let formData = new FormData(this)

    let page = $('.active').children().html() 
    // console.log(formData);
    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

    $.ajax({
        url  : base_url + "product/type/add",
        data : formData,
        method : 'POST',
        contentType: false,
        cache: false,
        processData:false,
        success : function (res) {
            let data = JSON.parse(res);
            
            $('.pagination-table').load( base_url + "get/product/type/page/" + page, function (res) {
      
	          	let productTypeData = JSON.parse( res )

				// console.log( data )
				$(".productTypeList").html(productTypeData.ProductTypeList);

				$(".productTypePaginationLink").html(productTypeData.ProductTypePaginationLink);

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
    'productTypeId' : id
  }

  $.ajax({
    url  : base_url + "product/type/get/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {
        // PRODUCT STATUS NAME
        $('.updateTypeName').val( data.productTypeData.PRODUCT_TYPE)

        // PRODUCT STATUS ID
        $('.updateProductTypeId').val( data.productTypeData.PRODUCT_TYPE_ID)
      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-product-type-form').on('submit', function (e) {
  e.preventDefault()

  let formData = new FormData(this)

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  
  $.ajax({
    url  : base_url + "product/type/update",
    data : formData,
    method : 'POST',
    contentType: false,
    cache: false,
    processData:false,
    success : function ( data ) {
      if ( data.code == 200 ) 
      {
        $('.pagination-table').load( base_url + "get/product/type/page/" + page, function (res) {
      
          	let productTypeData = JSON.parse( res )

			// console.log( data )
			$(".productTypeList").html(productTypeData.ProductTypeList);

			$(".productTypePaginationLink").html(productTypeData.ProductTypePaginationLink);

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

  let productTypeId = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let productTypeData = {
    'productTypeId' : productTypeId
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
        'url' : base_url + 'product/type/delete',
        'data' : JSON.stringify( productTypeData ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          	let data = JSON.parse(res);


			$('.pagination-table').load( base_url + "get/product/type/page/" + page, function (res) {
	      
	          	let productTypeData = JSON.parse( res )

				// console.log( data )
				$(".productTypeList").html(productTypeData.ProductTypeList);

				$(".productTypePaginationLink").html(productTypeData.ProductTypePaginationLink);

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