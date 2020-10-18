<?php include_once "app/autoload.php"; ?>
<?php
	if (isset($_GET['delete_id'])) {
		$delete =$_GET['delete_id'];
		$profile =$_GET['profile'];
		$cover =$_GET['cover'];
		$way -> query("DELETE FROM info WHERE id='$delete'");
		unlink('photos/profile/' . $profile);
		unlink('photos/cover/' . $cover);
		header('location:users.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Development Area</title>
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
	<div class="wrap-table shadow">
		<div class="card">
			<div class="card-body">
				<h2>All users</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>User Name</th>
							<th>Email</th>
							<th>Cell</th>
							<th>Gender</th>
							<th>location</th>
							<th>Profile</th>
							<th>Cover</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
													
							<?php
								$all_data = $way -> query("SELECT * FROM info");
								while($users = $all_data -> fetch_assoc()):
								$i= 1;
							?>								
						<tr>
							<td><?php echo $i; $i++;?></td>
							<td><?php echo $users['name'];?></td>
							<td><?php echo $users['uname'];?></td>
							<td><?php echo $users['email'];?></td>
							<td><?php echo $users['cell'];?></td>
							<td><?php echo $users['gender'];?></td>
							<td><?php echo $users['location'];?></td>
							<td><img src="photos/profile/<?php echo $users['profile']?>" alt=""></td>
							<td><img src="photos/cover/<?php echo $users['cover'] ?>" alt=""></td>
							<td>
								<?php if($users['id'] == $_SESSION['user_id']): ?>
								<a class="btn btn-sm btn-warning" href="edit.php?edit_id=<?php echo $users['id'];?>">Edit</a>
								<a class="btn btn-sm btn-danger delete" href="?delete_id=<?php echo $users['id'];?>&profile=<?php echo $users['profile'];?>&cover=<?php echo $users['cover'];?>">Delete</a>
								<?php else: ?>
								<a class="btn btn-sm btn-info" href="profile.php?profile_id=<?php echo $users['id'];?>">View</a>
								<?php endif; ?>
							</td>
						</tr>
						<?php endwhile;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
			$('a.delete').click(function(){
				let del = confirm('Are you sure you want to delete this data');
				if(del == true){
					return true;
				}else{
					return false;
				}
			});
	</script>
</body>
</html>