<?php // Destry session if it hasn't been used for 15 minute.
error_reporting(E_ALL); 
		ini_set('display_errors', 1);
		
session_start();
	$inactive = 900;
    if(isset($_SESSION['timeout']) ) 
	{
		$session_life = time() - $_SESSION['timeout'];
		if($session_life > $inactive)
		{
		header("Location: logout.php"); 
		}
    }
    $_SESSION['timeout'] = time();
	if (!isset($_SESSION["username"])) 
	{
		header("location: login.php"); 
		exit();
	} 
$session_id = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$username = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["username"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
include "db.php"; 
$sql = $db->query("SELECT * FROM users WHERE loginId='$username' AND pwd='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysqli_num_rows($sql); // count the row nums
if ($existCount > 0) { 
	while($row = mysqli_fetch_array($sql)){ 
			 $thisid = $row["id"];
			 $names = $row["names"];
			}
		} 
		else{
		echo "
		
		<br/><br/><br/><h3>Your account has been temporally deactivated</h3>
		<p>Please contact: <br/><em>(+25) 078 484-8236</em><br/><b>muhirwaclement@gmail.com</b></p>		
		Or<p><a href='logout.php'>Click Here to login again</a></p>
		
		";
	    exit();
	}
		
?>
<?php

if(isset($_POST['cumpanyUserCode']))
	{
		$levelCode = $_POST['locationId'];
		$role = $_POST['role'];
		$cumpanyUserCode = $_POST['cumpanyUserCode'];
		include ("db.php");
		$sqlcpn = $db->query("INSERT INTO company (levelCode, role, cumpanyUserCode) 
		VALUES ('$levelCode', '$role', '$cumpanyUserCode')")or die (mysqli_error());
		echo '<a href="user.php">Done click here</a>';
		//header("location: user.php"); 
		exit();
	}
?>
<?php
if (isset($_GET['comp'])) {
?>
 <div id="page_content">
        <div id="page_content_inner">
			<h3 class="heading_b uk-margin-bottom">Join a Company</h3>
			<div class="uk-grid uk-grid-medium" data-uk-grid-margin="">
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10 uk-row-first">
                    <div class="md-card">
                        <div class="md-card-toolbar">
                            <h3 class="md-card-toolbar-heading-text" >
                                Company
                            </h3>
                        </div>
                        <div class="md-card-content">
							<form method="post" action="createCompany.php" enctype="multipart/form-data" class="form-group">
								Select A company:<br/>
								<input type="text" name="cumpanyUserCode" value="<?php echo $thisid;?>" hidden/>
								<div id="locations">
								<select name="locationId" id="locationId" onchange="changelocation()">
									<option value="1">Select</option>
									<option value="1">Rwanda</option>
								</select>
								</div>
								</br>
								Role:<br/>
								<input type="text" name="role" /><br/><br/>
								
								<input type="submit" value="Join" class="md-btn md-btn-success md-btn-wave-light waves-effect waves-button waves-light" name="Signup"/>
							</form>	
						</div>
                    </div>
                </div>
			</div>				 
        </div>
    </div>
<?php
	}
?>
<script type="text/javascript">
	function changelocation() {
		var locationId = document.getElementById('locationId').value;
		//alert(locationId);
		$.ajax({
			type : "GET",
			url : "selectLocation.php",
			dataType : "html",
			cache : "false",
			data : {
				locationId : locationId,
			},
			success : function(html, textStatus){
				$("#locations").html(html);
			},
			error : function(xht, textStatus, errorThrown){
				alert("Error : " + errorThrown);
			}
		});
	}
</script>


