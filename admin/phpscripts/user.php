<?php

	/*function createUser($fname, $username, $password, $email, $lvllist) {
		include('connect.php');
		$userstring = "INSERT INTO tbl_user VALUES(NULL, '{$fname}', '{$username}', '{$password}', '{$email}', NULL, '{$lvllist}', 'no' )";
		//echo $userstring;
		$userquery = mysqli_query($link, $userstring);
		if($userquery) {
			redirect_to('admin_index.php');
		}else{
			$message = "Your hiring practices have failed you.  This individual sucks.";
			return $message;
		}
		mysqli_close($link);
	} */

	function createUser($fname, $username, $password, $email, $userlvl){
  include('connect.php'); //the second NULL is for time, the third NULL is for ip address

	$count = 1;
	$verified = 0;



															/* Got rid of the random Password for this assignment!!!! (Easier to work with) - REMINDER AND TO ADD IN FULL CMS LATER*/

  // This query inserts a new user in the database
  //Some changes were adding the (`user_fname` etc so it could work saving to the data base no data since it gives a current timestamp)
	$userString = "INSERT INTO tbl_user(`user_fname`,`user_name`, `user_pass`,`user_email`, `user_ip`, `user_status`) VALUES('{$fname}', '{$username}', '{$password}', '{$email}', '{$userlvl}', 'no')"; //Removed Date since currentstamp


  $userQuery = mysqli_query($link, $userString);
  if($userQuery){ //if userQuery was successful and above



//Email Function
    $message = "Welcome {$username} \r\n This is your password : {$password}\r\n You can login in http://domain.com/admin/admin_login.php"; //template email since we are local hosting this
    // In case any of our lines are larger than 70 characters, we should use wordwrap()
    //I think this is class work since I was sick and got this from Lexi
    $message = wordwrap($message, 70, "\r\n"); // rn = line break
    // Send email
    mail($email, 'Welcome user', $message);
      //I set it to create user instead of the login page, since an admin wouldnt want to be redirected to test it.
       redirect_to("admin_login.php");
  }else{ //if fails
    $message = "There was a problem creating this user";
    return $message;
  }
  mysqli_close($link);
}





//Adding stuff once you click edit

	function editUser($id, $fname, $username, $password, $email) {
		include('connect.php');

		$updatestring = "UPDATE tbl_user SET user_fname='{$fname}', user_name='{$username}', user_pass='{$password}', user_email='{$email}' WHERE user_id={$id}";
		$updatequery = mysqli_query($link, $updatestring);

		if($updatequery) {
			//redirect_to("admin_index.php");




			//Editing here, so once it runs I can do things
			//The system I have set up is set to if they edit it, it verifies the account (greater than 0), and I left it to keep counting incase they every need to see if someone else may have edited it (hacked) and could add a most recentedit date with this.

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
		//REALIZED AFTER CODING IT ALL THAT I NEED TO DO THINGS WHEN YOU LOG IN, NOT EDIT, SO IM LEAVING IT FOR NOW BUT I COULD HAVE JUST ADDED ONE TO THE VALUE NO IF AND ELSEIF NEEDED
		if ($user_verifiedvalue == 0) { //if and elses that work, finished the testing when login hardcoded value
						//echo "first time";

						$user_verifiedvalue++;
						$updateVerified = "UPDATE tbl_user SET user_verified='{$user_verifiedvalue}' WHERE user_id={$id}";
						$updatequeryLogin = mysqli_query($link, $updateVerified);


						redirect_to("admin_edituser.php");
					}

					elseif ($user_verifiedvalue > 0) {
						$user_verifiedvalue++;
						echo $user_verifiedvalue;


						$updateVerified = "UPDATE tbl_user SET user_verified='{$user_verifiedvalue}' WHERE user_id={$id}";
						$updatequeryLogin = mysqli_query($link, $updateVerified);

						redirect_to("admin_edituser.php");
					}

		}else{
			$message = "Guess you got canned...";
			return $message;
		}

		mysqli_close($link);
	}











	function deleteUser($id) {
		include('connect.php');
		$delstring = "DELETE FROM tbl_user WHERE user_id = {$id}";
		$delquery = mysqli_query($link, $delstring);
		if($delquery) {
			redirect_to("../admin_index.php");
		}else{
			$message = "Bye, bye...";
			return $message;
		}
		mysqli_close($link);
	}
?>
