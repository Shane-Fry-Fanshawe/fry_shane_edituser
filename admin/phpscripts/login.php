<?php
function logIn($username, $password, $ip) {
		require_once('connect.php');
		$username = mysqli_real_escape_string($link, $username);
		$password = mysqli_real_escape_string($link, $password);
		$loginstring = "SELECT * FROM tbl_user WHERE user_name='{$username}' AND user_pass='{$password}'";
		$user_set = mysqli_query($link, $loginstring);
		//$logincount++;




		//echo mysqli_num_rows($user_set);

		//added a login count, and if its equal to 0 it will send to edit page first, and update count to add 1
		if(mysqli_num_rows($user_set)){
			require_once('connect.php');

			$founduser = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
			$id = $founduser['user_id'];
			$_SESSION['user_id'] = $id;
			$_SESSION['user_name']= $founduser['user_fname'];
			if(mysqli_query($link, $loginstring)){
				$update = "UPDATE tbl_user SET user_ip='{$ip}' WHERE user_id={$id}";
				$updatequery = mysqli_query($link, $update);



//first attempt at doing the homework but I realized the second part was to redirect after it was changed, so I can leave this anyways for total logins. the Second elseif was going to redirect to index but that isnt what you wanted
						$logincount = "SELECT user_login_count FROM tbl_user WHERE user_id={$id}";
						$user_logincount = mysqli_query($link, $logincount);
						//Checking the user login value
						$resultCheck = mysqli_num_rows($user_logincount);

						//Getting the value
						if($resultCheck > 0){
							//echo "did it work";
							while($rowValue = mysqli_fetch_assoc($user_logincount)){
								//echo $rowValue['user_login_count'];
								$login_value = $rowValue['user_login_count'];
							}
						}


						$verifiedcount = "SELECT user_verified FROM tbl_user WHERE user_id={$id}";
						$user_verified = mysqli_query($link, $verifiedcount);
						//Checking the user login value
						$resultCheck = mysqli_num_rows($user_verified);

						//Getting the value
						if($resultCheck > 0){
							//echo "did it work";
							while($rowValue = mysqli_fetch_assoc($user_verified)){
								//echo $rowValue['user_login_count'];
								$user_verifiedvalue = $rowValue['user_verified'];
							}
						}


					//Loop to do things based on that value
					if ($login_value == 1) { //if and elses that work, finished the testing when login hardcoded value
									//echo "first time";

									$login_value++;
									echo $login_value;

									//echo "first timer";

									$updateLogin = "UPDATE tbl_user SET user_login_count='{$login_value}' WHERE user_id={$id}";
									$updatequeryLogin = mysqli_query($link, $updateLogin);


									redirect_to("admin_edituser.php");
								}

								elseif ($login_value > 1 AND $user_verifiedvalue > 0) {
									$login_value++;

									//echo "Loggin in more than once and edited acc";

									$updateLogin = "UPDATE tbl_user SET user_login_count='{$login_value}' WHERE user_id={$id}";
									$updatequeryLogin = mysqli_query($link, $updateLogin);

									//redirect_to("admin_index.php");

									//This gives me the current time minus 1 minute
									$date = date("Y-m-d H:i:s");
									$time = strtotime($date);
									$time = $time - (1 * 60);
									$date = date("Y-m-d H:i:s", $time);

									echo $date;






								}

			}


		}else{
			$message = "Learn how to type you dumba&*.";
			return $message;
		}

		mysqli_close($link);
	}
?>
