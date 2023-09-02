// OPTION SETTING 
$(function () {
	$('.countrySearch').select2({
		width: '100%',
		placeholder: 'Select Country',
	})

	$('.stateSearchOption').select2({
		placeholder: 'Select State',
		width: '100%',
	})
})
/*************************
START OF COUNTRY OPERATION
*************************/

// PAGINATION
function getCountryPage ( page ) 
{
	let filters = {
		'countryName' : $('#searchCountryName').val()
	}
	
	$.ajax({
		url : base_url + "get/country/page/" + page,
		method : "POST",
		dataType : "JSON",
		data : JSON.stringify(filters),
		beforeSend : function() {
			$('.country-table').css({ 
				"opacity" : "0.6" 
			});

		},
		success : function (data) 
		{
			// console.log( data )
			$(".CountryList").html(data.CountryList);

			$(".countryPaginationLink").html(data.countryPaginationLink);
		}
	});
}

getCountryPage(1)

$(document).on('click', '.country-pagination li a', function (e) {

	e.preventDefault();

	var page = $(this).data('ci-pagination-page');

	console.log( page );
	getCountryPage(page);
}); // End of Country Pagination Display

/******************
AJAX CRUD OPERATION
******************/


// ADD COUNTRY
$(function () {
	$('#add-country-form').on('submit', function (e) {
	e.preventDefault();
	
	let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

	$.ajax({
		'url' : base_url + 'add/country',
		'data' : $(this).serializeArray(),
		'method' : 'POST',
		beforeSend : function (){
			$('.add-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
		},
		success : function ( res )
		{
			$('.add-btn').html('Add Country')

			let data = JSON.parse(res);
	    
	        if ( data.code == 200 )
	        {
	    		$('.pagination-table').load(base_url + "get/country/page/" + page, function (res) {
					
					let data = JSON.parse( res )

					$(".CountryList").html(data.CountryList)

					$(".countryPaginationLink").html(data.countryPaginationLink)

				}) // refresh Country table after entry

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
})	
	// End of Country

/*************************************************
GET THE VALUE FOR EDIT COUNTRY FORM (PRODUCT PAGE)
*************************************************/
$(document).on('click', '.edit-btn', function (e) {
  e.preventDefault()

  let countryId = $(this).children()[1].value

  let data = {
    'countryId' : countryId
  }

  $.ajax({
    url  : base_url + "country/get",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (res) {

    	let data = JSON.parse( res )

    	console.log(  )
		if ( data.code == 200 ) 
		{	
			// COUNTRY ID
			$('#countryId').val( data.record.COUNTRY_ID )

			// COUNTRY NAME
			$('#updateCountryName').val( data.record.COUNTRY )
		}
		else
		{
			data.message
		}
    }
  })
})

// UPDATE COUNTRY
$('#update-country-form').on('submit', function (e) {
	e.preventDefault();

	let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

	$.ajax({
		'url' : base_url + 'country/update',
		'data' : $(this).serializeArray(),
		'method' : 'POST',
		beforeSend : function (){
			$('.update-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
		},
		success : function ( res ){
			let data = JSON.parse(res);
        	
			$('.update-btn').html('<i class="fas fa-pencil-alt"></i> Update Country')

        	$('.pagination-table').load( base_url + "get/country/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                $(".CountryList").html(data.CountryList);

				$(".countryPaginationLink").html(data.countryPaginationLink);

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
		} // end of success function
	});
});

// DELETE COUNTRY
$(document).on('click', '.delete-btn', function (e) {
	e.preventDefault();

	let id = $(this).children()[1].value;

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
			
			let page = $('.active').children().html() 

			// return 
			$.ajax({
				'url' : base_url + 'delete/country/' + id,
				'data' : $(this).serializeArray(),
				'method' : 'POST',
				success : function ( res ) 
				{
					$('.pagination-table').load(base_url + "get/country/page/" + page, function (res) {
					
						let data = JSON.parse( res )

						$(".CountryList").html(data.CountryList)

						$(".countryPaginationLink").html(data.countryPaginationLink)

					}) // refresh Country table after entry

					let data = JSON.parse(res);
					
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
	}); // End of Delete Country Ajax call
});

/*************
SEARCH COUNTRY
*************/

$(document).on('submit', '#search-country-form', function (e) {
  e.preventDefault()

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  $.ajax({
    'url' : base_url + "get/country/page/" + page,
    'data' : $(this).serializeArray(),
    'method' : 'POST',
    beforeSend : function() {
      $('.search-btn').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) {
		$('.search-btn').html('Search Country')

		let data = JSON.parse( res )

		$(".CountryList").html(data.CountryList);
		$(".countryPaginationLink").html(data.countryPaginationLink);
    }
  })
})
/***********************
END OF COUNTRY OPERATION
***********************/

/**********************
START OF STATE OPERATION
**********************/

// PAGINATION
function getStatePage ( page ) 
{
	let filters = {
		'stateName' : $('#searchStateName').val()
	}
	
	$.ajax({
		url : base_url + "get/state/page/" + page,
		method : "POST",
		dataType : "JSON",
		data : JSON.stringify(filters),
		beforeSend : function() {
			$('.state-table').css({ 
				"opacity" : "0.6" 
			});

		},
		success : function (data) 
		{
			// console.log( data )
			$(".StateList").html(data.StateList);

			$(".StatePaginationLink").html(data.StatePaginationLink);
		}
	});
}

getStatePage(1)

$(document).on('click', '.state-pagination li a', function (e) {

	e.preventDefault();

	var page = $(this).data('ci-pagination-page');

	// console.log( page );
	getStatePage(page);
}); // End of Country Pagination Display



/*************
SEARCH STATE
*************/
$(document).on('submit', '#search-state-form', function (e) {
  e.preventDefault()

  console.log( $(this).serializeArray() )

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  $.ajax({
    'url' : base_url + "get/state/page/" + page,
    'data' : $(this).serializeArray(),
    'method' : 'POST',
    beforeSend : function() {
      $('.search-state-btn').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) {
		$('.search-state-btn').html('Search State')

		let data = JSON.parse( res )

		$(".StateList").html(data.StateList);

		$(".StatePaginationLink").html(data.StatePaginationLink);
    }
  })
})

// ADD CITY
$(function () {
	$('#add-state-form').on('submit', function (e) {
		e.preventDefault();
		
		let page = $('.active').children().html() 

	    if ( typeof page === "undefined" ) 
	    {
	      page = 1
	    }

		$.ajax({
			'url' : base_url + 'state/add',
			'data' : $(this).serializeArray(),
			'method' : 'POST',
			beforeSend : function (){
				$('.add-state-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
			},
			success : function ( res )
			{
				$('.add-state-btn').html('Add State')

				let data = JSON.parse(res);
		    
		        if ( data.code == 200 )
		        {
		    		$('.state-table').load(base_url + "get/state/page/" + page, function (res) {
						
						let data = JSON.parse( res )

						$(".StateList").html(data.StateList);

						$(".StatePaginationLink").html(data.StatePaginationLink);

					}) // refresh Country table after entry

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
	})	
})



// GET UPDATE CITY VALUES
$(document).on('click', '.edit-state-btn', function (e) {
  	e.preventDefault()

  	let id = $(this).children()[1].value

	let data = {
		'id' : id
	}

	$.ajax({
		url  : base_url + "state/get",
		method : 'POST',
		data : JSON.stringify(data),
		success : function (res) {

			let data = JSON.parse( res )

			console.log( data )

			if ( data.code == 200 ) 
			{	
				// TAKE OPTION WITH SELECTED STATED ID
				var option = $('.countrySearch').find( 'option[value="' + data.record.COUNTRY_ID + '"]' )[0];

				// CHECKS IF OPTION IS NOT UNDEFINED THEN TRIGGER VALUE
				if ( 'undefined' !== typeof option )
				{
					$('.countrySearch').val(data.record.COUNTRY_ID);
					$('.countrySearch').trigger('change');
				}

				// STATE NAME
				$('.updateStateName').val( data.record.STATE )

				// SET CITY ID
				$('.stateId').val( data.record.STATE_ID )
			}
			else
			{
				data.message
			}
		}
	})
})

// UPDATE CITY
$('#update-state-form').on('submit', function (e) {
	e.preventDefault();

	let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

	$.ajax({
		'url' : base_url + 'state/update',
		'data' : $(this).serializeArray(),
		'method' : 'POST',
		beforeSend : function (){
			$('.update-state-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
		},
		success : function ( res ){
			let data = JSON.parse(res);
        	
			$('.update-state-btn').html('<i class="fas fa-pencil-alt"></i> Update State')

        	$('.state-table').load(base_url + "get/state/page/" + page, function (res) {
						
				let data = JSON.parse( res )

				$(".StateList").html(data.StateList);

				$(".StatePaginationLink").html(data.StatePaginationLink);

			}) // refresh City table after entry

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
		} // end of success function
	});
});

// DELETE STATE
$(document).on('click', '.delete-state-btn', function (e) {
	e.preventDefault();

	let id = $(this).children()[1].value;

	let filters = {
		'stateName' : $('#searchStateName').val()
	}

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
			
			let page = $('.active').children().html() 

			// return 
			$.ajax({
				'url' : base_url + 'state/delete/' + id,
				'data' : $(this).serializeArray(),
				'method' : 'POST',
				success : function ( res ) 
				{
					$('.state-table').load(base_url + "get/state/page/" + page, function (res) {
								
						let data = JSON.parse( res )

						$(".StateList").html(data.StateList);

						$(".StatePaginationLink").html(data.StatePaginationLink);

					}) // refresh City table after entry

					let data = JSON.parse(res);
					
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
	}); // End of Delete Country Ajax call
});
/*********************
END OF STATE OPERATION
*********************/

/**********************
START OF CITY OPERATION
**********************/

// PAGINATION
function getCityPage ( page ) 
{
	let filters = {
		'cityName' : $('#searchCityName').val()
	}
	
	$.ajax({
		url : base_url + "get/city/page/" + page,
		method : "POST",
		dataType : "JSON",
		data : JSON.stringify(filters),
		beforeSend : function() {
			$('.city-table').css({ 
				"opacity" : "0.6" 
			});

		},
		success : function (data) 
		{
			// console.log( data )
			$(".CityList").html(data.CityList);

			$(".CityPaginationLink").html(data.CityPaginationLink);
		}
	});
}

getCityPage(1)

$(document).on('click', '.city-pagination li a', function (e) {

	e.preventDefault();

	var page = $(this).data('ci-pagination-page');

	// console.log( page );
	getCityPage(page);
}); // End of Country Pagination Display

/*************
SEARCH CITY
*************/

$(document).on('submit', '#search-city-form', function (e) {
  e.preventDefault()

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  $.ajax({
    'url' : base_url + "get/city/page/" + page,
    'data' : $(this).serializeArray(),
    'method' : 'POST',
    beforeSend : function() {
      $('.search-btn').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) {
		$('.search-btn').html('Search City')

		let data = JSON.parse( res )

		$(".CityList").html(data.CityList);

		$(".CityPaginationLink").html(data.CityPaginationLink);
    }
  })
})

// ADD CITY
$(function () {
	$('#add-city-form').on('submit', function (e) {
		e.preventDefault();
		
		let page = $('.active').children().html() 

	    if ( typeof page === "undefined" ) 
	    {
	      page = 1
	    }

		$.ajax({
			'url' : base_url + 'city/add',
			'data' : $(this).serializeArray(),
			'method' : 'POST',
			beforeSend : function (){
				$('.add-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
			},
			success : function ( res )
			{
				$('.add-btn').html('Add City')

				let data = JSON.parse(res);
		    
		        if ( data.code == 200 )
		        {
		    		$('.city-table').load(base_url + "get/city/page/" + page, function (res) {
						
						let data = JSON.parse( res )

						$(".CityList").html(data.CityList);

						$(".CityPaginationLink").html(data.CityPaginationLink);

					}) // refresh Country table after entry

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
	})	
})

// GET UPDATE CITY VALUES
$(document).on('click', '.edit-city-btn', function (e) {
  	e.preventDefault()

  	let id = $(this).children()[1].value

	let data = {
		'id' : id
	}

	$.ajax({
		url  : base_url + "city/get",
		method : 'POST',
		data : JSON.stringify(data),
		success : function (res) {

			let data = JSON.parse( res )

			console.log( data )

			if ( data.code == 200 ) 
			{	
				// TAKE OPTION WITH SELECTED STATED ID
				var option = $('.stateSearchOption').find( 'option[value="' + data.record.STATE_ID + '"]' )[0];

				// CHECKS IF OPTION IS NOT UNDEFINED THEN TRIGGER VALUE
				if ( 'undefined' !== typeof option )
				{
					$('.stateSearchOption').val(data.record.STATE_ID);
					$('.stateSearchOption').trigger('change');
				}

				// CITY NAME
				$('.updateCityName').val( data.record.CITY )

				// SET CITY ID
				$('.cityId').val( data.record.CITY_ID )
			}
			else
			{
				data.message
			}
		}
	})
})

// UPDATE CITY
$('#update-city-form').on('submit', function (e) {
	e.preventDefault();

	let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

	$.ajax({
		'url' : base_url + 'city/update',
		'data' : $(this).serializeArray(),
		'method' : 'POST',
		beforeSend : function (){
			$('.update-city-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
		},
		success : function ( res ){
			let data = JSON.parse(res);
        	
			$('.update-city-btn').html('<i class="fas fa-pencil-alt"></i> Update City')

        	$('.city-table').load(base_url + "get/city/page/" + page, function (res) {
						
				let data = JSON.parse( res )

				$(".CityList").html(data.CityList);

				$(".CityPaginationLink").html(data.CityPaginationLink);

			}) // refresh City table after entry

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
		} // end of success function
	});
});

// DELETE CITY
$(document).on('click', '.delete-city-btn', function (e) {
	e.preventDefault();

	let id = $(this).children()[1].value;

	let filters = {
		'cityName' : $('#searchCityName').val()
	}

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
			
			let page = $('.active').children().html() 

			// return 
			$.ajax({
				'url' : base_url + 'city/delete/' + id,
				'data' : $(this).serializeArray(),
				'method' : 'POST',
				success : function ( res ) 
				{
					$('.city-table').load(base_url + "get/city/page/" + page, function (res) {
								
						let data = JSON.parse( res )

						$(".CityList").html(data.CityList);

						$(".CityPaginationLink").html(data.CityPaginationLink);

					}) // refresh City table after entry

					let data = JSON.parse(res);
					
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
	}); // End of Delete Country Ajax call
});