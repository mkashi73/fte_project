/*****************
Company Pagination
*****************/
function getPrvPage ( page ) 
{
    $.ajax({
        url : base_url + "get/prv/page/" + page,
        method : "GET",
        dataType : "JSON",       
        success : function (data) 
        {
            $(".prvList").html(data.PrvList);
            $(".prvPaginationLink").html(data.PrvPaginationLink);
        }
    });
}

getPrvPage(1)

$(document).on('click', '.pagination li a', function (e) {

    e.preventDefault();

    var page = $(this).data('ci-pagination-page');

    // console.log( page );
    getPrvPage(page);
}); // End of Country Pagination Display


/************************
ADD BUTTON (PRODUCT PAGE)
************************/
$('#add-prv-form').on('submit', function (e){
    e.preventDefault();

    let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

    $.ajax({
        url  : base_url + "prv/add",
        data : $(this).serializeArray(),
        method : 'POST',
        beforeSend : function() {
            $('.add-prv-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
        },
        success : function (res) {
            $('.add-prv-btn').html('<i class="fas fa-pencil-alt"></i> Add PRV')

            let data = JSON.parse(res);
            
            $('.prv-table').load( base_url + "get/prv/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                
                $(".prvList").html(data.PrvList);
                $(".prvPaginationLink").html(data.PrvPaginationLink);

            }) // refresh Country table after entry
            // console.log( data )

            if ( data.code == 200 ) 
            {
                $('#add-prv-form')[0].reset();
                $('#add-prv-modal').modal('hide');

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
/*************************************************
GET THE VALUE FOR EDIT COMPANY FORM (COMPANY PAGE)
*************************************************/
$(document).on('click', '.edit-btn', function (e) {
  e.preventDefault()
  let id = $(this).children()[1].value;

  let data = {
    'prv_id' : id
  }

  $.ajax({
    url  : base_url + "prv/data/get",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {
      if ( data.code == 200 ) 
      {
        $('.updateReceivedFrom').val( data.prvData.RECEIVED_FROM);
        $('.updateReceivedAmount').val( data.prvData.RECEIVED_AMOUNT);
        $('.updatePrvType').val( data.prvData.PRV_TYPE);
        $('.updateAccountOf').val( data.prvData.ACCOUNT_OF);
        $('.updatePrvId').val( data.prvData.PRV_ID);
      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-prv-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        'url' : base_url + 'prv/update',
        'data' : $(this).serializeArray(),
        'method' : 'POST',
        beforeSend : function (){
           
        },
        success : function ( res ){
            let page = $('.active').children().html() 

            if ( typeof page === "undefined" ) 
            {
              page = 1
            }

            $('.prv-table').load( base_url + "get/prv/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                
                $(".prvList").html(data.PrvList);
                $(".prvPaginationLink").html(data.PrvPaginationLink);

            }) // refresh Country table after entry

            if ( res.code == 200 ) 
            {
                $('#update-prv-form')[0].reset();
                $('#update-prv-modal').modal('hide');

                const toast = swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });
                toast({
                  type: 'success',
                  title: res.message
                })
                // window.location = base_url + 'user/role'
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
                  title: res.message
                })
            }
        }, // end of success function
        error : function () {
            $('#addMenuBtn').prop("disabled", false);
            
            $('#addMenuBtn').css("opacity","1");
        }
    });
});
/**************************
DELETE BUTTON (PRODUCT PAGE)
**************************/

$(document).on('click', '.delete-btn', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let data = {
    'prvId' : id
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
        'url' : base_url + 'prv/delete',
        'data' : JSON.stringify( data ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)

          $('.prv-table').load(base_url + "get/prv/page/" + page, function (res) {
            
            let data = JSON.parse( res )
            $(".prvList").html(data.PrvList);
            $(".prvPaginationLink").html(data.PrvPaginationLink);
          })
          
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


$(document).on('submit', '#search-prv-by-id', function (e) {
  e.preventDefault()
  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  $.ajax({
    'url' : base_url + 'get/prv/page/' + page,
    'data' : $(this).serializeArray(),
    'method' : 'POST',
    beforeSend : function() {
      $('.search-prv').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) {
      $('.search-prv').html('Search PRV')

      let data = JSON.parse( res )

      $(".prvList").html(data.PrvList);
      $(".prvPaginationLink").html(data.PrvPaginationLink);
    }
  })
})


$(".generate-prv-report-btn").click(function() {
  $("#generate-prv-report").attr(
    "action",
    base_url + "prv/report/generate"
  );
});