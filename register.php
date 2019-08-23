<?php

/*------------------------------------
  [ Date ] : 8/23/2019
  [ Author ] : Muhammad Alaraby.
  [ Info ] : Home page.
--------------------------------------
*/
?>

<?php include "./includes/db.php"; ?>
<?php include "./includes/header.php"; ?>
<?php

/*---------------------------[ Variables ]-------------------------------------- */
//Declaring variables to prevent errors.
$firstName = ""; //First name
$lastName = "";  //Last name
$userEmail = ""; // email
$userConfirmEmail = ""; //Confirm email
$userPassword = ""; // Password
$userConfirmPassword = ""; //Confirm password
$SignUpDate = ""; // Sign up date
$errorArray[] = ""; // Holds error messages.


if (isset($_POST['reg_button'])) {

  /*--------------[ Registration form values ]------------------------*/
  //First name.
  $firstName = strip_tags($_POST['reg_fname']);  //Remove html and PHP tages 
  $firstName = str_replace(' ', '', $firstName); //Remove spaces
  $firstName = ucfirst(strtolower($firstName)); //Uppercase first letter
  $_SESSION['reg_fname'] = $firstName;

  //Last name
  $lastName = strip_tags($_POST['reg_lname']);  //Remove html and php  tages
  $lastName = str_replace(' ', '', $lastName);  //Remove spaces
  $lastName = ucfirst(strtolower($lastName));  //Uppercase first letter
  $_SESSION['reg_lname'] = $lastName;

  //Email
  $userEmail = strip_tags($_POST['reg_email']); //Remove html and php tages
  $userEmail = str_replace(' ', '', $userEmail);  //Remove spaces
  $userEmail = ucfirst(strtolower($userEmail)); //Uppercase first letter
  $_SESSION['reg_email'] = $userEmail;  //Store email into session variables.

  //Confirm email
  $userConfirmEmail = strip_tags($_POST['reg_email2']);
  $userConfirmEmail = str_replace(' ', '', $userConfirmEmail);
  $userConfirmEmail = ucfirst(strtolower($userConfirmEmail));
  $_SESSION['reg_email2'] = $userConfirmEmail;

  //Password
  $userPassword = strip_tags($_POST['reg_password']);
  $_SESSION['reg_password'] = $userPassword;

  //Confirm email
  $userConfirmPassword = strip_tags($_POST['reg_password2']);
  $_SESSION['reg_password2'] = $userConfirmPassword;

  //Current date
  $SignUpDate = date("Y-m-d");



  /*-----------------[ @Checking session ]-----------------------------------*/
  //Check for first name and last name
  $firstname = strlen($firstName);
  $lastname = strlen($lastName);

  if ($firstname > 30 || $firstname < 5) {
    array_push($errorArray, " First name should be at least 8 charachters<br>");
  } elseif ($lastname > 25 || $lastname < 2) {
    array_push($errorArray, " Last name should be at least 8 charachters<br>");
  }

  //Check for email
  if ($userEmail == $userConfirmEmail) {
    //Check if email is in valid format
    if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
      $userEmail = filter_var($userEmail, FILTER_VALIDATE_EMAIL);

      //Check if email already exists
      //$emailCheck = mysqli_query($connectToDatabase, "SELECT email FROM users WHERE email='$userEmail'");
      $emailCheck = mysqli_query($connectToDatabase, "SELECT email FROM users WHERE email='$userEmail'");
      //Count the number of rows returned
      $numberOfRows = mysqli_num_rows($emailCheck);

      if ($numberOfRows > 0) {
        array_push($errorArray, "Email already in use<br>");
      }
    } else {
      array_push($errorArray, "Invalid Email format<br>");
    }
  } else {
    array_push($errorArray, "Email don`t match<br>");
  }

  /*-------------------------------------------------------------*/

  if ($userPassword != $userConfirmPassword) {
    array_push($errorArray, "passwords do not match<br>");
  } else {
    if (preg_match('/[^A-Z0-9a-z]/', $userPassword)) {
      array_push($errorArray, "Password should only contain english characters or numbers<br>");
    }
  }
  $validPassword = strlen($userPassword);
  if ($validPassword > 30 || $validPassword < 6) {
    array_push($errorArray, "password should be at least 6 characters<br>");
  }
}



//  ...../ php file end tag--------------------
?>

<form action="register.php" method="POST">
  <!-------------------------[ FIRST NAME ]-------------------------------------->
  <input type="text" name="reg_fname" placeholder="First Name" value="<?php
      //Keep the firstname if there is an error
   if (isset($firstName)) {echo $firstName;}?>" autocomplete="off" required>
  <br>
  <?php
  //Display first name errors 
  if (in_array(" First name should be at least 8 charachters<br>", $errorArray)) {
    echo "First name should be at least 8 charachters<br>";
  }
  ?>
  <!--------------------------------[ LAST NAME ]-------------------------------------->

  <input type="text" name="reg_lname" placeholder="Last Name" 
  value="<?php
    //Keep the lastname if there is an error
    if (isset($lastName)) {echo $lastName;} ?>" autocomplete="off" required>
  <br>

  <?php
  //Display last name error
  if (in_array(" Last name should be at least 8 charachters<br>", $errorArray)) {
    echo " Last name should be at least 8 charachters<br>";
  }
  ?>

  <!-----------------------------------[ EMAIL ]-------------------------------------->
  <input type="email" name="reg_email" placeholder="Email" 
  value="<?php 
  //Keep the user email if there is an error
  if (isset($userEmail)){echo $userEmail;}?>" required>

  <br>
  <?php
  //Display user email error
  if (in_array("Email already in use<br>", $errorArray)) {
    echo "Email already in use<br>";
  } elseif (in_array("Invalid Email format<br>", $errorArray)) {
    echo "Invalid Email format<br>";
  } elseif (in_array("Email don`t match<br>", $errorArray)) {
    echo "Email don`t match<br>";
  } ?>

  <input type="email" name="reg_email2" placeholder="Confirm Email" 
  value="<?php
   //Keep the user email if there is an error
  if (isset($userConfirmEmail)) {
    echo $userConfirmEmail;
    } ?>" required>
  <br>

  <!----------------------------[ PASSWORD  ]-------------------------------------->
  <input type="password" name="reg_password" placeholder="Enter password" autocomplete="new-pass" required>
  <br>

  <input type="password" name="reg_password2" placeholder="Confirm Password" autocomplete="new-pass" required>
  <br>
  <?php
  //Display user password error
  if (in_array("passwords do not match<br>", $errorArray)) {
    echo "passwords do not match<br>";
  } ?>
  <?php
  //Display user password error
  if (in_array("Password should only contain english characters or numbers<br>", $errorArray)) {
    echo "Password should only contain english characters or numbers<br>";
  }?>
  <?php if(in_array("password should be at least 6 characters<br>", $errorArray)) {echo "password should be at least 6 characters<br>";} ?>

  <input type="submit" name="reg_button" value="Register">
</form>


<?php include "./includes/footer.php"; ?>