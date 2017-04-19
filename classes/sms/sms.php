<?php
require_once('AfricasTalkingGateway.php');
$username   = "cmuhirwa";
$apikey     = "17700797afea22a08117262181f93ac84cdcd5e43a268e84b94ac873a4f97404";
$recipients = "+250784848236";
$message    = "I'm a lumberjack and its ok, I sleep all night and I work all day";
$from = "Intwali";

  $gateway    = new AfricasTalkingGateway($username, $apikey);
try 
{
	$results = $gateway->sendMessage($recipients, $message, $from);
	foreach($results as $result) {
    echo " Number: " .$result->number;
    echo " Status: " .$result->status;
    echo " MessageId: " .$result->messageId;
    echo " Cost: "   .$result->cost."\n";
  }
}
catch ( AfricasTalkingGatewayException $e )
{
  echo "Encountered an error while sending: ".$e->getMessage();
}
// DONE!!! 

	
?>
