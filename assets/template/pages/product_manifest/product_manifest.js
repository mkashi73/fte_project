// $('#generate-product-manifest').on('submit', function (e){

// 	e.preventDefault()

// 	$.ajax({
//     url : base_url + "product/manifest/generate",
//     method : "POST",
//     data : $(this).serializeArray(),
//     beforeSend : function() {
//     	$('.generate-manifest-btn').html('<i class="fa fa-spinner fa-spin"></i> Generating Manifest')
//         $('.generate-manifest-btn').prop('disabled', true )
//     },
//     success : function ( res )
//     {
//     	let data = JSON.parse( res )

//         $('.generate-manifest-btn').html('Generate Manifest')

//         $('.generate-manifest-btn').prop('disabled', false )

//         console.log( data )
//         return

//     	if ( data.code == 200 )
//     	{
//     		// $('.search-product-multiple-btn').trigger('click')

//     		$('.search-product-multiple-data').html(data.ProductMultipleData)

//     		$('.product-multiple-listing').html(data.ProductMultipleListing)

//     		$('.updateCNNumber').val( data.CNNumber.toString() )
//     	}
//     	else
//     	{
// 			$('.search-product-multiple-data').html(
// 										'<div class="alert alert-danger">'
// 										+ data.message +
// 										'</div>'
// 									)
// 			$('.stage-status-update').html('')
// 			$('.product-multiple-listing').html('')
//     	}
//     }
//   });
// })

$(".generate-excel-report").click(function() {
  $("#generate-product-manifest").attr(
    "action",
    base_url + "product/manifest/generate/excel"
  );
});


$(".generate-manifest-btn").click(function() {
  $("#generate-product-manifest").attr(
    "action",
    base_url + "product/manifest/generate"
  );
});
