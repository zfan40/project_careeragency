<html>
<head>
<link rel="stylesheet" type="text/css" href="css/goa.css">
</head>
<body>

<img id = "headpic" src="css/header.png">
<a href = "index.php" id = "sign">signup/logout</a>
<?php
// Create connection
 $con=mysqli_connect("localhost","root","root","projectone");
//$con=mysqli_connect("db.iac.gatech.edu","projectone","smoEvDIh","projectone");
// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
<?php 
// $companyname = $_POST["company"];

$username = $_POST["loginuser"];
$password = $_POST["loginpassword"];

echo $username;
echo $password;
function IsChecked($chkname,$value)
    {
        if(!empty($_POST[$chkname]))
        {
            foreach($_POST[$chkname] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }

//judge whether this is a correct registered user
$name_requested = mysqli_query($con,"SELECT UserID,FirstName FROM users WHERE UserName='$username' AND Password='$password';");
$row = $name_requested->fetch_array(MYSQLI_ASSOC);
if ($row["UserID"])
{
 $user = $row["UserID"];
echo "welcome!".$row["FirstName"];
}
else
{$user = -1;
echo "that's a wrong ID!!!!!";
}

$minstaff = IsChecked('staffnumber','A') ? 0 : -1;
$maxstaff = IsChecked('staffnumber','A') ? 100 : -1;
$minstaff = IsChecked('staffnumber','B') ? 100 : $minstaff;
$maxstaff = IsChecked('staffnumber','B') ? 300 : $maxstaff;
$minstaff = IsChecked('staffnumber','C') ? 300 : $minstaff;
$maxstaff = IsChecked('staffnumber','C') ? 800 : $maxstaff;
$minstaff = IsChecked('staffnumber','D') ? 800 : $minstaff;
$maxstaff = IsChecked('staffnumber','D') ? 2000 : $maxstaff;
$minstaff = IsChecked('staffnumber','E') ? 2000 : $minstaff;
$maxstaff = IsChecked('staffnumber','E') ? 10000 : $maxstaff;
$minstaff = IsChecked('staffnumber','F') ? 10000 : $minstaff;
$maxstaff = IsChecked('staffnumber','F') ? 1000000 : $maxstaff;



$minage = IsChecked('companyage','A') ? 0 : -1;
$maxage = IsChecked('companyage','A') ? 1 : -1;
$minage = IsChecked('companyage','B') ? 1 : $minage;
$maxage = IsChecked('companyage','B') ? 3 : $maxage;
$minage = IsChecked('companyage','C') ? 3 : $minage;
$maxage = IsChecked('companyage','C') ? 8 : $maxage;
$minage = IsChecked('companyage','D') ? 8 : $minage;
$maxage = IsChecked('companyage','D') ? 15 : $maxage;
$minage = IsChecked('companyage','E') ? 15 : $minage;
$maxage = IsChecked('companyage','E') ? 30 : $maxage;
$minage = IsChecked('companyage','F') ? 30 : $minage;
$maxage = IsChecked('companyage','F') ? 100 : $maxage;
$minage = IsChecked('companyage','G') ? 100 : $minage;
$maxage = IsChecked('companyage','G') ? 10000 : $maxage;


// 
$minrate = IsChecked('userrate','A') ? 0 : -1;
$maxrate = IsChecked('userrate','A') ? 1 : -1;
$minrate = IsChecked('userrate','B') ? 1 : $minrate;
$maxrate = IsChecked('userrate','B') ? 2 : $maxrate;
$minrate = IsChecked('userrate','C') ? 2 : $minrate;
$maxrate = IsChecked('userrate','C') ? 3 : $maxrate;
$minrate = IsChecked('userrate','D') ? 3 : $minrate;
$maxrate = IsChecked('userrate','D') ? 4 : $maxrate;
$minrate = IsChecked('userrate','E') ? 4 : $minrate;
$maxrate = IsChecked('userrate','E') ? 5 : $maxrate;
$minrate = IsChecked('userrate','F') ? 5 : $minrate;
$maxrate = IsChecked('userrate','F') ? 6 : $maxrate;


?>

<form action="list.php" method="post">


<div id = "filters">
Staff numbers
</br>
<input type="checkbox" name="staffnumber[]" value="A" />0-100<br />
<input type="checkbox" name="staffnumber[]" value="B" />100-300<br />
<input type="checkbox" name="staffnumber[]" value="C" />300-800<br />
<input type="checkbox" name="staffnumber[]" value="D" />800-2000<br />
<input type="checkbox" name="staffnumber[]" value="E" />2000-10000<br />
<input type="checkbox" name="staffnumber[]" value="F" />more than 10000<br />
Company ages
</br>
<input type="checkbox" name="companyage[]" value="A" />less than 1 year<br />
<input type="checkbox" name="companyage[]" value="B" />1-3<br />
<input type="checkbox" name="companyage[]" value="C" />3-8<br />
<input type="checkbox" name="companyage[]" value="D" />8-15<br />
<input type="checkbox" name="companyage[]" value="E" />15-30<br />
<input type="checkbox" name="companyage[]" value="F" />30-100<br />
<input type="checkbox" name="companyage[]" value="G" />more than 100<br />
User rates
</br>
<input type="checkbox" name="userrate[]" value="A" />less than 1<br />
<input type="checkbox" name="userrate[]" value="B" />1-2<br />
<input type="checkbox" name="userrate[]" value="C" />2-3<br />
<input type="checkbox" name="userrate[]" value="D" />3-4<br />
<input type="checkbox" name="userrate[]" value="E" />4-5<br />
<input type="checkbox" name="userrate[]" value="F" />5<br />

<input type="hidden" name="loginuser" value="<?php echo htmlspecialchars($username); ?>">
<input type="hidden" name="loginpassword" value="<?php echo htmlspecialchars($password); ?>">
<!-- <input type="hidden" name="loginuser" value= 'jijiji'>
<input type="hidden" name="loginpassword" value= 'jijiji'> -->
<input type="submit" value = "search">
</div>
<!-- Locations
</br> -->
<!-- <input type="checkbox" name="location[]" value="A" />AK<br />
<input type="checkbox" name="location[]" value="B" />AZ<br />
<input type="checkbox" name="location[]" value="C" />CA<br />
<input type="checkbox" name="location[]" value="D" />GA<br />
<input type="checkbox" name="location[]" value="E" />MN<br />
<input type="checkbox" name="location[]" value="E" />NY<br /> -->


</form>

<?php 

	if ($minstaff==-1 && $minrate==-1 && $minage==-1)
	{
		$name_requested = mysqli_query($con,"SELECT * FROM companies ORDER BY CompanyName");//table name exer2
		echo "<table border=\"1\"  id = \"complist\">";
		echo "<tr>";
		echo "<td>"."Company name"."</td>";
		echo "<td>"."Staff numbers"."</td>";
		echo "<td>"."Company age"."</td>";
		echo "<td>"."Average Rate"."</td>";
		echo "</tr>";
		while ($row = $name_requested->fetch_array(MYSQLI_ASSOC))
		{
			//`CompanyID`,`CompanyName`,`CompanyPage`,`CompanyLogo`,`CompanyStaff`,`CompanyDescription`,`AverageRate` ,`CompanyAge`
			echo "<tr>";
			echo "<td>"."<a href = \"descriptions.php?name=".$row["CompanyName"]."&id=".$user."\">".$row["CompanyName"]."</a>"."</td>";
			echo "<td>".$row["CompanyStaff"]."</td>";
			echo "<td>".$row["CompanyAge"]."</td>";
			echo "<td>".$row["AverageRate"]."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	else{
	    //$name_requested = mysqli_query($con,"SELECT companyID FROM company_locations INNER JOIN locations ON locations.locationID = company_locations.locationID WHERE locations.State="CA" ");
		if ($maxstaff == -1)
			$maxstaff = 10000000;
		if ($maxage == -1)
			$maxage = 1000;
		if ($maxrate == -1)
			$maxrate = 6;
	    $name_requested = mysqli_query($con,"SELECT * FROM companies WHERE CompanyStaff >= '$minstaff' AND CompanyStaff<'$maxstaff' AND CompanyAge >= '$minage' AND CompanyAge<'$maxage' AND AverageRate>='$minrate' AND AverageRate<'$maxrate'  ORDER BY CompanyName; ");
	    echo "<table border=\"1\" id = \"complist\">";
		echo "<tr>";
		echo "<td>"."Company name"."</td>";
		echo "<td>"."Staff numbers"."</td>";
		echo "<td>"."Company age"."</td>";
		echo "<td>"."Average Rate"."</td>";
		echo "</tr>";
		while ($row = $name_requested->fetch_array(MYSQLI_ASSOC))
		{
			//`CompanyID`,`CompanyName`,`CompanyPage`,`CompanyLogo`,`CompanyStaff`,`CompanyDescription`,`AverageRate` ,`CompanyAge`
			echo "<tr>";
			echo "<td>"."<a href = \"descriptions.php?name=".$row["CompanyName"]."&id=".$user."\">".$row["CompanyName"]."</a>"."</td>";
			echo "<td>".$row["CompanyStaff"]."</td>";
			echo "<td>".$row["CompanyAge"]."</td>";
			echo "<td>".$row["AverageRate"]."</td>";
			echo "</tr>";
			// echo "shenjingbinga";
		}
		echo "</table>";
	// else
	// {
	//   	echo "doomsday of the this DB";
	// }
	//SELECT * FROM company_locations INNER JOIN locations ON locations.LocationID = company_locations.LocationID INNER JOIN companies ON companies.CompanyID = company_locations.CompanyID
	}
		echo $minstaff;
	echo $maxstaff;
	echo $minage;
	echo $maxage;
	echo $minrate;
	echo $maxrate;
	echo "</br>";
?>

</body>
</html>





















