<?php
	require_once('phpscripts/config.php');
	//confirm_logged_in();

	$id = $_SESSION['user_id'];
	$tbl = "tbl_user";
	$col = "user_id";
	$popForm = getSingle($tbl, $col, $id);
	$info = mysqli_fetch_array($popForm);
	//echo $info;

	if(isset($_POST['submit'])){
		$fname = trim($_POST['fname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$email = trim($_POST['email']);
		$result = editUser($id, $fname, $username, $password, $email);
		$message = $result;
	}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit User</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>

	<header>
		<h1>Company Name</h1>
	</header>

	<section id="edit_user">
	<h2 id="edit_user_title">EDIT USER</h2>

	<img class="profile_image" src="images/user.svg" alt="template profile pic" height="100" width="100">

	<?php if(!empty($message)){echo $message;}

// echo '<h1 class="test">HTML with PHP</h1>';
	?>


	<form action="admin_edituser.php" method="post">

		<img class="edit_icon" src="images/user-name.svg" alt="icon" height="20" width="20">
		<label>First Name:</label><br><br>
		<input class="user_info" type="text" name="fname" value="<?php echo $info['user_fname'];  ?>"><br><br>

<img class="edit_icon" src="images/profile.svg" alt="icon" height="20" width="20">
		<label>Username:</label><br><br>
		<input class="user_info" type="text" name="username" value="<?php echo $info['user_name'];  ?>"><br><br>

<img class="edit_icon" src="images/lock.svg" alt="icon" height="20" width="20">
		<label>Password:</label><br><br>
		<input class="user_info" type="text" name="password" value="<?php echo $info['user_pass'];  ?>"><br><br>

<img class="edit_icon" src="images/email.svg" alt="icon" height="20" width="20">
		<label>Email:</label><br><br>
		<input class="user_info" type="text" name="email" value="<?php echo $info['user_email'];  ?>"><br><br>


		<input type="submit" name="submit" value="EDIT ACCOUNT">

	</form>
</section>


</body>
</html>
