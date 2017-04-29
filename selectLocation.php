<?php
error_reporting(E_ALL); 
		ini_set('display_errors', 1);

if(isset($_GET['locationId']))
{
	$locationId = $_GET['locationId'];
	include 'db.php';
	//BRING INFO ABOUT THE PASSED
	$sqlinfo = $db->query("SELECT  CHAR_LENGTH(parentId) PassCount, parentId, name, id  FROM levels WHERE id = '$locationId' LIMIT 1");
	while($arrayinfo = mysqli_fetch_array($sqlinfo))
	{
		$passedCheck = $arrayinfo['PassCount'];
		$passedParent = $arrayinfo['parentId'];
		$passedName = $arrayinfo['name'];
		$passedId = $arrayinfo['id'];
	}
	//END BRING INFO
	// CHECK IF THERE IS ANY LEVEL DOWN//
	$sqlcheck = $db->query("SELECT CHAR_LENGTH(parentId) nowCount FROM levels ORDER BY parentId DESC LIMIT 1");
	$arraycheck = mysqli_fetch_array($sqlcheck);
	$lastparent = $arraycheck['nowCount'];
	// END CHECK
	if($lastparent > $passedCheck)
	{	
		$sql = $db->query("SELECT * FROM levels WHERE parentId = '$locationId'");
		echo '<select name="locationId" id="locationId" onchange="changelocation()">
				';
		while($row = mysqli_fetch_array($sql))
			{ 
				echo'<option value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		echo'</select></br>';
	}
	else
	{
		echo'
		<input type="hidden" name="locationId" value="'.$passedId.'">
		<select disabled>
			<option >'.$passedName.'</option>
		</select>';
	}

}
?>