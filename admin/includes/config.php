<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','bbdms');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}


// function for donar eligiblity
function get_donor_list2($column,$donor_id){
    global $dbh;
$donor_id=(int)$donor_id;
    $sql = "SELECT $column FROM tblblooddonars WHERE id=$donor_id";
    $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':column',$column);
    // $stmt->bindValue(':donor_id',$donor_id);
    $stmt->execute();
    $name = $stmt->fetchColumn();
    $stmt->closeCursor();
    return $name;
}
function DonorEligibilityCheck($donor_id){
	try {
		//date of last posting
		$last_date =(int)strtotime(get_donor_list2('PostingDate',$donor_id)); //called funtion from config.php
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	$new_date = (int)strtotime('now');
	$time_diff=round((abs($new_date-$last_date))/(86400*30),2);
	$status=0;
	if($time_diff>=3.00){
		$status= 1;
	}else{
		$status= 0;
	}
	return $status;
	// return $time_diff;
}




?>
