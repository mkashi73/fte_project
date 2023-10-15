/*****************
Company Pagination
*****************/
function getExpensePage ( page ) 
{
    $.ajax({
        url : base_url + "get/expense/page/" + page,
        method : "GET",
        dataType : "JSON",       
        success : function (data) 
        {
            $(".expenseList").html(data.ExpenseList);
            $(".expensePaginationLink").html(data.ExpensePaginationLink);
        }
    });
}

getExpensePage(1)

$(document).on('click', '.pagination li a', function (e) {

    e.preventDefault();

    var page = $(this).data('ci-pagination-page');

    // console.log( page );
    getExpensePage(page);
}); // End of Country Pagination Display


/************************
ADD BUTTON (PRODUCT PAGE)
************************/
$('#add-expense-form').on('submit', function (e){
    e.preventDefault();

    let page = $('.active').children().html() 

    if ( typeof page === "undefined" ) 
    {
      page = 1
    }

    $.ajax({
        url  : base_url + "expense/add",
        data : $(this).serializeArray(),
        method : 'POST',
        beforeSend : function() {
            $('.add-expense-btn').html('<i class="fa fa-spinner fa-spin"></i> Loading ')
        },
        success : function (res) {
            $('.add-expense-btn').html('<i class="fas fa-pencil-alt"></i> Add Expense')

            let data = JSON.parse(res);
            
            $('.expense-table').load( base_url + "get/expense/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                
                $(".expenseList").html(data.ExpenseList);
                $(".expensePaginationLink").html(data.ExpensePaginationLink);

            }) // refresh Country table after entry
            // console.log( data )

            if ( data.code == 200 ) 
            {
                $('#add-expense-form')[0].reset();
                $('#add-expense-modal').modal('hide');

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
    'expense_id' : id
  }

  $.ajax({
    url  : base_url + "expense/data/get",
    method : 'POST',
    data : JSON.stringify(data),
    success : function (data) {
      if ( data.code == 200 ) 
      {
        $('.updateExpenseAmount').val( data.expenseData.EXPENSE_AMOUNT);
        $('.updateExpenseType').val( data.expenseData.EXPENSE_TYPE);
        $('.updateexpenseId').val( data.expenseData.EXPENSE_ID);
      }
      else
      {
        data.message
      }
    }
  })
})

$('#update-expense-form').on('submit', function (e) {
    e.preventDefault();
    console.log($(this).serializeArray());
    $.ajax({
        'url' : base_url + 'expense/update',
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

            $('.expense-table').load( base_url + "get/expense/page/" + page, function (res) {
      
                let data = JSON.parse( res )

                
                $(".expenseList").html(data.ExpenseList);
                $(".expensePaginationLink").html(data.ExpensePaginationLink);

            }) // refresh Country table after entry

            if ( res.code == 200 ) 
            {
                $('#update-expense-form')[0].reset();
                $('#update-expense-modal').modal('hide');

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
    'expenseId' : id
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
        'url' : base_url + 'expense/delete',
        'data' : JSON.stringify( data ),
        'method' : 'POST',
        cache: false,
        processData:false,
        success : function ( res ) 
        {
          let data = JSON.parse(res);

          // console.log(res)

          $('.expense-table').load(base_url + "get/expense/page/" + page, function (res) {
            
            let data = JSON.parse( res )
            $(".expenseList").html(data.ExpenseList);
            $(".expensePaginationLink").html(data.ExpensePaginationLink);
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


$(document).on('submit', '#search-expense-by-id', function (e) {
  e.preventDefault()
  let page = $('.active').children().html() 
  
  if ( typeof page === "undefined" ) 
  {
    page = 1
  }
  $.ajax({
    'url' : base_url + 'get/expense/page/' + page,
    'data' : $(this).serializeArray(),
    'method' : 'POST',
    beforeSend : function() {
      $('.search-expense').html('<i class="fa fa-spinner fa-spin"></i>Loading')
    },
    success : function ( res ) {
      $('.search-expense').html('Search Expense')

      let data = JSON.parse( res )

      $(".expenseList").html(data.ExpenseList);
      $(".expensePaginationLink").html(data.ExpensePaginationLink);
    }
  })
})


$(".generate-expense-report-btn").click(function() {
  $("#generate-expense-report").attr(
    "action",
    base_url + "expense/report/generate"
  );
});