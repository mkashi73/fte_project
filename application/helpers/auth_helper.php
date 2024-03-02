<?php
/**
 * Provides authorized access to the system for a user, based on the provided
 * credentials, using a query to the database. If the authorization is
 * successful, a unique JSON Web Token is generated and stored in a cookie.
 * @param  $table - The database table to query.
 * @param $fields - An array of names for the fields to be requested.
 * @param $username_field - The name of the username field.
 * @param $password_field - The name of the password field.
 * @param $t_id - The value of the tenant id field.
 * @param $username_value - The value of the username field.
 * @param $password_value - The value of the password field.
 * @param $service_name - The name of the service.
 * @param $cookie_name - The name of the cookie used to store the authorization
 *  token.
 * @return associative array
 */
function authorize( $t_id, $email_address, $password_value, $service_name, $cookie_name){
  // Load the appropriate helpers
  $ci =& get_instance(); 

  // echo $cookie_name;
  // exit();

  $ci->load->helper('error_code');

  $ci->load->model('login/User_mdl', 'user');

  $condition = array ( 
                        'EMAIL_ADDRESS' => $email_address, 
                        'ENCRYPTED_PWD' => $password_value, 
                        'IS_ACTIVE' => 1 
                     );

  // getData() accepts tablename, condition or 's'
  $result = json_decode ( $ci->user->getData( 'users', $condition ) );

  // echo "<pre>";
  // echo $result;
  // exit();

  if( isset( $result->error ) )
    return array(
      "code" => BAD_CREDENTIALS,
      "message"=>"Invalid Username or password"
    );

  if( $password_value ==  $result->data[0]->ENCRYPTED_PWD )
  {

    generate_jwt_cookie( 
                          $t_id,
                          $result->data[0]->FULL_NAME, 
                          $result->data[0]->USER_ID,  
                          $result->data[0]->U_ROLE_ID,
                          $result->data[0]->STATION_NAME,                          
                          $service_name, 
                          $cookie_name 
                        );
    unset($result->data[0]->ENCRYPTED_PWD);
    return array(
      "id"      =>  $result->data[0]->USER_ID,
      "code"    =>  SUCCESS,
      "message" =>  "User logged in successfully"
    );
  }
  else
    return array(
      "code" => BAD_CREDENTIALS,
      "message"=>"Invalid Password"
    );
}

/**
 * Generates a unique JSON Web Token from the values provided.
 * @param $username_value - The user's unique username.
 * @param $id_value - The user's unique id.
 * @param $service_name - The name of the service.
 * @param $cookie_name - The name of the cookie used to store the authorization
 *  token.
 * @return void
 */
function generate_jwt_cookie( $t_id, $fullname_value, $id_value, $role_id, $station_name, $service_name, $cookie_name)
{
  $secret = "UhT0MaDpVrUgGnPkP7dTEkBfEU2DUbob";

  // echo $cookie_name;
  // exit();

  $timestamp = date_timestamp_get(date_create());
  mt_srand(intval(substr($timestamp,-16,12)/substr(join(array_map(function ($n) { return sprintf('%03d', $n); }, unpack('C*', $secret))),0,2)));
  $stamp_validator = mt_rand();

  $token = array(
    "iat"         => $timestamp,
    "chk"         => $stamp_validator,
    "id"          => $id_value,
    "full_name"   => $fullname_value,
    "role_id"     => $role_id,
    "station_name"  => $station_name,
    "iss"         => $service_name,
    "t_id"        => $t_id
  );

  $cookie = array (
    "id" => $id_value,
    "token" => jwt_encode($token, $secret)
  );

  $time = 0;
  // Change the first NULL below to set a domain, change the second NULL below
    // to make this only transmit over HTTPS
    setcookie($cookie_name, json_encode($cookie), $time, "/", NULL, NULL, true );
}

/**
 * Regenerates a unique JSON Web Token from the values provided. Will return a
 * message if no existing cookie is found.
 * @param $service_name - The name of the service.
 * @param $cookie_name - The name of the cookie used to store the authorization
 *  token.
 * @return associative array
 */
function regenerate_jwt_cookie($service_name, $cookie_name){
  // Load the appropriate helpers
  $ci =& get_instance(); 
  $ci->load->helper('jwt'); 
  $ci->load->helper('error_code');

  $secret = "UhT0MaDpVrUgGnPkP7dTEkBfEU2DUbob";

  if(!isset($_COOKIE[$cookie_name]))
    return array(
      "code" => NO_COOKIE,
      "message" => "Token not found."
    );

  $cookie_contents = json_decode($_COOKIE[$cookie_name], true);
  $token = (array)jwt_decode($cookie_contents["token"], $secret);

  generate_jwt_cookie($token["t_id"], $token["full_name"], $token["id"], $token['role_id'], $token["station_name"], $service_name, $cookie_name );
  return array(
    "code" => SUCCESS,
    "message" => "Token regenerated successfully."
  );
}

/**
 * Checks the validity of a unique JSON Web Token.
 * @param $service_name - The name of the service.
 * @param $cookie_name - The name of the cookie used to store the authorization
 *  token.
 * @return true if the cookie is found and the JWT is valid, false otherwise
 */
function check_jwt_cookie($service_name, $cookie_name){
  // Load the appropriate helpers
  $ci =& get_instance(); 

  $ci->load->helper('jwt');
  // $secret = parse_ini_file(__DIR__.'/../../config.ini')["secret"];
  $secret = "UhT0MaDpVrUgGnPkP7dTEkBfEU2DUbob";

  if(!isset($_COOKIE[$cookie_name]))
    return false;

  $cookie_contents = json_decode($_COOKIE[$cookie_name], true);
  $token = (array)jwt_decode($cookie_contents["token"], $secret);

  if($token["iss"] != $service_name)
    return false;

  if($token["id"] != $cookie_contents["id"])
    return false;

  mt_srand(intval(substr($token["iat"],-16,12)/substr(join(array_map(function ($n) { return sprintf('%03d', $n); }, unpack('C*', $secret))),0,2)));
  $stamp_validator = mt_rand();
  if($stamp_validator != $token["chk"])
    return false;

  return true;
}

/**
 * Gets the data stored in a unique JSON Web Token.
 * @param $cookie_name - The name of the cookie used to store the authorization
 *  token.
 * @return associative array
 */
function get_jwt_data($cookie_name){
  // Load the appropriate helpers
  $ci =& get_instance(); $ci->load->helper('jwt'); $ci->load->helper('error_code');
  // $secret = parse_ini_file(__DIR__.'/../../config.ini')["secret"];
  $secret = "UhT0MaDpVrUgGnPkP7dTEkBfEU2DUbob";
  if(!isset($_COOKIE[$cookie_name]))
    return array(
      "code" => NO_COOKIE,
      "message" => "Token not found."
    );

  $cookie_contents = json_decode($_COOKIE[$cookie_name], true);
  return (array)jwt_decode($cookie_contents["token"], $secret);
}
?>
