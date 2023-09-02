/*****************************
AUTHOR : SALMAN BUKHARI
DATE   : 04/01/2019
DESCRIPTION : USER ROLES PAGE AJAX
*****************************/

/***********************
USER TABLE PAGINATION
***********************/
function getUserRolesPage ( page ) 
{
  $.ajax({
    url : base_url + "get/user/roles/page/" + page,
    method : "GET",
    dataType : "JSON",
    beforeSend : function() {
      $('.user-roles-table').css({ 
        "opacity" : "0.6" 
      });

    },
    success : function (data) 
    {
      // console.log( data )
      $(".userRolesList").html(data.UserRolesList);

      $(".userRolesPaginationLink").html(data.UserRolesPaginationLink);
    }
  });
}

getUserRolesPage(1)

$(document).on('click', '.pagination li a', function (e) {

  e.preventDefault();

  var page = $(this).data('ci-pagination-page');

  // console.log( page );
  getUserRolesPage(page);
}); // End of User Roles Pagination Display


/*********************************
END OF USER ROLES TABLE PAGINATION
*********************************/

/*************************************************
GET THE VALUE FOR EDIT USER ROLES FORM (USER ROLES PAGE)
*************************************************/
$(document).on('click', '.updateUserRole', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value;

  let data = {
    'userRoleId' : id
  }

  $.ajax({
    url  : base_url + "get/user/roles/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {

        // SET USER ROLE ID
        $('#userRoleId').val( data.userRolesData.USER_ROLE_ID)

        // USER ROLE
        $('#updateRole').val( data.userRolesData.ROLE)

        // ACTIVE STATUS
        $('#updateActiveFlag').val( data.userRolesData.ACTIVE_FLAG)
      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-user-roles-form').on('submit', function (e) {
  e.preventDefault()

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  
  let data = {
    'userRoleId' : $('#userRoleId').val(),
    'userRole' : $('#updateRole').val(),
    'userRoleFlag' : $('#updateActiveFlag').val() 
  }

  $.ajax({
    url  : base_url + "user/role/update",
    data : JSON.stringify(data),
    method : 'POST',
    success : function ( data ) {
      if ( data.code == 200 ) 
      {
        $('.user-roles-table').load(base_url + "get/user/roles/page/" + page, function (res) {
          
          let userRoleData = JSON.parse( res )

          $(".userRolesList").html(userRoleData.UserRolesList)

          $(".userRolesPaginationLink").html(userRoleData.UserRolesPaginationLink)

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

$(function (){

    $('#add-user-roles-form').on('submit', function (e){
        e.preventDefault();

        var formData = $( this ).serialize();

        let page = $('.active').children().html() 

        if ( typeof page === "undefined" ) 
        {
          page = 1
        }

        $.ajax({
            url  : base_url + "user/role/add",
            data : formData,
            method : 'POST',
            success : function (res) {
                let data = JSON.parse(res);
                
                $('.user-roles-table').load(base_url + "get/user/roles/page/" + page, function (res) {
          
                  let userRoleData = JSON.parse( res )

                  $(".userRolesList").html(userRoleData.UserRolesList)

                  $(".userRolesPaginationLink").html(userRoleData.UserRolesPaginationLink)

                }) // refresh Country table after entry

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
            }
        });
    });
});


/**************************
DELETE BUTTON (PRODUCT PAGE)
**************************/

$(document).on('click', '.delete-btn', function (e) {
  e.preventDefault()

  let userRoleId = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let userRoleData = {
    'userRoleId' : userRoleId
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
        'url' : base_url + 'user/role/delete',
        'data' : JSON.stringify( userRoleData ),
        'method' : 'POST',
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)

        $('.user-roles-table').load(base_url + "get/user/roles/page/" + page, function (res) {

            let userRoleData = JSON.parse( res )

            $(".userRolesList").html(userRoleData.UserRolesList)

            $(".userRolesPaginationLink").html(userRoleData.UserRolesPaginationLink)

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