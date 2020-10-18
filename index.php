<?php include_once "app/autoload.php"; ?>
<?php
//  page security
	if (isset($_SESSION['user_id'])) {
			header('location:profile.php');
	}


if (isset($_COOKIE['user_login'])) {
		 $cookie = $_COOKIE['user_login'];
		 $cookie_data = $way -> query("SELECT * FROM info WHERE id='$cookie'");
		 $id = $cookie_data -> fetch_assoc();
		 $_SESSION['user_id'] = $id['id'];
			header('location:profile.php');
	}
	?>


	<?php
	if(isset($_POST['add'])){
		$logname = $_POST['logname'];
		$logpass = $_POST['logpass'];

		// form validation proccess

		if( empty($logname) || empty($logpass)){
			$mess = error('all fields are required');
		}else{
			$check_data = $way -> query("SELECT * FROM info WHERE email='$logname' OR uname='$logname'");
			$check_log = $check_data -> num_rows;
			$pass_check = $check_data -> fetch_assoc();
			if($check_log == 1){
				if (password_verify($logpass , $pass_check['pass'])) {
					$_SESSION['user_id'] = $pass_check['id'];
					setcookie('user_login' , $pass_check['id'] , time() + (60*60*24*30*12) );
					header('location:profile.php');
				}else{
				$mess = error ('password not match') ;
				}
			}else{
				$mess = error ('email/username not match') ;
			}
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
	
	

	<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="link">
				<ul>
					<li><a href="signup.php">signup</a></li>
					<li><a href="index.php">signin</a></li>
					<li><a href="profile.php">profile</a></li>
					<li><a href="users.php">users</a></li>
				</ul>
			</div>
			</div>
		</div>

			<div class="row">
				<div class="col-md-8 mt-5">
					<div class="row">
						<?php
						
							if (isset($_COOKIE['user_recent_login'])) {
								$cookie = $_COOKIE['user_recent_login'];
							}
							$data = $way -> query("SELECT * FROM info WHERE id IN($cookie)");
							while($alldata = $data -> fetch_assoc()) :
						?>
						<div class="col-md-4">
						<div class="recent-login">
						<div class="card shadow" style="width:200px">
							<div class="card-header">
								<img style="width:100%; height:150px;" src="photos/profile/<?php echo $alldata['profile'] ?>" alt="">
							</div>
							<div class="card-body text-center">
								<h6><?php echo $alldata['name'] ?></h6>
								<a href="?log=ok" class="btn btn-sm btn-info">login</a>
							</div>
						</div>
						
					</div>
						</div>
							<?php endwhile; 
							?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form">
					<div class="shadow" >
							<div class="card mt-4"  style="width:500px">
								<div class="card-body">
									<h2>log in</h2>
									<?php include "app/message.php"; ?>
									<form action="" method="POST">
										<div class="form-group">
											<label for="">Username/Email</label>
											<input class="form-control" type="text" name="logname">
										</div>
										<div class="form-group">
											<label for="">Password</label>
											<input class="form-control" type="password" name="logpass">
										</div>
										<div class="form-group">
											<input class="btn btn-info" type="submit" value="Sign Up" name="add">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>