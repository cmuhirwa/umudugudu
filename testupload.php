<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
include 'db.php';
// EXCEL BULK INVITATIONS
	include ("classes/PHPExcel/IOFactory.php");
	$objPHPExcel = PHPExcel_IOFactory::load('docs/contacts.xls');
	// LOOP BULK CONTACTS: 1.INSERTING NEW, 2.CONNECTING TO THE ACCOUNT, 3.SENDING EMAILS 
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
	{
		$highestRow = $worksheet->getHighestRow();
		for ($row=2; $row<=$highestRow; $row++)
		{
			$names = mysqli_real_escape_string($db, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
			$phone = mysqli_real_escape_string($db, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
			$houseNumber = mysqli_real_escape_string($db, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
		$sql = $db->query("INSERT INTO 
			members 
			(names, phone, houseNumber) 
			VALUES ('$names', '$phone', '$houseNumber');");
		
		}echo "<a href='company.php'>Click here</a>";
	}
?>