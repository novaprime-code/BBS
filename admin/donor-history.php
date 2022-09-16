<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['hidden']))
	{

		
   }}

   function get_donor_list(){
    global $dbh;
    $sql = "SELECT * FROM tblblooddonars limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $donors = $stmt->fetchAll();
    $stmt->closeCursor();
    return $donors;

}

   ?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">

	<title>BDMS | History </title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	<style>
		.errorWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #fff;
			border-left: 4px solid #dd3d36;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		}

		.succWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #fff;
			border-left: 4px solid #5cb85c;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		}
	</style>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Donors History</h2>


						<div class="panel panel-default">
							<div class="panel-heading">Donors Info</div>
							<div class="panel-body">
								<?php if($error){?><div class="errorWrap">
									<strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>


								<table id="zctb" class="display table table-striped table-bordered table-hover"
									cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Name</th>
											<th>Mobile No</th>
											<th>Email</th>
											<th>Age</th>
											<th>Gender</th>
											<th>Blood Group</th>
											<th>address</th>
											<th>Date </th>


											<th>action </th>

										</tr>
									</thead>
									<tbody>


										<?php $sql = "SELECT * from  tblblooddonars ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

//Algorithms start  Regular volunteering Donors

// 		$datetime1 = date_create('2016-06-01');
//   $datetime2 = date_create('2018-09-21');
 
//   // Calculates the difference between DateTime objects
//   $interval = date_diff($datetime1, $datetime2);


// // for ($i=0; $i <=10; $i++) { 
// // 	//  10  times donors  can

// // }
//   if ($interval>=3) {// 3 month  donors   can
   	 
//    	 echo "eligible  for   blood donation";

//    } 

//    else{

//    	echo"Not  eligible for blood donation";
//    	}
if($query->rowCount() > 0){
foreach($results as $result){				?>
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->FullName);?></td>
											<td><?php echo htmlentities($result->MobileNumber);?></td>
											<td><?php echo htmlentities($result->EmailId);?></td>
											<td><?php echo htmlentities($result->Gender);?></td>
											<td><?php echo htmlentities($result->Age);?></td>
											<td><?php echo htmlentities($result->BloodGroup);?></td>
											<td><?php echo htmlentities($result->Address);?></td>
											<td><?php echo htmlentities($result->PostingDate);?></td>





											<td>


											<td>
												<?php if(DonorEligibilityCheck($result->id)==1)
{?>
												<a href="donor-list.php?public=<?php echo htmlentities($result->id);?>"
													onclick="return confirm('Do you really want to eligible this detail')"
													class="btn btn-primary"> Eligible</a>

												<?php }else{ ?>
												<a href="donor-history.php?hidden=<?php echo htmlentities($result->id);?>"
													onclick="return confirm('Do you really want to  not eligible this detail')"
													class="btn btn-primary">Not Eligible</a>

												<?php } ?>
												<a href="donor-list.php?del=<?php echo htmlentities($result->id);?>"
													onclick="return confirm('Do you really want to delete this record')"
													class="btn btn-danger" style="margin-top:1%;"> Delete</a>
											</td>

										</tr>
										<?php $cnt=$cnt+1; }} ?>

									</tbody>
								</table>



							</div>
						</div>



					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
<?php  ?>