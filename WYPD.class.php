<?php
/**
 * Polldaddy API class
 * API Documentation: http://support.polldaddy.com/api/
 * Class Documentation: https://github.com/samanthamichele7/Whos-Your-Polldaddy/
 *
 * Simple PHP API wrapper class to display the latest poll from a Polldaddy account
 * 
 * @author Samantha Geitz
 * @copyright Samantha Geitz - Doejo
 * @version 1.0
 * @license MIT http://opensource.org/licenses/MIT
 */

class WhosYourPolldaddy {

  /**
   * The URL for the Polldaddy API.  Probably shouldn't touch this.
   */

  CONST API_URL = "https://api.polldaddy.com/";

  /**
   * The Polldaddy API Key to be used for all requests
   * 
   * @var string
   */

  private $_apiKey;

  /**
   * Default constructor to pull API key from new object
   *
   * @param $config          Polldaddy configuration data
   * @return void
   */

  public function __construct($config) {
    $this->setApiKey($config);
  }

   /**
   * Set the API key
   * 
   * @param string $apiKey
   * @return void
   */
  public function setApiKey($apiKey) {
    $this->_apikey = $apiKey;
  }

  /**
   * API Key Getter
   * 
   * @return string
   */
  public function getApiKey() {
    return $this->_apikey;
  }

  /**
   * pdAccess Setter -- pdAccess is used to access methods where the Polldaddy usercode is not necessary (namely, to get user code)
   * 
   * @return array
   */

  public function setPdAccess(){
    $apiKey = self::getApiKey();

    $pdAccess = array(
      "pdAccess"     => array(
          "partnerGUID"      => $apiKey,
          "demands"          => array(
            "demand"          => array(
              "id"              => "GetUserCode"
              ))
        )
    );

    return $pdAccess;
  }

  /**
   * pdRequest Setter - pdRequest is used to access the bulk of the API methods and needs a Polldaddy usercode
   * TODO: refactor and expand so that this can be used for more than returning the ID for the latest poll
   *
   * Currently, this will only work with the GetPolls method, but the $pdRequest variable can easily be updated with data
   * for the proper API method
   * 
   * @return array
   */

  public function setPdRequest($request_method){
    $apiKey = self::getApiKey();
    $userCode = self::setUserCode();

    $pdRequest = array(
      "pdRequest"     => array(
          "partnerGUID"      => $apiKey,
          "userCode"         => $userCode,
          "demands"          => array(
            "demand"          => array(
                "list"          => array(
                    "start" => "1",
                    "end"=> "1"
                  ), "id" => $request_method 
              ))
        )

    );

    return $pdRequest;
  }
 
  /**
   * Set JSON request options for pdAccess and pdRequest
   * 
   * @return array
   */

  public function setOptions($type, $request_data = null){

    if($type == "access"){
      $data = self::setPdAccess();
    } elseif($type == "request") {
      $data = $request_data;
    }

    $options = array(
        "http" => array(
          "method"  => "POST",
          "content" => json_encode( $data ),
          "header"=>  "Content-Type: application/json\r\n" .
                      "Accept: application/json\r\n"
          )
     );

    return $options;

  }

  /**
   * Dynamically pull user code from Polldaddy API
   * 
   * @return int
   */

  public function setUserCode(){

    $apiUrl = self::API_URL;
    $pdAccess = self::setPdAccess();
    $options = self::setOptions($type = "access", $request = null );

    $context  = stream_context_create( $options );
    $result = file_get_contents( $apiUrl, false, $context );
    $response = json_decode( $result );

    return $response->pdResponse->userCode;
  }

  /**
   * Get Latest Polldaddy Poll using GetPolls method
   * 
   * @return int
   */

  public function getLatestPoll(){

    $apiUrl = self::API_URL;
    $apiKey = self::getApiKey();
    $userCode = self::setUserCode();
    $request = self::setPdRequest($request_method = "GetPolls");
    $options = self::setOptions($type = "request", $request );

    $context  = stream_context_create( $options );
    $result = file_get_contents( $apiUrl, false, $context );
    $response = json_decode( $result );
  
    return $response->pdResponse->demands->demand[0]->polls->poll[0]->id;

  }

}

?>