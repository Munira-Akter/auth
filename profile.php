<?php include_once "app/autoload.php"; ?>
<?php 
//  page security
if (!isset($_SESSION['user_id'])) {
		header('location:index.php');
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
<style>
	
	*{
		padding: 0px;
		margin: 0px;
		outline: 0px;
	}
	.card-header .cover img {
    width: 100%;
		height: 300px;
		padding: 0px !important;
		margin: 0px !important;
}
	.card-header .profile img{
		width: 150px;
		height: 150px;
		border-radius: 50%;
		background-color: burlywood;
		padding: 5px;
		position: relative;
    bottom: 75px;
    right: -290px;
	}

	.head{
		position: relative;
		top: -40px;
	}
	
</style>
<body>

<?php

// value recive by session

	if (isset($_SESSION['user_id'])) {
		$id = $_SESSION['user_id'];
		$data = $way -> query("SELECT * FROM info WHERE id='$id'");
		$alldata = $data -> fetch_assoc();
	}
	// value recive by url

	if (isset($_GET['profile_id'])) {
		$id = $_GET['profile_id'];
		$data = $way -> query("SELECT * FROM info WHERE id='$id'");
		$alldata = $data -> fetch_assoc();
	}

	// log out session destroy

	if (isset($_GET['logout']) && $_GET['logout'] == 'ok'){
		if (isset($_COOKIE['user_recent_login'])) {
			$login = $_COOKIE['user_recent_login'];
			$explode = explode(',' , $login);
			array_push($explode , $_SESSION['user_id']);
			$implode = implode(',', $explode);
		}else{
			$implode = $_SESSION['user_id'];
		}
		setcookie('user_login' , $_SESSION['user_id'] , time() - (60*60*24*30*12) );
		setcookie('user_recent_login' , $implode , time() + (60*60*24*30*12) );


		session_destroy();
		header('location:index.php');
	}


	



?>

	
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
		<div class="card-header">
				<div class="cover">
					<img src="photos/cover/<?php echo $alldata['cover'] ?>" alt="">
				</div>
				<div class="profile" >
					<img src="photos/profile/<?php echo $alldata['profile'] ?>" alt="" class="shadow">
				</div>
				<div class="head text-center">
					<h2><?php echo $alldata['name'] ?></h2>
					<h6><?php echo $alldata['uname'] ?></h6>
				</div>
		</div>
			<div class="card-body">
				<table class="table table-striped">
					<tr>
						<td>name</td>
						<td><?php echo $alldata['name'] ?></td>
					</tr>
					
					<tr>
						<td>username</td>
						<td><?php echo $alldata['uname'] ?></td>
					</tr>
					
					<tr>
						<td>email address</td>
						<td><?php echo $alldata['email'] ?></td>
					</tr>
					
					<tr>
						<td>cell</td>
						<td><?php echo $alldata['cell'] ?></td>
					</tr>
					
					<tr>
						<td>gender</td>
						<td><?php echo $alldata['gender'] ?></td>
					</tr>
					
					<tr>
						<td>location</td>
						<td><?php echo $alldata['location'] ?></td>
					</tr>
					

				</table>
			</div>
			<div class="card-footer">
			<?php if($alldata['id'] == $_SESSION['user_id']): ?>
				<a href="" class="btn btn-lg btn-warning shadow">update profile</a>
				<a href="?logout=ok" class="btn btn-lg btn-danger shadow">logout</a>\
			<?php endif; ?>
			</div>
		</div>
	</div>
	







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>
</html>