$(function(){
    /*
    * AUTHOR       : SALMAN BUKHARI
    * DESCRIPTION  : LOGIN CREDENDIALS
    * DATE         : 04/06/2018
    */
    // AJAX URL
    urls = base_url + "login/check";

    $('#login-form').on( 'submit' , function (e){
      // console.log('Hey you clicked');
      // SET AND RESET LOGIN BUTTON TEXT
      var $this = $('#login-button');
      var loadingText = 'Loading...';
      if ($this.html() !== loadingText)
      {
        // SAVE BUTTON ORIGINAL TEXT
        $this.data('original-text', $this.html());
        // LOAD CHANGED BUTTON TEXT
        $this.html(loadingText);
      }

      // PREVENT BUTTON BEHAVIOUR
      e.preventDefault();
      // var data = $('#login-form').serialize();
      var data =
      {
        "email"  	:  $('#email').val(),
        "password"  :  $("#password").val(),
        "tid"      :  $('#tid').val()
      };

      $.ajax({
        type : 'POST',
        url : urls ,
        data : JSON.stringify(data),
        success : function ( responseText ){
          // alert(JSON.stringify(data1));
          // alert(responseText.code);
          console.log( responseText );
          // 200 OK
          if ( responseText.code == 200 )
          {
            // RESET BUTTON TEXT (2SEC)
            setTimeout(function()
            {
              $this.html($this.data('original-text'));
            }, 2000);

            window.location.href = base_url + 'welcome';
          }
          else if (responseText.code == 403)
          {
            // RESET BUTTON TEXT (2SEC)
            setTimeout(function()
            {
              $this.html($this.data('original-text'));
            }, 2000);

            $('#login-form-error').html(responseText.message);
            // HIDE ALERT ERROR (3SEC)

            $("#email").keypress(function () {
              $('#login-form-error').hide();
            });
            $('#login-form-error').show();
          }
        },
        error : function ( responsetext ) {
          // alert(responsetext.code);
          console.log(responsetext);
          // RESET BUTTON TEXT (2SEC)
            setTimeout(function()
            {
              $this.html($this.data('original-text'));
            }, 2000);
          console.log ('Please check the path');
        }
      });
    });
  });