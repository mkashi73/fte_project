

$(document).on('click', '.cnClipReport', (e) => {
  // e.preventDefault()

  // var productId = e.target.dataset.pid

  // console.log( e.target.dataset.pid )

  // let page = $('.active').children().html() 
  
  // if ( typeof page === "undefined" ) 
  // {
  //   page = 1
  // }

  // $.ajax({
  //   'url' : base_url + 'get/product/page/' + page,
  //   'data' : $(this).serializeArray(),
  //   'method' : 'POST',
  //   success : function ( res ) {
  //     let data = JSON.parse( res )

  //     $(".productList").html(data.ProductList)
  //     $(".productPaginationLink").html(data.ProductPaginationLink)
  //   }
  // })
  
  
})



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

// for clients select2
  $('.clientSearch').select2({
    placeholder: 'Select Client',
    width: '100%',
  })  


  $('.clientSearch').on('change', function(e) {
    var id = $(this).val();
    // alert(id);
     window.productID = id

    let data = {
      'c_id' : id
    }

      $.ajax({
        url : base_url + "auto/get/client/" + id,
        method : "GET",
        dataType : "JSON",
        beforeSend : function() {
          
        },
        success : function (data) 
        {
          
          // CONSIGNEE PHONE NUMBER
          if ( data.code == 200 ) {

              $('#C_NAME').val(data.record.CLIENT_NAME)
              $('#C_EMAIL').val(data.record.CLIENT_EMAIL)
              $('#C_MOBILE').val(data.record.CLIENT_MOBILE)
              $('#C_ADDRESS').val(data.record.ADDRESS)
              $('#C_CNIC').val(data.record.CNIC)
              $('#C_CODE').val(data.record.ZIP_CODE)
              // $('#C_COUNTRY').val(data.record.COUNTRY_ID)
              // $('#C_CITY').val(data.record.CITY_ID)
              // $('#C_STATE').val(data.record.STATE_ID)
          if ( data.record.COUNTRY_ID)
          {
            $('#GetCountry').val(data.record.COUNTRY_ID)

            $('#GetCountry').trigger('change')
          }
          else
          {
            $('#GetState').empty()
            $('#GetCity').empty()
          }

          }else{
            data.message
          }
        
        }
      })
  })

// $(function(){
    

    $('#GetCountry').on('change', function( e ){

      var id = $(this).val();

      // alert(id);

      // to check client id is empty or not
          let client = $('#select-client').val();
          if (client !='') {


    var record = {
        c_id : window.productID
      }
      
      $.ajax({
        url : base_url + "client/state/get/data/" + id + '/' + window.productID,
        method : "GET",
        dataType : "JSON",
        success : function (data) 
        {
          // console.log(data)
          $('#GetState').empty();
          
          $('#GetState').append('<option>Select State</option>')

          if ( data.record )
          {
            $.each(data.record, function ( index , value ){
              if ( value.STATE_ID == data.productRecord[0].STATE_ID )
              {
                $('#GetState').append('<option value="' + value.STATE_ID + '" selected="selected" >' + value.STATE + '</option>')
              }
              else{
                $('#GetState').append('<option value="' + value.STATE_ID + '">' + value.STATE + '</option>')
              }
            })

            $('#GetState').trigger('change')

          }
        }

      })
    }
      }) // END OF ON CHANGE COUNTRY EVENT


      $('#GetState').on('change', function( e ){

        var id = $(this).val();

          // alert(id);

        var record = {
            c_id : window.productID
          }
          // to check if client id is empty or not
    let client = $('#select-client').val();
    if (client !='') {
        
        $.ajax({
          url : base_url + "client/city/get/data/" + id + '/' + window.productID,
          method : "GET",
          dataType : "JSON",
          success : function (data) 
          {

            $('#GetCity').empty();

            $('#GetCity').append('<option>Select City</option>')

            $.each(data.record, function ( index , value ){
              // console.log( value.CITY_ID )
              if ( value.CITY_ID == data.productRecord[0].CITY_ID )
              {
                $('#GetCity').append('<option value="' + value.CITY_ID + '" selected="selected" >' + value.CITY + '</option>')
              }
              else{
                $('#GetCity').append('<option value="' + value.CITY_ID + '">' + value.CITY + '</option>')
              }
              // $('#updateShipperCity').append('<option value="' + value.CITY_ID + '" >' + value.CITY + '</option>')
            })
          }
        })
      

      }
          // end of checking

      }) // END OF ON CHANGE COUNTRY EVENT

