<?php  

/**

*	AUTHOR 	:	SALMAN BUKHARI

*	@return :	$date - Return the Date timeoffsetdate

*	DATE 	: 	04/06/2018

*/

function getDateOffset()

{

	return $date = date("Y-m-d H:i:s");

}

function getDateForDatabase($date) {
    $timestamp = strtotime($date);
    $date_formated = date('Y-m-d', $timestamp);
    return $date_formated;
}


/**

*	AUTHOR 	:	SALMAN BUKHARI

*	@return :	return string

*	Date 	:	20/06/2018

*/



function getStringCast( $string )

{

	return $string = (string) $string;

}

/**

*	AUTHOR 	:	SALMAN BUKHARI

*	@return :	return int

*	Date 	:	20/06/2018

*/

function getIntegerCast( $integer )

{

	return $integer = (int) $integer;

}



/**

*	AUTHOR 	:	SALMAN BUKHARI

*	@param 	$token_name - The name of the token

*	@return $token - Return the token value

*	DATE 	: 	19/06/2018

*/

function getTokenData( $token_name ) 

{

	if ( !empty ($token_name) ) 

	{

		$ci =& get_instance();



		$ci->load->helper('jwt'); 



		$secret = "UhT0MaDpVrUgGnPkP7dTEkBfEU2DUbob";



		$cookie_contents = json_decode($_COOKIE[$token_name], true);



		$token = (array)jwt_decode($cookie_contents[$token_name], $secret);

	}

	else

	{

		$token = '';

	}



	return $token;

}



/**

*	AUTHOR 	:	SALMAN BUKHARI

*	@param 	

*	@return $token - Return the token value

*	DATE 	: 	19/06/2018

*/



function getEncryptedString( $algo, $string ) 

{

	try {

		return hash( $algo, $string );

	} catch (Exception $e) {

		return $e;

	}

}



function super_unique($array)

{

  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));



  foreach ($result as $key => $value)

  {

    if ( is_array($value) )

    {

      $result[$key] = super_unique($value);

    }

  }



  return $result;

}

function debug( $arg, $exit = 1 )
{
	if ( $exit == 1 )
	{
		echo "<pre>";
		print_r($arg);
		echo "</pre>";
		exit();
	} 
	else
	{
		echo "<pre>";
		print_r($arg);
		echo "</pre>";
	}
}