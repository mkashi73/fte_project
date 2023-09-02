

$(function () {
	function getPage ( page ) {
		$.ajax({
			url : base_url + "get/menu/" + page,
			method : "GET",
			dataType : "JSON",
			beforeSend : function() {
				$('table').css({ 
					"opacity" : "0.6" 
				});

			},
			success : function (data) 
			{
				$("#MenuList").html(data.MenuList);
				$("#pagination-link").html(data.pagination_link);
			}
		});
	}

	getPage(1);

	$(document).on('click', '.pagination li a', function (e) {
		e.preventDefault();
		var page = $(this).data('ci-pagination-page');
		getPage(page);
	});

	$('.icp-auto').iconpicker();

	$('.role').select2({ width: '100%' });

	$('#add-menu-form').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			'url' : base_url + 'add/menu',
			'data' : $(this).serializeArray(),
			'method' : 'POST',
			beforeSend : function (){

				$('#addMenuBtn').prop("disabled", true);

	        	$('#addMenuBtn').css("opacity",".5");
			},
			success : function ( res ){
				let data = JSON.parse(res);
	        
	            if ( data.code == 200 )
	            {
	            	$('#addMenuBtn').prop("disabled", false);
				
	        		$('#addMenuBtn').css("opacity","1");
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
	            	$('#addMenuBtn').prop("disabled", false);
				
	        		$('#addMenuBtn').css("opacity","1");

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
});

/**************************
EDIT BUTTON (PRODUCT PAGE)
**************************/

/*************************************************
GET THE VALUE FOR EDIT PRODUCT FORM (PRODUCT PAGE)
*************************************************/
$(document).on('click', '.update-btn', function (e) {
  e.preventDefault()

  let menuId = $(this).children()[1].value

  let roleId = $(this).children()[2].value

  let data = {
    'menuId' : menuId,
    'roleId' : roleId
  }
  // console.log( data )

  // return 

  $.ajax({
    url  : base_url + "menu/get/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      if ( data.code == 200 ) 
      {

      	if ( data.menuData.length > 1 )
      	{
	        // MENU NAME
	        $('.updateMenuName').val( data.menuData[0].MENU_TEXT)

	        // MENU MENU LINK
	        $('.updateMenuLink').val( data.menuData[0].MENU_URL)

	        // MENU ICON
	        $('.updateMenuIcon').val( data.menuData[0].MENU_ICON)

	        // MENU PARENT
	        $('.updateMenuParent').val( data.menuData[0].PARENT_ID)

        	// MENU ROLE
	        let values = new Array()

	        for ( let i = 0; i < data.menuData.length; i++ ) 
	        {
	        	values.push( data.menuData[i].USER_ROLE_ID )
	        }

	        $('.udpateMenuRole').val(values).trigger('change');

	        // MENU ID
	        $('.updateMenuId').val( data.menuData[0].MENU_ID)	
      	}
      	else
      	{
      		// MENU NAME
	        $('.updateMenuName').val( data.menuData[0].MENU_TEXT)

	        // MENU MENU LINK
	        $('.updateMenuLink').val( data.menuData[0].MENU_URL)

	        // MENU ICON
	        $('.updateMenuIcon').val( data.menuData[0].MENU_ICON)

	        // MENU PARENT
	        $('.updateMenuParent').val( data.menuData[0].PARENT_ID)

	        // MENU ROLE
	        $('.udpateMenuRole').val(data.menuData[0].USER_ROLE_ID).trigger('change');

	        // MENU ID
	        $('.updateMenuId').val( data.menuData[0].MENU_ID)	
      	}
      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-menu-form').on('submit', function (e) {
  e.preventDefault()

  let formData = new FormData(this)

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  
  $.ajax({
    url  : base_url + "menu/update",
    data : formData,
    method : 'POST',
    contentType: false,
    cache: false,
    processData:false,
    success : function ( res ) {
    	// console.log(data)

		let data = JSON.parse( res )

      	if ( data.code == 200 ) 
		{
			$('#update-menu-form')[0].reset() 

			$('.pagination-table').load( base_url + "get/menu/" + page, function (res) {

				let menuData = JSON.parse( res )

				// console.log( data )
				$("#MenuList").html(menuData.MenuList);
				$("#pagination-link").html(menuData.pagination_link);

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

  let id = $(this).children()[1].value

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let htmlData = {
    'menuId' : id
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
        'url' : base_url + 'menu/delete',
        'data' : JSON.stringify( htmlData ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          	let data = JSON.parse(res);


			$('.pagination-table').load( base_url + "get/menu/" + page, function (res) {

				let menuData = JSON.parse( res )

				// console.log( data )
				$("#MenuList").html(menuData.MenuList);
				$("#pagination-link").html(menuData.pagination_link);

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