// check email validation
$('.email').on('keyup', function () {
  // alert('ok');
  $('.status').hide()

  $('.status').removeClass('danger-notification')

  $('.status').removeClass('success-notification')
})

$('.email').on('change', function (e) {
  e.preventDefault()
  // alert('ok');

  let data = {
    'select'      : '`CLIENT_ID`, `CLIENT_NAME`, `CLIENT_EMAIL`, `CLIENT_MOBILE`',
    'table'       : 'client',
    'attribute_name'  : '`CLIENT_EMAIL`',
    'attribute_value'   : $(this).val()
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























// client page pagination start here

$(document).ready(function(){
    function getClientPage ( page ) 
        {
          $.ajax({
            url : base_url + "get/client/page/" + page,
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
              $(".clientList").html(data.ClientList);

              $(".ClientPaginationLink").html(data.ClientPaginationLink);
            }
          });
        }

        getClientPage(1)

        $(document).on('click', '.pagination li a', function (e) {

          e.preventDefault();

          var page = $(this).data('ci-pagination-page');

          getClientPage(page);
        });
})

// end here



// adding client form start here
$(function (){
  $('#add-Client-form').on('submit', function (e){
    // alert('khan');
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
      url  : base_url + "client/add",
      data : formData,
      method : 'POST',
      success : function (res) {
        let data = JSON.parse( res )
         $('.user-table').load(base_url + "get/client/page/" + page, function (res) {
              
        let data = JSON.parse( res )

        $(".clientList").html(data.ClientList);

         $(".ClientPaginationLink").html(data.ClientPaginationLink);
           
              

            })

    
        
       // refresh Country table after entry

        if ( data.code == 200 )
        {
          // $(this).reset();
          $('#add-Client-form')[0].reset() 

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
// end here



// to get data in model for updating start here





// geeting data in model end here

// update client record start here
$(function() {
   $('#update-Client').on('submit',function(e) {
       e.preventDefault();
       // alert('khan');
  let page = $('.active').children().html() 
       
       if ( typeof page === "undefined" ) 
    {
        page = 1
    }

       let data = {
        'client_id' : $('#client_id').val(),
        'full_name' : $('#client-name').val(),
        'email'     : $('#client-email').val(),
        'mobile'    : $('#client-mobile').val(),
        'country'   : $('#updateCountry').val(),
        'state'     : $('#updateState').val(),
        'city'      : $('#updateCity').val(),
        'code'      : $('#ZIP_CODE').val(),
        'cnic'      : $('#CNIC').val(),
        'address'   : $('#ADDRESS').val()
        }
    $.ajax({
        url : base_url + "client/update",
        method:'POST',
        data : JSON.stringify(data),
        success : function ( data ) {
         $('.user-table').load(base_url + "get/client/page/" + page, function (res) {
              
            let data = JSON.parse( res )

            $(".clientList").html(data.ClientList);

            $(".ClientPaginationLink").html(data.ClientPaginationLink);

            })

            if ( data.code == 200 ) 
                {
                    $('#update-Client')[0].reset() 

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
})

// end here



// to delete a record from client list start here


$(document).on('click', '.delete-btn', function (e) {
  e.preventDefault()


  let id = $(this).children()[1].value;

  let page = $('.active').children().html() 

  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }

  let userData = {
    'userId' : id
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
      // return 
      $.ajax({
        'url' : base_url + 'client/delete',
        'data' : JSON.stringify( userData ),
        'method' : 'POST',
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)
            $('.user-table').load(base_url + "get/client/page/" + page, function (res) {
              
                let data = JSON.parse( res )

                $(".clientList").html(data.ClientList);

                $(".ClientPaginationLink").html(data.ClientPaginationLink);

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
// end here


// OPTION SETTING 
$(function () {
  $('.countrySearch').select2({
    width: '100%',
    placeholder: 'Select Country',
  })

  $('.stateSearch').select2({
    placeholder: 'Select State',
    width: '100%',
  })

  $('.citySearch').select2({
    placeholder: 'Select City',
    width: '100%',
  })  

  // GET STATE VIA COUNTRY CHANGE EVENT
  $('.recieverCountrySearch').on('change', function ( e ) {

    var id = $(this).val();

    $.ajax({
      url : base_url + "state/get/data/" + id,
      method : "GET",
      dataType : "JSON",
      beforeSend : function() {
        
      },
      success : function (data) 
      {
        $('.recieverStateSearch').empty();

        $('.recieverStateSearch').append('<option><-- Select State --></option>')

        $.each(data.record, function ( index , value ){
          $('.recieverStateSearch').append('<option value="' + value.STATE_ID + '">' + value.STATE + '</option>')
        })
      }
    })
  }) // END OF ON CHANGE COUNTRY EVENT

  // GET CITY VIA STATE CHANGE EVENT
  $('.recieverStateSearch').on('change', function ( e ) {

    var id = $(this).val();

    $.ajax({
      url : base_url + "city/get/data/" + id,
      method : "GET",
      dataType : "JSON",
      beforeSend : function() {
        
      },
      success : function (data) 
      {
        $('.receiverCitySearch').empty();

        $('.receiverCitySearch').append('<option><-- Select City --></option>')

        $.each(data.record, function ( index , value ){
          $('.receiverCitySearch').append('<option value="' + value.CITY_ID + '">' + value.CITY + '</option>')
        })
      }
    })
  }) // END OF ON CHANGE STATE EVENT


  // GET STATE VIA COUNTRY CHANGE EVENT
  $('.senderCountrySearch').on('change', function ( e ) {

    var id = $(this).val();

    $.ajax({
      url : base_url + "state/get/data/" + id,
      method : "GET",
      dataType : "JSON",
      beforeSend : function() {
        
      },
      success : function (data) 
      {
        $('.senderStateSearch').empty();

        $('.senderStateSearch').append('<option><-- Select State --></option>')

        $.each(data.record, function ( index , value ){
          $('.senderStateSearch').append('<option value="' + value.STATE_ID + '">' + value.STATE + '</option>')
        })
      }
    })
  }) // END OF ON CHANGE COUNTRY EVENT

  // GET STATE VIA COUNTRY CHANGE EVENT
  $('.senderStateSearch').on('change', function ( e ) {

    var id = $(this).val();

    $.ajax({
      url : base_url + "city/get/data/" + id,
      method : "GET",
      dataType : "JSON",
      beforeSend : function() {
        
      },
      success : function (data) 
      {
        $('.senderCitySearch').empty();

        $('.senderCitySearch').append('<option><-- Select City --></option>')

        $.each(data.record, function ( index , value ){
          $('.senderCitySearch').append('<option value="' + value.CITY_ID + '">' + value.CITY + '</option>')
        })
      }
    })
  }) // END OF ON CHANGE COUNTRY EVENT



  


}) // END OF MAIN DOCUMENT FUNCTION






$(document).on('click', '.client_update', function (e) {
  e.preventDefault()

   let id = $(this).children()[1].value;

  window.productID = id

  let data = {
    'c_id' : id
  }

  $.ajax({
    url  : base_url + "client/get/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {
      

      if ( data.code == 200 ) 
      {
        // SET USER ID
        $('#client_id').val( data.clientData.CLIENT_ID)

        // SET FULL NAME
        $('#client-name').val( data.clientData.CLIENT_NAME)

        // USER EMAIL ADDRESS
        $('#client-email').val( data.clientData.CLIENT_EMAIL)

        // USER ROLE
        $('#client-mobile').val( data.clientData.CLIENT_MOBILE)
        // `ADDRESS`, `ZIP_CODE`, `COUNTRY_ID`, `STATE_ID`, `CITY_ID`, `CNIC`
        $('#ADDRESS').val( data.clientData.ADDRESS)
        $('#ZIP_CODE').val( data.clientData.ZIP_CODE)
        $('#updateCountry').val( data.clientData.COUNTRY_ID)
        $('#updateState').val( data.clientData.STATE_ID)
        $('#updateCity').val( data.clientData.CITY_ID)





         if ( data.clientData.COUNTRY_ID )
        {
          $('#updateCountry').val(data.clientData.COUNTRY_ID)

          $('#updateCountry').trigger('change')
        }
        else


        {
          $('#updateState').empty()
          $('#updateCity').empty()
        }
        $('#CNIC').val( data.clientData.CNIC)


        
      }
      else
      {
        data.message
      }
    }
  });
});


/*********************************************
  UPDATE SECTION EVENTS FOR COUNTRY, STATE, CITY
  *********************************************/
  $(function(){
    $('#updateCountry').on('change', function( e ){

      var id = $(this).val();

      // alert(id);

    var clientData = {
        c_id : window.productID
      }



      
      $.ajax({
        url : base_url + "client/state/get/data/" + id + '/' + window.productID,
        method : "GET",
        dataType : "JSON",
        success : function (data) 
        {
          // console.log(data)
          $('#updateState').empty();
          
          $('#updateState').append('<option>Select State</option>')

          if ( data.record )
          {
            $.each(data.record, function ( index , value ){
              if ( value.STATE_ID == data.productRecord[0].STATE_ID )
              {
                $('#updateState').append('<option value="' + value.STATE_ID + '" selected="selected" >' + value.STATE + '</option>')
              }
              else{
                $('#updateState').append('<option value="' + value.STATE_ID + '">' + value.STATE + '</option>')
              }
            })

            $('#updateState').trigger('change')

          }
        }
      })
  }) // END OF ON CHANGE COUNTRY EVENT

  $('#updateState').on('change', function( e ){

   var id = $(this).val();

      // alert(id);

    var clientData = {
        c_id : window.productID
      }
    
    $.ajax({
      url : base_url + "client/city/get/data/" + id + '/' + window.productID,
      method : "GET",
      dataType : "JSON",
      success : function (data) 
      {

        $('#updateCity').empty();

        $('#updateCity').append('<option>Select City</option>')

        $.each(data.record, function ( index , value ){
          // console.log( value.CITY_ID )
          if ( value.CITY_ID == data.productRecord[0].CITY_ID )
          {
            $('#updateCity').append('<option value="' + value.CITY_ID + '" selected="selected" >' + value.CITY + '</option>')
          }
          else{
            $('#updateCity').append('<option value="' + value.CITY_ID + '">' + value.CITY + '</option>')
          }
          // $('#updateShipperCity').append('<option value="' + value.CITY_ID + '" >' + value.CITY + '</option>')
        })
      }
    })
  }) // END OF ON CHANGE COUNTRY EVENT
})


