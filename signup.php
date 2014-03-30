<html>
<body>

<h1>
	Welcome to Career Fair Agency.</br>
</h1>
<p>
	Sign up today and rate the companies that you love or hate</br> 
</p>


<?php  
 $con=mysqli_connect("localhost","root","root","projectone");
//$con=mysqli_connect("db.iac.gatech.edu","projectone","smoEvDIh","projectone");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$signupusername = $_POST["username"];
$signupfirstname = $_POST["firstname"];
$signuplastname = $_POST["lastname"];
$signupemail = $_POST["email"];
$signuppassword = $_POST["password"];
if ($signupusername!=NULL && $signuppassword!=NULL)

{
	$name_requested = mysqli_query($con,"SELECT UserName FROM users WHERE UserName = '$signupusername'");//table name exer2
	//$row = mysqli_fetch_array($name_requested)
	$row = $name_requested->fetch_array(MYSQLI_NUM);
	if ($row!== NULL)
	{
	// echo $row[0]; this is the SELECT sequence, only one element: username . So row[0]
	echo "name occupied, change to another username please.";
	}
	else
	{$sql = mysqli_query($con, "INSERT INTO users (UserName,FirstName,LastName,Email,Password)VALUES ('$signupusername','$signupfirstname','$signuplastname','$signupemail','$signuppassword')");
	echo "Successfully Signed up, please sign in with your information.";}
}

else echo "Please fill out at least your username and the password.";
?>

<form action="index.php" method="post">
Username: <input type="text" name="username"><br>
Firstname:<input type="text" name="firstname"><br>
Lastname:<input type="text" name="lastname"><br>
Email:<input type="text" name="email"><br>
Password:<input type="password" name="password"><br>
<input type="submit" value = "Sign up">
</form>


<p>Sign in Section:</p>
<form action="list.php" method="post">

Username:<input type="text" name="loginuser"><br>

Password:<input type="password" name="loginpassword"><br>

<input type="submit" value="Sign in">

</form>
</body>
</html>
