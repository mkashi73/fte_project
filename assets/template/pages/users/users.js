/*****************************
AUTHOR : SALMAN BUKHARI
DATE   : 04/01/2019
DESCRIPTION : UUSER PAGE AJAX
*****************************/

/***********************
USER ROLES TABLE PAGINATION
***********************/
function getUserPage ( page ) 
{
  $.ajax({
    url : base_url + "get/user/page/" + page,
    method : "GET",
    dataType : "JSON",
    beforeSend : function() {
      $('.user-table').css({ 
        "opacity" : "0.6" 
      });

    },
    success : function (data) 
    {
      // console.log( data )
      $(".userList").html(data.UserList);

      $(".userPaginationLink").html(data.UserPaginationLink);
    }
  });
}

getUserPage(1)

$(document).on('click', '.pagination li a', function (e) {

  e.preventDefault();

  var page = $(this).data('ci-pagination-page');

  // console.log( page );
  getUserPage(page);
}); // End of User Roles Pagination Display


/*********************************
END OF USER ROLES TABLE PAGINATION
*********************************/
/*************************************************
GET THE VALUE FOR EDIT USER ROLES FORM (USER PAGE)
*************************************************/
$(document).on('click', '.update-btn', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value;

  let data = {
    'userId' : id
  }

  $.ajax({
    url  : base_url + "user/get/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {
      	// SET USER ID
        $('#updateUserId').val( data.userData.USER_ID)

        // SET FULL NAME
        $('#updateFullName').val( data.userData.FULL_NAME)

        // USER EMAIL ADDRESS
        $('#updateEmail').val( data.userData.EMAIL_ADDRESS)

        // USER ROLE
		$('#updateRole').val( data.userData.U_ROLE_ID)

		// USER STATUS
		$('#updateStatus').val( data.userData.IS_ACTIVE)
      }
      else
      {
        data.message
      }
    }
  })
})

/*******************************
CHECK USERNAME EXISTANCE (USER PAGE)
*******************************/
$('.email').on('keyup', function () {
	$('.status').hide()

	$('.status').removeClass('danger-notification')

	$('.status').removeClass('success-notification')
})

$('.email').on('change', function (e) {
	e.preventDefault()

	let data = {
		'select'			: '`USER_ID`, `FULL_NAME`, `EMAIL_ADDRESS`',
		'table'				: 'users',
		'attribute_name'	: '`EMAIL_ADDRESS`',
		'attribute_value' 	: $(this).val()
	}

	$.ajax({
		url : base_url + 'check/data',
		data : JSON.stringify(data),
		method : 'POST',
		success : function ( res ) 
		{
			if ( res.code == 200 ) 
			{
				$('.status').html(res.message).show()

				$('.status').addClass('success-notification')

				$('.status').removeClass('danger-notification')
			}
			else
			{
				$('.status').removeClass('success-notification')

				$('.status').addClass('danger-notification')

				$('.status').html(res.message).show()
			}
		}
	})
})

/*******************************
END CHECK USERNAME EXISTANCE (USER PAGE)
*******************************/

/*******************************
CHECK PASSWORD MATCH (USER PAGE)
*******************************/
$('.updatePassword').on('keyup', function () {
	$('.status').hide()

	$('.status').removeClass('danger-notification')

	$('.status').removeClass('success-notification')
})

/**************************************
CHECK PASSWORD NOTIFICATION (USER PAGE)
**************************************/
$('.updateRetypePassword').on('change', function () {

	let password = $('.updatePassword').val()

	let retypePassword = $('.updateRetypePassword').val()

	if ( password == retypePassword ) 
	{
		$('.status').html('Password matched!').show()

		$('.status').addClass('success-notification')

		$('.status').removeClass('danger-notification')
	}
	else
	{
		$('.status').addClass('danger-notification')
		
		$('.status').removeClass('success-notification')

		$('.status').html('Password not matched!').show()
	}
})
/******************************************
END CHECK PASSWORD NOTIFICATION (USER PAGE)
******************************************/

$('#update-user-form').on('submit', function (e) {
	e.preventDefault()

	$('.status').hide()

	$('.status').removeClass('danger-notification')

	$('.status').removeClass('success-notification')

	let page = $('.active').children().html() 

	let password = $('#updatePassword').val()

	let retypePassword = $('#updateRetypePassword').val()

	if ( typeof page === "undefined" ) 
	{
		page = 1
	}
  
	let data = {
		'userId'		 : $('#updateUserId').val(),
		'fullname' 		 : $('#updateFullName').val(),
		'password' 		 : password,
		'retypePassword' : retypePassword,
		'email' 		 : $('#updateEmail').val(),
		'role'			 : $('#updateRole').val(),
		'status'		 : $('#updateStatus').val()
	}

	$.ajax({
		url  : base_url + "user/update",
		data : JSON.stringify(data),
		method : 'POST',
		success : function ( data ) 
		{
			$('.user-table').load(base_url + "get/user/page/" + page, function (res) {
		      
		      let userData = JSON.parse( res )

		      // console.log( data )
		      $(".userList").html(userData.UserList);

		      $(".userPaginationLink").html(userData.UserPaginationLink);

		    }) // refresh Country table after entry

		  	if ( data.code == 200 ) 
		  	{
		  		$('#update-user-form')[0].reset() 

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
END OF EDIT BUTTON (USER PAGE)
********************************/

$(function (){
	$('#add-user-form').on('submit', function (e){
		e.preventDefault();

		$('.status').hide()

		$('.status').removeClass('danger-notification')

		$('.status').removeClass('success-notification')

		let page = $('.active').children().html() 
  
		if ( typeof page === "undefined" ) 
		{
			page = 1
		}

		var formData = $( this ).serialize();

		$.ajax({
			url  : base_url + "user/add",
			data : formData,
			method : 'POST',
			success : function (res) {
				let data = JSON.parse(res);
				
				$('.user-table').load(base_url + "get/user/page/" + page, function (res) {
		      
			      let userData = JSON.parse( res )

			      // console.log( data )
			      $(".userList").html(userData.UserList);

			      $(".userPaginationLink").html(userData.UserPaginationLink);

			    }) // refresh Country table after entry

				if ( data.code == 200 )
				{
					// $(this).reset();
					$('#add-user-form')[0].reset() 

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
		});
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

  let userData = {
    'userId' : id
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
        'url' : base_url + 'user/delete',
        'data' : JSON.stringify( userData ),
        'method' : 'POST',
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)

        $('.user-table').load(base_url + "get/user/page/" + page, function (res) {
		      
			let userData = JSON.parse( res )

			// console.log( data )
			$(".userList").html(userData.UserList);

			$(".userPaginationLink").html(userData.UserPaginationLink);

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