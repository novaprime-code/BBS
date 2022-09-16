<?php 
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit']))
  {
    $fullname=$_POST['fullname'];
$mobile=$_POST['mobileno'];
$email=$_POST['emailid'];
$age=$_POST['age'];
$gender=$_POST['gender'];
$blodgroup=$_POST['bloodgroup'];
$address=$_POST['address'];
$message=$_POST['message'];
$status=1;
    $password=md5($_POST['password']);
    $ret="select EmailId from tblblooddonars where EmailId=:email";
    $query= $dbh -> prepare($ret);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() == 0)
{
$sql="INSERT INTO  tblblooddonars(FullName,MobileNumber,EmailId,Age,Gender,BloodGroup,Address,Message,status,Password) VALUES(:fullname,:mobile,:email,:age,:gender,:blodgroup,:address,:message,:status,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fullname',$fullname,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':age',$age,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':blodgroup',$blodgroup,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo "<script>alert('You have signup  Scuccessfully');</script>";
}
else
{

echo "<script>alert('Something went wrong.Please try again');</script>";
}
}
 else
{

echo "<script>alert('Email-id already exist. Please try again');</script>";
}
}
if(isset($_POST['login'])) 
  {
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql ="SELECT id FROM tblblooddonars WHERE EmailId=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['bbdmsdid']=$result->id;
}
$_SESSION['login']=$_POST['email'];
echo "<script type='text/javascript'> document.location ='index.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}
function get_donor_list1($column,$donor_id){
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
		$last_date =(int)strtotime(get_donor_list1('PostingDate',$donor_id)); //called funtion from config.php
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
<?php 
$pagetype="contactus";
$sql = "SELECT * from tblcontactusinfo";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
<!-- //social icons -->
<div class="col-6 header-top_w3layouts pl-3 text-lg-left text-center">
    <p class="text-white">
        <i class="fas fa-map-marker-alt mr-2"></i><?php  echo $result->Address; ?></p>
</div>
</div>
</div>
<div class="col-lg-5 top-social-agile text-lg-right text-center">
    <div class="row">
        <div class="col-lg-7 col-6 top-w3layouts">
            <p class="text-white">
                <i class="far fa-envelope-open mr-2"></i>
                <a href="mailto:info@example.com" class="text-white"><?php  echo $result->EmailId; ?></a>
            </p>
        </div>
        <div class="col-lg-5 col-6 header-w3layouts pl-4 text-lg-left">
            <p class="text-white">
                <i class="fas fa-phone mr-2"></i>+<?php  echo $result->ContactNo; ?></p>
        </div>
    </div><?php } } ?>
</div>
</div>
</div>
</div>
</header>
<!-- //top-bar -->

<!-- header 2 -->
<div id="home">
    <!-- navigation -->
    <div class="main-top py-1">
        <nav class="navbar navbar-expand-lg navbar-light fixed-navi">
            <div class="container">
                <!-- logo -->
                <h1>
                    <a class="navbar-brand font-weight-bold font-italic" href="index.php">
                        <span></span>BDMS
                    </a>
                </h1>
                <!-- //logo -->
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-lg-auto">
                        <li class="nav-item active mt-lg-0 mt-3">
                            <a class="nav-link" href="index.php">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item mx-lg-4 my-lg-0 my-3">
                            <a class="nav-link" href="about.php">About Us</a>
                        </li>
                        <li class="nav-item mx-lg-4 my-lg-0 my-3">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                        </li>
                        <li class="nav-item mx-lg-4 my-lg-0 my-3">
                            <a class="nav-link" href="donor-list.php">Donor List</a>
                        </li>
                        <li class="nav-item mx-lg-4 my-lg-0 my-3">
                            <a class="nav-link" href="search-donor.php">Search Donor</a>
                        </li>

                        <?php if (strlen($_SESSION['bbdmsdid']!=0)) {?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                My Account
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item" href="profile.php">Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="change-password.php">Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="request-received.php">Request Received</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                        <?php } ?>
                        <?php if (strlen($_SESSION['bbdmsdid']==0)) {?>
                        <li class="nav-item mx-lg-4 my-lg-0 my-3">
                            <a class="nav-link" href="admin/index.php">Admin</a>
                        </li>
                    </ul>
                    <!-- login -->
                    <a href="#" class="login-button ml-lg-5 mt-lg-0 mt-4 mb-lg-0 mb-3" data-toggle="modal"
                        data-target="#exampleModalCenter1">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login</a><?php } ?>
                    <!-- //login -->
                </div>
            </div>
        </nav>
    </div>
    <!-- //navigation -->
    <!-- modal -->
    <!-- login -->
    <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login px-4 mx-auto mw-100">
                        <h5 class="text-center mb-4">Login Now</h5>
                        <form action="#" method="post" name="login">
                            <div class="form-group">
                                <label>Email ID</label>
                                <input type="email" class="form-control" name="email" placeholder="" required="">
                            </div>
                            <div class="form-group">
                                <label class="mb-2">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder=""
                                    required="">
                            </div>
                            <button type="submit" class="btn submit mb-4" name="login">Login</button>
                            <p class="forgot-w3ls text-center pb-4">
                                <a href="#" class="text-white">Forgot your password?</a>
                            </p>
                            <p class="account-w3ls text-center pb-4">
                                Don't have an account?
                                <a href="#" data-toggle="modal" data-target="#exampleModalCenter2">Create one now</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- $_SESSION['bbdmsdid'] -->
    </div>
    <!-- //login -->
    <!-- register -->
    <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-2">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login px-4 mx-auto mw-100">
                        <h5 class="text-center mb-4">Register Now</h5>
                        <form action="#" method="post" name="signup" onsubmit="return checkpass();">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="fullname"
                                    placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobileno" id="mobileno" required="true"
                                    placeholder="Mobile Number" maxlength="10" pattern="[0-9]+">
                            </div>

                            <div class="form-group">
                                <label class="mb-2">Email Id</label>
                                <input type="email" name="emailid" class="form-control" placeholder="Email Id">
                            </div>
                            <div class="form-group">
                                <label class="mb-2">Age</label>
                                <input type="text" class="form-control" name="age" id="age" placeholder="Age"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label class="mb-2">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="mb-2">Blood Group</label>
                                <select name="bloodgroup" class="form-control" required>
                                    <?php $sql = "SELECT * from  tblbloodgroup ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>
                                    <option value="<?php echo htmlentities($result->BloodGroup);?>">
                                        <?php echo htmlentities($result->BloodGroup);?></option>
                                    <?php }} ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" id="address" required="true"
                                    placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" name="message" required> </textarea>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" id="password" required="">
                            </div>

                            <button type="submit" class="btn btn-primary submit mb-4" name="submit">Register</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //register -->
    <!-- //modal -->
</div>
<!-- //header 2 -->