// })




  // GET STATE VIA COUNTRY CHANGE EVENT
  $('.recieverCountrySearch').on('change', function ( e ) {

    var id = $(this).val();
    let client = $('#select-client').val();
    if (client =='') {

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
  }
  }) // END OF ON CHANGE COUNTRY EVENT

  // GET CITY VIA STATE CHANGE EVENT
  $('.recieverStateSearch').on('change', function ( e ) {

    var id = $(this).val();
    let client = $('#select-client').val();
    if (client =='') {
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
     }
  }) // END OF ON CHANGE STATE EVENT


  // GET STATE VIA COUNTRY CHANGE EVENT
  $('.senderCountrySearch').on('change', function ( e ) {

    var id = $(this).val();
    let client = $('#select-client').val();
    
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
/*****************************
AUTHOR : SALMAN BUKHARI
DATE   : 04/01/2019
DESCRIPTION : PRODUCT PAGE AJAX
*****************************/

/***********************
PRODUCT TABLE PAGINATION
***********************/
function getProductPage ( page ) 
{
  $.ajax({
    url : base_url + "get/product/page/" + page,
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
      $(".productList").html(data.ProductList);

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

/****************************************************
FORM VALIDATION FOR EXTERNAL/INTERNAL TRACKING NUMBER
*****************************************************/


/************************
ADD BUTTON (PRODUCT PAGE)
************************/

$(document).ready(function () {
    Dropzone.autoDiscover = false;

    var myDropzone = new Dropzone('.productFile', {
    url: base_url + "product/add",                        
    autoProcessQueue : false,
    parallelUploads : 10,
    uploadMultiple : true,
    method : 'POST',
    init: function () {
      var myDropzone = this;

      // Update selector to match your button
      // $(".submitBtn").click(function (e) {
      //   e.preventDefault();
      //   myDropzone.processQueue();
      // });
      // Update selector to match your button
      $("#add-product-form").on('submit', function (e) {
        
        e.preventDefault();
        
        e.stopPropagation();


        // console.log( updateProductFile.getQueuedFiles().length )

        // Disable true submit button after submit
        $('.submitBtn').attr('disabled', true);

        if (myDropzone.getQueuedFiles().length > 0) 
        {
          myDropzone.processQueue();
        }
        else 
        {
          $.ajax({
            'url' : base_url + "product/add",
            'data' : $('#add-product-form').serialize(),
            'method' : 'POST',
            cache: false,
            processData:false,
            success : function ( res ) 
            {
              // console.log(res);
              let data = JSON.parse(res)

              let page = $('.active').children().html() 
        
              if ( typeof page === "undefined" ) 
              {
                page = 1
              }

              if ( data.code == 200 )
              {
                $('#add-product-form')[0].reset()

                // Disable false submit button after submit
                $('.submitBtn').attr('disabled', false);

                myDropzone.removeAllFiles(true)

                $('.product-table').load(base_url + "get/product/page/" + page, function (res) {

                  let productData = JSON.parse( res )

                  $(".productList").html(productData.ProductList)

                  $(".productPaginationLink").html(productData.ProductPaginationLink)

                }) // refresh Product table after entry

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

                myDropzone.removeAllFiles(true)
                
                console.log( data );

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
        }
          // updateProductFile.processQueue();
      });

      this.on('sending', function(file, response, formData) {
        // Append all form inputs to the formData Dropzone will POST
        var data = $('#add-product-form').serializeArray();

        $.each(data, function(key, el) {
          formData.append(el.name, el.value);
        });
      });
      this.on('success', function (res) {
        let page = $('.active').children().html() 
        
        if ( typeof page === "undefined" ) 
        {
          page = 1
        }

        let data = JSON.parse( res.xhr.response )

        if ( data.code == 200 ) 
        {
          $('.product-table').load(base_url + "get/product/page/" + page, function (res) {

            let productData = JSON.parse( res )

            $(".productList").html(productData.ProductList)

            $(".productPaginationLink").html(productData.ProductPaginationLink)

          }) // refresh Product table after entry

          $('#update-product-form')[0].reset()
          
          

          this.removeAllFiles(true)

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
          $('#update-product-form')[0].reset()

          this.removeAllFiles(true)

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
      })
    }
  });
})

/********************************
END OF ADD BUTTON (PRODUCT PAGE)
********************************/

/**************************
EDIT BUTTON (PRODUCT PAGE)
**************************/

/**************************
CANCEL BUTTON (PRODUCT PAGE)
**************************/
$(document).on('click', '.update-cancel-btn', function ( e ) {
  e.preventDefault()

  $('#update-product-modal').modal('hide')

})

/*************************************************
GET THE VALUE FOR EDIT PRODUCT FORM (PRODUCT PAGE)
*************************************************/
$(document).on('click', '.updateProduct', function (e) {
  e.preventDefault()

  let id = $(this).children()[1].value;

  window.productID = id
  // console.log($(this).children())

  let data = {
    'productId' : id
  }

  $.ajax({
    url  : base_url + "get/product/data",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {

      // console.log(data)

      if ( data.code == 200 ) 
      {

        // PRODUCT NAME
        $('#updateProductName').val( data.productData.PRODUCT_NAME)

        // CLUB NUMBER
        $('#updateClubNumber').val( data.productData.CLUB_NUMBER)

        // SHIPPER NAME
        $('#updateShipperName').val(data.productData.SHIPPER_NAME)

        // SHIPPER PHONE
        $('#updateShipperPhone').val(data.productData.SHIPPER_PHONE)

        $('#updateClient').val(data.productData.CLIENT_ID)

        // SHIPPER ADDRESS
        $('#updateShipperAddress').val(data.productData.SHIPPER_ADDRESS)

        // SHIPPER EMAIL ADDRESS
        $('#updateShipperEmailAddress').val(data.productData.SHIPPER_E_ADDRESS)

        // SHIPPER ZIP CODE
        $('#updateShipperZipcode').val(data.productData.SHIPPER_ZIP_CODE)

        /***************************updateClient
        SHIPPER COUNTRY, STATE, CITY 
        ***************************/
        // SHIPPER COUNTRY ID
        if ( data.productData.SHIPPER_COUNTRY_ID )
        {
          $('#updateShipperCountry').val(data.productData.SHIPPER_COUNTRY_ID)

          $('#updateShipperCountry').trigger('change')
        }
        else
        {
          $('#updateShipperState').empty()
          $('#updateShipperCity').empty()
        }

        if ( data.productData.CONSIGNEE_COUNTRY_ID )
        {
          $('#updateConsigneeCountry').val(data.productData.CONSIGNEE_COUNTRY_ID)

          $('#updateConsigneeCountry').trigger('change')
        }
        else
        {
          $('#updateConsigneeState').empty()
          $('#updateConsigneeCity').empty()
        }
        // CONSIGNEE NAME
        $('#updateConsigneeName').val(data.productData.CONSIGNEE_NAME)

        // CONSIGNEE PHONE NUMBER
        $('#updateConsigneePhone').val(data.productData.CONSIGNEE_PHONE_NUMBER)

        // CONSIGNEE ZIP CODE
        $('#updateConsigneeZipcode').val(data.productData.CONSIGNEE_ZIP_CODE)

        /*****************************
        CONSIGNEE COUNTRY, STATE, CITY 
        *****************************/
        // SHIPPER COUNTRY ID
        $('#updateConsigneeCountry').val(data.productData.CONSIGNEE_COUNTRY_ID)

        // SHIPPER STATE ID
        $('#updateConsigneeState').val(data.productData.CONSIGNEE_STATE_ID)

        // SHIPPER CITY ID 
        $('#updateConsigneeCity').val(data.productData.CONSIGNEE_CITY_ID)

        // CONSIGNEE ADDRESS
        $('#updateConsigneeAddress').val(data.productData.CONSIGNEE_ADDRESS)

        // CONSIGNEE EMAIL ADDRESS
        $('#updateConsigneeEmailAddress').val(data.productData.CONSIGNEE_E_ADDRESS)

        // CN NUMBER 
        $('#updateCNNumber').val(data.productData.CN_NUMBER)

        // PRODUCT WEIGHT
        $('#updateProductWeight').val(data.productData.PRODUCT_GROSS_WEIGHT)

        // PRODUCT NET WEIGHT
        $('#updateProductNetWeight').val(data.productData.PRODUCT_NET_WEIGHT)

        // PRODUCT DIMENSION
        $('#updateProductDimension').val(data.productData.PRODUCT_DIMENSION)

        // QUANTITY
        $('#updateNoOfPieces').val(data.productData.QUANTITY)
        
        // DESCRIPTION
        $('#updateDescription').val(data.productData.DESCRIPTION)
        
        // PRODUCT TYPE ID
        $('#updateProductType').val(data.productData.PRODUCT_TYPE_ID)
        
        // EXTERNAL TRACKING NUMBER
        $('#updateExtTrackingno').val(data.productData.EXT_TRACKING_NUMBER)
        
        // TRACKING STATUS
        $('#updateTrackingStatus').val(data.productData.TRACKING_STATUS)
        
        // PRODUCT CONDITION
        $('#updateProductCondition').val(data.productData.PRODUCT_CONDITION_ID)
        
        // PRODUCT STATUS
        $('#updateProductStatus').val(data.productData.PRODUCT_STATUS)
        
        // RECIEVE AMOUNT
        $('#updateRecieveAmount').val(data.productData.CONSIGNEE_AMOUNT)
        
        // BALANCE AMOUNT
        $('#updateBalanceAmount').val(data.productData.BALANCE_AMOUNT)
        
        // PRODUCT ID
        $('.updateProductId').val(data.productData.PRODUCT_ID)

        // MAB NUMBER
        $('#updateMabNumber').val(data.productData.MAB_NUMBER)

        // BAG NUMBER
        $('#updateBagNumber').tagsinput('add', data.productData.BAG_NUMBER)
        
        // FORM E NUMBER
        $('#updateFormE').val(data.productData.FORM_E_NUMBER)
        
        // EORI NUMBER
        $('#updateEoriNumber').val(data.productData.EORI_NUMBER)

        // VAT NUMBER
        $('#updateVatNumber').val(data.productData.VAT_NUMBER)

        // PRODUCT ACTUAL PRICE
        $('#updateProductActualPrice').val(data.productData.PRODUCT_ACTUAL_PRICE)}
      else
      {
        data.message
      }
    }
  })
})

$(document).ready(function (){
    
    

  var updateProductFile = new Dropzone('.updateProductFile', {
    url: base_url + "product/update",                        
  
    autoProcessQueue : false,
  
    parallelUploads : 10,
  
    uploadMultiple : true,
  
    init: function () {
      var updateProductFile = this;

      // Update selector to match your button
      $("#update-product-form").on('submit', function (e) {
        e.preventDefault();
        
        e.stopPropagation();

       	let updateData = {
       		shipperName: $('#updateShipperName').val(),
       		shipperPhone: $('#updateShipperPhone').val(),
       		shipperEmailAddress: $('#updateShipperEmailAddress').val(),
       		shipperCountryId: $('#updateShipperCountry').val(),
       		shipperStateId: $('#updateShipperState').val(),
       		shipperCityId: $('#updateShipperCity').val(),
       		productActualPrice: $('#updateProductActualPrice').val(),
       		shipperaddress: $('#updateShipperAddress').val(),
       		shipperzipcode: $('#updateShipperZipcode').val(),
       		consigneername: $('#updateConsigneeName').val(),
       		consigneephone: $('#updateConsigneePhone').val(),
       		consigneeCountryId: $('#updateConsigneeCountry').val(),
       		consigneeStateId: $('#updateConsigneeState').val(),
       		consigneeCityId: $('#updateConsigneeCity').val(),
       		consigneezipcode: $('#updateConsigneeZipcode').val(),
       		consigneeEmailAddress: $('#updateConsigneeEmailAddress').val(),
       		consigneeaddress: $('#updateConsigneeAddress').val(),
       		productname: $('#updateProductName').val(),
			clubNumber: $('#updateClubNumber').val(),
       		productweight: $('#updateProductWeight').val(),
       		productNetWeight: $('#updateProductNetWeight').val(),
       		productdimension: $('#updateProductDimension').val(),
       		noofpieces: $('#updateNoOfPieces').val(),
       		Description: $('#updateDescription').val(),
			productType: $('#updateProductType').val(),
			exttrackingno: $('#updateExtTrackingno').val(),
			trackingStatus: $('#updateTrackingStatus').val(),
			productCondition: $('#updateProductCondition').val(),
			productStatus: $('#updateProductStatus').val(),
			receivedamount: $('#updateRecieveAmount').val(),
			balanceamount: $('#updateBalanceAmount').val(),
			mabNumber: $('#updateMabNumber').val(),
			bagNumber: $('#updateBagNumber').val(),
			formE: $('#updateFormE').val(),
			eoriNumber: $('#updateEoriNumber').val(),
			vatNumber: $('#updateVatNumber').val(),
			productId: $('#updateProductId').val(),
      cn_number: $('#updateCNNumber').val(),
			client: $('#updateClient').val()

       	}


        let shipperName = $('#updateShipperName').val();

        // console.log(updateData);
        // return false;

        // console.log($('#update-product-form').serialize());
        // return;

        // console.log( updateProductFile.getQueuedFiles().length )

        $('.update-product-btn').attr('disabled', true);

        if (updateProductFile.getQueuedFiles().length > 0) 
        {
          updateProductFile.processQueue();
        }
        else 
        {
          $.ajax({
            'url' : base_url + "product/update",
            'data' : JSON.stringify ( updateData ),
            'method' : 'POST',
            cache: false,
            processData:false,
            success : function ( res ) 
            {
              let page = $('.active').children().html() 
        
              if ( typeof page === "undefined" ) 
              {
                page = 1
              }

              if ( res.code == 200 )
              {
                $('#update-product-form')[0].reset()
                
                $('.update-product-btn').attr('disabled', false);
                
                $('#update-product-modal').modal('hide')
                
                // console.log('deleted')
          
                $("#updateBagNumber").tagsinput('removeAll');

                updateProductFile.removeAllFiles(true)

                $('.product-table').load(base_url + "get/product/page/" + page, function (res) {

                  let productData = JSON.parse( res )

                  $(".productList").html(productData.ProductList)

                  $(".productPaginationLink").html(productData.ProductPaginationLink)

                }) // refresh Product table after entry

                const toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });

                toast({
                  type: 'success',
                  title: res.message
                })
              }
              else
              {

                updateProductFile.removeAllFiles(true)

                const toast = Swal.mixin({
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
            }
          })
        }
          // updateProductFile.processQueue();
      });

      this.on('sending', function(file, response, formData) {
        // Append all form inputs to the formData Dropzone will POST
        var data = $('#update-product-form').serializeArray();

        $.each(data, function(key, el) 
        {
          formData.append(el.name, el.value);
        });

      });

      this.on('success', function (res) {
        let page = $('.active').children().html() 
        
        if ( typeof page === "undefined" ) 
        {
          page = 1
        }

        let data = JSON.parse( res.xhr.response )

        if ( data.code == 200 ) 
        {
          $('.product-table').load(base_url + "get/product/page/" + page, function (res) {

            let productData = JSON.parse( res )

            $(".productList").html(productData.ProductList)

            $(".productPaginationLink").html(productData.ProductPaginationLink)

          }) // refresh Product table after entry

          $('#add-product-form')[0].reset()
          
          $('#update-product-modal').modal('hide')
          
          $('.modal').css("display", "none")

          // $('#').tagsinput('destroy');


          this.removeAllFiles(true)

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
          $('#add-product-form')[0].reset()
    
            
        //   $('#update-product-modal').modal('hide')
          
          $('#update-product-modal').modal('hide')
          this.removeAllFiles(true)
          

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
      })
    }
  });
})

/********************************
END OF EDIT BUTTON (PRODUCT PAGE)
********************************/

/**************************
DELETE BUTTON (PRODUCT PAGE)
**************************/

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

          $('.product-table').load(base_url + "get/product/page/" + page, function (res) {
            
            let productData = JSON.parse( res )

            $(".productList").html(productData.ProductList)

            $(".productPaginationLink").html(productData.ProductPaginationLink)
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


/**************************
SEARCH PRODUCT BY CN NUMBER
**************************/

$(document).on('submit', '#search-product-cn-number', function (e) {
  e.preventDefault()

  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  console.log($(this).serializeArray());
  $.ajax({
    'url' : base_url + 'get/product/page/' + page,
    'data' : $(this).serializeArray(),
    'method' : 'POST',
    beforeSend : function() {
      $('.search-product').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) {
      $('.search-product').html('Search Product')

      let data = JSON.parse( res )

      $(".productList").html(data.ProductList)
      $(".productPaginationLink").html(data.ProductPaginationLink)
    }
  })
})

  /*********************************************
  UPDATE SECTION EVENTS FOR COUNTRY, STATE, CITY
  *********************************************/
  $(function(){
    $('#updateShipperCountry').on('change', function( e ){

      var id = $(this).val();

      var productData = {
        productId : window.productID
      }
      
      $.ajax({
        url : base_url + "state/get/data/" + id + '/' + window.productID,
        method : "GET",
        dataType : "JSON",
        success : function (data) 
        {
          // console.log(data)
          $('#updateShipperState').empty();
          
          $('#updateShipperState').append('<option>Select State</option>')

          if ( data.record )
          {
            $.each(data.record, function ( index , value ){
              if ( value.STATE_ID == data.productRecord[0].SHIPPER_STATE_ID )
              {
                $('#updateShipperState').append('<option value="' + value.STATE_ID + '" selected="selected" >' + value.STATE + '</option>')
              }
              else{
                $('#updateShipperState').append('<option value="' + value.STATE_ID + '">' + value.STATE + '</option>')
              }
            })

            $('#updateShipperState').trigger('change')

          }
        }
      })
    }) // END OF ON CHANGE COUNTRY EVENT

    $('#updateShipperState').on('change', function( e ){

      var id = $(this).val();

      var productData = {
        productId : window.productID
      }
      
      $.ajax({
        url : base_url + "city/get/data/" + id + '/' + window.productID,
        method : "GET",
        dataType : "JSON",
        success : function (data) 
        {

          $('#updateShipperCity').empty();

          $('#updateShipperCity').append('<option>Select City</option>')

          $.each(data.record, function ( index , value ){
            // console.log( value.CITY_ID )
            if ( value.CITY_ID == data.productRecord[0].SHIPPER_CITY_ID )
            {
              $('#updateShipperCity').append('<option value="' + value.CITY_ID + '" selected="selected" >' + value.CITY + '</option>')
            }
            else{
              $('#updateShipperCity').append('<option value="' + value.CITY_ID + '">' + value.CITY + '</option>')
            }
            // $('#updateShipperCity').append('<option value="' + value.CITY_ID + '" >' + value.CITY + '</option>')
          })
        }
      })
    }) // END OF ON CHANGE COUNTRY EVENT

    // CONSIGNEE COUNTRY, STATE, CITY
    $('#updateConsigneeCountry').on('change', function( e ){

      var id = $(this).val();

      var productData = {
        productId : window.productID
      }
      
      $.ajax({
        url : base_url + "state/get/data/" + id + '/' + window.productID,
        method : "GET",
        dataType : "JSON",
        success : function (data) 
        {
          // console.log(data)
          $('#updateConsigneeState').empty();
          
          $('#updateConsigneeState').append('<option>Select State</option>')

          if ( data.record )
          {
            $.each(data.record, function ( index , value ){
              if ( value.STATE_ID == data.productRecord[0].CONSIGNEE_STATE_ID )
              {
                $('#updateConsigneeState').append('<option value="' + value.STATE_ID + '" selected="selected" >' + value.STATE + '</option>')
              }
              else{
                $('#updateConsigneeState').append('<option value="' + value.STATE_ID + '">' + value.STATE + '</option>')
              }
            })

            $('#updateConsigneeState').trigger('change')

          }
        }
      })
    }) // END OF ON CHANGE COUNTRY EVENT

    $('#updateConsigneeState').on('change', function( e ){

      var id = $(this).val();

      var productData = {
        productId : window.productID
      }
      
      $.ajax({
        url : base_url + "city/get/data/" + id + '/' + window.productID,
        method : "GET",
        dataType : "JSON",
        success : function (data) 
        {

          $('#updateConsigneeCity').empty();

          $('#updateConsigneeCity').append('<option>Select City</option>')

          $.each(data.record, function ( index , value ){
            // console.log( value.CITY_ID )
            if ( value.CITY_ID == data.productRecord[0].CONSIGNEE_CITY_ID )
            {
              $('#updateConsigneeCity').append('<option value="' + value.CITY_ID + '" selected="selected" >' + value.CITY + '</option>')
            }
            else{
              $('#updateConsigneeCity').append('<option value="' + value.CITY_ID + '">' + value.CITY + '</option>')
            }
            // $('#updateShipperCity').append('<option value="' + value.CITY_ID + '" >' + value.CITY + '</option>')
          })
        }
      })
    }) // END OF ON CHANGE COUNTRY EVENT
  })
  
  
  
