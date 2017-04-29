<?php
if(isset($_GET['sms'])){
require_once('classes/sms/AfricasTalkingGateway.php');
$username   = "cmuhirwa";
$apikey     = "17700797afea22a08117262181f93ac84cdcd5e43a268e84b94ac873a4f97404";


include("db.php");
$sql = $db->query("SELECT `phone` FROM `members`");
$n=0;
$nError =0;
while($row = mysqli_fetch_array($sql))
	{
		$subRecip = $row['phone'];
		$recipients = "+250".$subRecip;
		$message    = $_GET['sms'];
		$from = "INTWARI";
		$gateway    = new AfricasTalkingGateway($username, $apikey);
		try 
		{ 
		  $results = $gateway->sendMessage($recipients, $message,  $from);
					
		  foreach($results as $result) {
			  $n++;
			   echo " Cost: "   .$result->cost."\n";
		  }
		}
		catch ( AfricasTalkingGatewayException $e )
		{
		  echo "Encountered an error while sending: ".$e->getMessage();
		}
	}
	echo 'Success: <b>('.$n.')</b><br/>';
	echo 'Failed: <b>('.$nError.')</b>';
}
?>