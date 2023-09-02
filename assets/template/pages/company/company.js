/*****************
Company Pagination
*****************/
function getCompanyPage ( page ) 
{
    $.ajax({
        url : base_url + "get/company/page/" + page,
        method : "GET",
        dataType : "JSON",
        beforeSend : function() {
            $('.company-table').css({ 
                "opacity" : "0.6" 
            });

        },
        success : function (data) 
        {
            // console.log( data )
            $(".companyList").html(data.CompanyList);

            $(".companyPaginationLink").html(data.companyPaginationLink);
        }
    });
}

getCompanyPage(1)

$(document).on('click', '.pagination li a', function (e) {

    e.preventDefault();

    var page = $(this).data('ci-pagination-page');

    // console.log( page );
    getCompanyPage(page);
}); // End of Country Pagination Display


/************************
ADD BUTTON (PRODUCT PAGE)
************************/
$('#add-company-form').on('submit', function (e){
    e.preventDefault();

    let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

    $.ajax({
        url  : base_url + "company/add",
        data : $(this).serializeArray(),
        method : 'POST',
        beforeSend : function() {
            $('.add-company-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
        },
        success : function (res) {
            $('.add-company-btn').html('<i class="fas fa-pencil-alt"></i> Add Company')

            let data = JSON.parse(res);
            
            $('.pagination-table').load( base_url + "get/company/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                // console.log( data )
                $(".companyList").html(data.CompanyList);

                $(".companyPaginationLink").html(data.CompanyPaginationLink);

            }) // refresh Country table after entry
            // console.log( data )

            if ( data.code == 200 ) 
            {
                $('#add-company-form')[0].reset()

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
    'id' : id
  }

  $.ajax({
    url  : base_url + "company/data/get",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {
        // COMPANY NAME
        $('.updateCompanyName').val( data.data.COMPANY_NAME)

        // COMPANY WEB URL
        $('.updateCompanyWebUrl').val( data.data.COMPANY_WEB_URL)

        // COMPANY ID
        $('.updateCompanyId').val( data.data.COMPANY_ID)

      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-company-form').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        'url' : base_url + 'company/update',
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

            $('.pagination-table').load( base_url + "get/company/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                $(".companyList").html(data.CompanyList);

                $(".companyPaginationLink").html(data.CompanyPaginationLink);

            }) // refresh Country table after entry

            let data = JSON.parse(res);
        
            if ( data.code == 200 )
            {
                $('#update-company-form')[0].reset()

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
                  title: data.message
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
        'url' : base_url + 'company/delete',
        'data' : JSON.stringify( data ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)

          $('.pagination-table').load(base_url + "get/company/page/" + page, function (res) {
            
            let data = JSON.parse( res )

            $(".companyList").html(data.CompanyList)

            $(".companyPaginationLink").html(data.CompanyPaginationLink)
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