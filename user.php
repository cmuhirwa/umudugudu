<?php // Destry session if it hasn't been used for 15 minute.
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
include "db.php"; 
error_reporting(E_ALL); 
		ini_set('display_errors', 1);
			
?>
<?php 
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
			 $account_type = $row["account_type"];
			 if($account_type =='admin')
		{
			header("location: admin.php");
			exit();
		}
			}
		} 
		else{
		echo "
		
		<br/><br/><br/><h3>Your account has been temporally deactivated</h3>
		<p>Please contact: <br/><em>(+25) 0782010262</em><br/><b>uwamclemmy@gmail.com</b></p>		
		Or<p><a href='logout.php'>Click Here to login again</a></p>
		
		";
	    exit();
	}
?>


<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<?php include'userheader.php' ;?>
	<!-- main sidebar -->
<div id="new_comp">
<div id="page_content">
        <div id="page_content_inner">
			<h3 class="heading_b uk-margin-bottom">MANAGE COMPANY</h3>
			<div class="uk-grid uk-grid-medium" data-uk-grid-margin="">
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10 uk-row-first" >
                    <?php 
						$sqlseller = $db->query("SELECT * FROM company WHERE cumpanyUserCode = '$thisid'");
						$countComanies = mysqli_num_rows($sqlseller);
						if($countComanies>0)
							{
								while($row = mysqli_fetch_array($sqlseller)) 
									{
										$levelCode = $row['levelCode'];
										$comanyId = $row['id'];
										$sqlcompName = $db->query("SELECT * FROM levels WHERE id = '$levelCode'");
										while($row2 = mysqli_fetch_array($sqlcompName)) 
											{
												$companyName = $row2['name'];
											}
										echo '
											<a href="company.php?compId='.$comanyId.'">
											<div class="md-card">
					                            <img src="company/'.$levelCode.'.jpg" alt="">
					                            <div class="md-card-content">
					                                <strong>'.$companyName.'</strong><br>
					                                <span class="uk-text-muted">'.$row['role'].'.</span>
					                            </div>
					                        </div>
					                        </a>';
									}
							}
						else
							{
								echo'<a href="javascript:void()" onclick="addcomp()">ADD A COMPANY</a>';
							}
					?>			
				</div>
			</div>				 
        </div>
    </div>
</div>

    <!-- google web fonts -->
    <script>
        WebFontConfig = {
            google: {
                families: [
                    'Source+Code+Pro:400,700:latin',
                    'Roboto:400,300,500,700,400italic:latin'
                ]
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>


    <script>
        $(function() {
            if(isHighDensity()) {
                $.getScript( "bower_components/dense/src/dense.js", function() {
                    // enable hires images
                    altair_helpers.retina_images();
                });
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>
	
<script> <!--0 Add Company-->
function addcomp(){

	var comp = 'yes';
		
	$.ajax({
			type : "GET",
			url : "createCompany.php",
			dataType : "html",
			cache : "false",
			data : {
				
				comp : comp,
			},
			success : function(html, textStatus){
				$("#new_comp").html(html);
			},
			error : function(xht, textStatus, errorThrown){
				alert("Error : " + errorThrown);
			}
	});
}
</script>	
<script> <!--1 Show subcat-->
function get_sub(){
	var catId =$("#catId").val();
	//alert(catId);
	$.ajax({
			type : "GET",
			url : "userscript.php",
			dataType : "html",
			cache : "false",
			data : {
				
				catId : catId,
			},
			success : function(html, textStatus){
				$("#suboption").html(html);
			},
			error : function(xht, textStatus, errorThrown){
				alert("Error : " + errorThrown);
			}
	});
}
</script>
<script> <!--2 Show products-->
function get_prod(){
	var subCatId =$("#subCatId").val();
	//alert(subCatId);
	$.ajax({
			type : "GET",
			url : "userscript.php",
			dataType : "html",
			cache : "false",
			data : {
				
				subCatId : subCatId,
			},
			success : function(html, textStatus){
				$("#prodoption").html(html);
			},
			error : function(xht, textStatus, errorThrown){
				alert("Error : " + errorThrown);
			}
	});
}
</script>
<script> <!--3 start new post-->
function new_post(){
	var productId =$("#productId").val();
	//alert(productId);
	$.ajax({
			type : "GET",
			url : "userscript.php",
			dataType : "html",
			cache : "false",
			data : {
				
				productId : productId,
			},
			success : function(html, textStatus){
				$("#new_post_show").html(html);
			},
			error : function(xht, textStatus, errorThrown){
				alert("Error : " + errorThrown);
			}
	});
}
</script>
</body>
</html>