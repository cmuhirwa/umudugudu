<?php
include 'db.php';
$sql = $db->query("SELECT * FROM levels GROUP BY category");
while($row = mysqli_fetch_array($sql))
	{ 
		echo'<select>';
		echo'<option></option>';	
		$category = $row['category'];
		$sql2 = $db->query("SELECT * FROM levels WHERE category = '$category'");
		while($row2 = mysqli_fetch_array($sql2))
			{	
				echo'<option>'.$row2['name'].'</option>';
			}
		echo'</select></br>';
	}
echo'<button>Save</button>';
?>