<html>

<body>

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
$companyname = $_POST["company"];
$url = "http://api.crunchbase.com/v/1/company/" . $companyname. ".js?api_key=8nz6hbar9ysw3kqtuagqgsy9";
$json = file_get_contents($url);
$data = json_decode($json, TRUE); 

$companyname = $data['permalink'];

$companypage = $data['homepage_url'];

$companylogo = "http://s3.amazonaws.com/crunchbase_prod_assets/".$data['image']['available_sizes'][0][1];

$companystaff =  $data['number_of_employees'];

$companyage =  2013 - $data['founded_year'];
// echo gettype($companyage);
$companydescription = $data['overview'];

// -------------------------------

//get all the offices within USA, push all the locations to $locations
$officesnumber = sizeof($data['offices']);
$locations = array("");
$temp = "";
for ($i=0;$i<=$officesnumber-1;$i++)
 	if ($data['offices'][$i]['country_code'] == "USA")
 	{	
 		array_push($locations,$data['offices'][$i]['state_code']);
 	}
$locations = array_unique($locations);


//similarly, get the companyfields like getting locations

$companyfield = $data['tag_list'];
$fieldlist = explode(", ",$companyfield);
foreach($fieldlist as $single)
echo $single.'\n';
?>


you are going to add information of <?php echo $companyname; ?> to DB...</br>


<?php 
if ($companyname==NULL)
	echo "qunimade";
else
{
	//$name_requested = mysqli_query($con,"SELECT sqlsentence,texture FROM exer2 WHERE sqlsentence = \"".$companyname."\"");//table name exer2
	$firstrequest = mysqli_query($con,"SELECT CompanyID FROM companies WHERE CompanyName = '$companyname'");//table name exer2
	$company = $firstrequest->fetch_array(MYSQLI_NUM);
	if ($company!== NULL)//update old information
	{
	 echo $companyname." is already in DB, we will update the information with pleasure";

	 mysqli_query($con,"UPDATE companies SET CompanyName = '$companyname',CompanyPage='$companypage',CompanyLogo = '$companylogo',CompanyStaff = '$companystaff',
	 	CompanyDescription = '$companydescription', CompanyAge='$companyage' WHERE CompanyID = '$company[0]';");
	


	}
	else//add new row in to table
	{	  	
	//company table
	$sql = mysqli_query($con, "INSERT INTO companies (CompanyName,CompanyPage,CompanyLogo,CompanyStaff,CompanyDescription,CompanyAge,AverageRate) 
	VALUES ('$companyname','$companypage','$companylogo','$companystaff','$companydescription','$companyage',0)");
	//$sql = mysqli_query($con, "INSERT INTO companies (CompanyName) VALUES ('$companyname')");
	if(!$sql) 
	die("Met trouble in DB..."); 
	else 
	echo "yeah, record added to DB for ".$companyname;		
	
	$firstrequest = mysqli_query($con,"SELECT CompanyID FROM companies WHERE CompanyName = '$companyname'");//get company
	$company = $firstrequest->fetch_array(MYSQLI_NUM);
	//echo $company[0];
	//company <-> location table
	foreach($locations as $eachlocation)
	{
		//echo $eachlocation;
		$secondrequest = mysqli_query($con,"SELECT LocationID FROM locations WHERE State = '$eachlocation'");//get state
		$state = $secondrequest->fetch_array(MYSQLI_NUM);
		//echo $state[0];

		mysqli_query($con, "INSERT INTO company_locations (CompanyID,LocationID) VALUES ('$company[0]','$state[0]');");
	}
	
	}
	mysqli_close($con);
}

?>
</body>
</html>

