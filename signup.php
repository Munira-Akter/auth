<?php include_once "app/autoload.php"; ?>
<?php
	//form isseting

	if(isset($_POST['signup'])){
		$name = $_POST['name'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$cell = $_POST['cell'];
		$pass = $_POST['pass'];
		$cpass = $_POST['cpass'];
		if(isset($_POST['gender'])){
			$gender = $_POST['gender'];
		}
		$location = $_POST['location'];
		if(!isset($_POST['check'])){
			$mess = error ('you have to agree first') ;
		}
		// profile file upload 

		$filename = $_FILES ['photo'] ['name'];
		$filesize = $_FILES ['photo'] ['size'];
		$filetype = $_FILES ['photo'] ['type'];
		$filetmp =  $_FILES ['photo'] ['tmp_name'];

		$unique_file_name =md5(time().rand()) .$filename;
	
		// cover file upload 

		$covername = $_FILES ['cover'] ['name'];
		$coversize = $_FILES ['cover'] ['size'];
		$covertype = $_FILES ['cover'] ['type'];
		$covertmp =  $_FILES ['cover'] ['tmp_name'];

		$cover_unique_file_name = md5(time().rand()) .$covername;
	


		// password convert to hash

		$hash_pass = password_hash($pass , PASSWORD_DEFAULT);

		//email , username , cell number check

		$email_check =    emailcheck("info","email","$email");

		$username_check =  emailcheck("info","uname","$uname");

		$cell_check =      emailcheck("info","cell","$cell");

		
		// validation message code start here

		if(empty($name) || empty ($uname)|| empty ($email)|| empty ($cell)|| empty ($gender)|| empty ($pass)|| empty ($location))
		{
			$mess = error ('all fields are required') ;

		}elseif(!Filter_var($email, FILTER_VALIDATE_EMAIL)){

			$mess = error ('invalid email address') ;

		}elseif(strlen($pass) <= 3){

			$mess = error ('password must be in 4 cheracters or long') ;
			
		}elseif($email_check > 0){

			$mess = error ('email already exit') ;
			
		}elseif($username_check > 0){

			$mess = error ('username already exit') ;
			
		}elseif($cell_check > 0){

			$mess = error ('cell already exit') ;
			
		}elseif ($pass != $cpass) {
			$mess = error ('password not match') ;
		}else{

			// data insert into mysql database
			$way -> query("INSERT INTO info (name,email,cell,pass,uname,gender,location,profile,cover) VALUES ('$name','$email','$cell','$hash_pass','$uname','$gender','$location','$unique_file_name','$cover_unique_file_name')");
			move_uploaded_file($filetmp, 'photos/profile/' .$unique_file_name);
			move_uploaded_file($covertmp, 'photos/cover/' .$cover_unique_file_name);
		  header('location:index.php');
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Authentication Project</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
	
<div class="link">
		<ul>
			<li><a href="signup.php">signup</a></li>
			<li><a href="index.php">signin</a></li>
			<li><a href="profile.php">profile</a></li>
			<li><a href="users.php">users</a></li>
		</ul>
	</div>

	<div class="wrap shadow">
		<div class="card">
			<div class="card-body">
				<h2>Sign Up</h2>
				<?php include "app/message.php"; ?>
				<form action="" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Name</label>
						<input class="form-control" type="text" name="name">
					</div>
					<div class="form-group">
						<label for="">Username</label>
						<input class="form-control" type="text" name="uname">
					</div>
					<div class="form-group">
						<label for="">Email</label>
						<input class="form-control" type="text" name="email">
					</div>
					<div class="form-group">
						<label for="">Cell</label>
						<input class="form-control" type="text" name="cell">
					</div>
					<div class="form-group">
						<label for="">password</label>
						<input class="form-control" type="password" name="pass">
					</div>
					<div class="form-group">
						<label for="">Confirm Password</label>
						<input class="form-control" type="password" name="cpass">
					</div>
					<div class="form-group">
						<label for="">Profile Picture</label>
						<input class="form-control-file" type="file" name="photo">
					</div>
					<div class="form-group">
						<label for="">Cover Photo</label>
						<input class="form-control-file" type="file" name="cover">
					</div>
					<div class="form-group">
						<label for="">Location</label><br>
						<select class="form-control"  name="location" id="">
							<option value="Dhaka" selected>Dhaka</option>
							<option value="Comilla" >Comilla</option>
							<option value="Sylhet" >Sylhet</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Gender</label><br>
						<input class="form-control-inline" type="radio" id="male" checked  value="male"  name="gender">&nbsp;<label for="male">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="form-control-inline" type="radio" id="Female"  value="female"  name="gender">&nbsp;<label for="Female">Female</label>
					</div>

					
					<div class="from-group">
						<label for="">Date of birth</label><br>
						<select name="day" id="" class="form-control-inline">
							<option value="Days">Days</option>
								<?php
								 for ($i=1;  $i<=31;  $i++) { 
								echo	"<option value=>$i</option>";
								 }
								?>
						</select>
						<select name="month" id="" class="form-control-inline">
							<option value="month">month</option>
								<?php
								 for ($i=1;  $i<=12;  $i++) { 
								echo	"<option value=>$i</option>";
								 }
								?>
						</select>
						<select name="year" id="" class="form-control-inline">
							<option value="year">year</option>
								<?php
								 for ($i=2002;  $i>=1900;  $i--) { 
								echo	"<option value=>$i</option>";
								 }
								?>
						</select>
					</div>

					<br>
					<div class="from-group">
						<input type="checkbox" name="check" id="check">&nbsp;<label for="check">I agree your terms and conditions</label>
					</div>

					<br>

					<div class="form-group">
						<input class="btn btn-info" type="submit" value="Sign Up" name="signup">
					</div>
				</form>
			</div>
		</div>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>