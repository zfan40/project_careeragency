
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/goa.css">
<script
src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBe0tbkipO69WmjQKmL_9V5jfcZk4DcUsg&sensor=false">
</script>

</head>
<body>

<?php
// Create connection
//$con=mysqli_connect("localhost","root","root","projectone");
$con=mysqli_connect("db.iac.gatech.edu","projectone","smoEvDIh","projectone");
$companyname = $_GET['name'];//from the url
$user = $_GET['id'];
$userrate = $_POST['rate'];
$companynamee = $_POST['name']; //from the form
$userr = $_POST['id'];

// echo $companyname;
// echo $user;
// echo $userrate;
// echo $companynamee;
// echo $userr;

//anyway,we use only $companyname and $userr
if ($companyname == NULL)
$companyname = $companynamee;
if ($user == NULL)
$user = $userr;


// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>


<?php 
	//$companyname = $_POST["company"];
	$name_requested = mysqli_query($con,"SELECT * FROM companies WHERE CompanyName = '$companyname'");//table name exer2
	//$row = mysqli_fetch_array($name_requested)
	$row = $name_requested->fetch_array(MYSQLI_ASSOC);
?>

<h1><?php echo $row["CompanyName"]; ?></h1>
<img src=<?php echo $row["CompanyLogo"]; ?>>
<a href=<?php echo $row["CompanyPage"]; ?>>homepage</a>
<h2>Descriptions</h2>
<p><?php echo $row["CompanyDescription"]; ?></p>
<h2>Year Established</h2>
<p><?php echo (2013 - $row["CompanyAge"]); ?></p>
<h2>Staff Numbers</h2>
<p><?php echo $row["CompanyStaff"]; ?></p>
<h2>Your rate</h2>

<!-- 是否注册用户，如果是是否rate过，三种不同的展示 -->
<?php 
$companyid = $row["CompanyID"];
if ($user == -1)//for users not logged in.
{
	echo "<p>"."register to rate this company"."</p>";
} 

else//for logged in users
{
	$rate_request = mysqli_query($con,"SELECT * FROM userrates WHERE UserID = '$user' AND CompanyID = '$companyid';");
	$row = $rate_request->fetch_array(MYSQLI_ASSOC);
	if ($row)//rateed already
	{
		echo "rated ".$row["Star"]." star before,but rate again if you change your mind at any time!";
		// echo "you gave rate".$row["Star"]."to this company"."<br>";
		if ($userrate!=NULL)
		{
			mysqli_query($con,"UPDATE userrates SET Star = '$userrate' WHERE UserID = '$user' AND CompanyID = '$companyid';"); 
			echo "thank you for rating this company again!<br>";
		}
	//calculate the avg rate
		$avg_request = mysqli_query($con,"SELECT * FROM userrates WHERE CompanyID = '$companyid';");
		$avg = 0.0;
		$count = 0;
		while ($avgrow = $avg_request->fetch_array(MYSQLI_ASSOC))
		{
			$avg = $avg + $avgrow['Star'];
			$count = $count + 1;
		}
		$avg = $avg/$count;
		mysqli_query($con,"UPDATE companies SET AverageRate = '$avg' WHERE CompanyID = '$companyid';"); 
		
	}
		
	else//never rated before
	{
		if ($userrate!=NULL)
		{
			mysqli_query($con,"INSERT INTO userrates (UserID,CompanyID,Star) VALUES ('$user','$companyid','$userrate');");
			echo "thank you for rating this company!<br>";
		}
		//calculate the avg rate
		$avg_request = mysqli_query($con,"SELECT * FROM userrates WHERE CompanyID = '$companyid';");
		$avg = 0.0;
		$count = 0;
		while ($avgrow = $avg_request->fetch_array(MYSQLI_ASSOC))
		{
			$avg = $avg + $avgrow['Star'];
			$count = $count + 1;
		}
		$avg = $avg/$count;
		mysqli_query($con,"UPDATE companies SET AverageRate = '$avg' WHERE CompanyID = '$companyid';"); 

	}
}
?>


<form action="descriptions.php" method="post" <?php if ($user==-1) echo "style=\"display: none;\""?>>
<input type="radio" name="rate" value=5>5 star<br>
<input type="radio" name="rate" value=4>4 star<br>
<input type="radio" name="rate" value=3>3 star<br>
<input type="radio" name="rate" value=2>2 star<br>
<input type="radio" name="rate" value=1>1 star<br>
<input type="hidden" name="name" value="<?php echo htmlspecialchars($companyname); ?>">
<input type="hidden" name="id" value="<?php echo htmlspecialchars($user); ?>">
<input type="submit" value = "confirm">
</form>


<?php 
	//$companyname = $_POST["company"];
	$name_requested = mysqli_query($con,"SELECT * FROM companies WHERE CompanyName = '$companyname'");//table name exer2
	//$row = mysqli_fetch_array($name_requested)
	$row = $name_requested->fetch_array(MYSQLI_ASSOC);
?>

<!-- show avg at last -->
<h2>Average rate</h2>

<p>
	<?php 
		 echo "$count has rated <br>";
		 if ($row["AverageRate"] == 0)
		 echo "probably no one has ever rated!";
		 else 
		 echo "average rate is ".$row["AverageRate"];
	?>
</p>


<div id="googleMap" style="width:500px;height:380px;"></div>

<!-- getting the latitude and longitude of the company locations -->
<?php 
$loc_request = mysqli_query($con,"SELECT locations.Latitude, locations.Longitude
FROM locations
INNER JOIN company_locations
ON locations.LocationID=company_locations.LocationID
WHERE company_locations.CompanyID = '$companyid';");

$countloc = 0;
$locarray = array();
while ($loc = $loc_request->fetch_array(MYSQLI_ASSOC))
{
	array_push($locarray,$loc);
	echo $locarray[$countloc]["Latitude"].",".$locarray[$countloc]["Longitude"]."<br>";
	$countloc = $countloc + 1;
}
?>
<script>


var myCenter=new google.maps.LatLng(<?php echo $locarray[0]["Latitude"]; ?>,<?php echo $locarray[0]["Longitude"]; ?>);
// var myCenter1=new google.maps.LatLng(<?php echo $locarray[1]["Latitude"]; ?>,<?php echo $locarray[1]["Longitude"]; ?>);

// var myCenter = new Array([<?php echo $countloc; ?>])

// for (var i =0;i<=1;i++)
// {
// 	myCenter[i] = new google.maps.LatLng(<?php echo $locarray[i]["Latitude"]; ?>,<?php echo $locarray[i]["Longitude"]; ?>);
// }
function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:4,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });
// var marker1=new google.maps.Marker({
//   position:myCenter[1],
//   });

marker.setMap(map);
// marker1.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>