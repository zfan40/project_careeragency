<html>

<body>

<?php
// Create connection
$con=mysqli_connect("localhost","root","root","ex_two");
//$con=mysqli_connect("db.iac.gatech.edu","ex","HosKfNlB","ex");
// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>



Welcome <?php echo $_POST["name"]; ?><br>
<?php 
$companyname = $_POST["company"];
$url = "http://api.crunchbase.com/v/1/company/" . $companyname. ".js?api_key=8nz6hbar9ysw3kqtuagqgsy9";
$json = file_get_contents($url);
$data = json_decode($json, TRUE); 


?>

We have some information about <?php echo $companyname; ?> you might have interest.</br>


<?php 
	//$name_requested = mysqli_query($con,"SELECT sqlsentence,texture FROM exer2 WHERE sqlsentence = \"".$companyname."\"");//table name exer2
	$name_requested = mysqli_query($con,"SELECT sqlsentence,texture FROM exer2 WHERE sqlsentence = '$companyname'");//table name exer2
	//$row = mysqli_fetch_array($name_requested)
	$row = $name_requested->fetch_array(MYSQLI_NUM);
	if ($row!== NULL)
	{echo "searched before, data will be derived from DB</br>";
	 echo $row[1];}
	else
	{
	  	$chair = $data["relationships"][0]["person"]["first_name"]." ".$data["relationships"][0]["person"]["last_name"]; 
	  	$foundyear = $data["founded_year"];
	  	$staff = $data["number_of_employees"];
	  	if ($staff == null)
	  	{$staff = "numerous";}
		if ($data["name"])
		{
		$description = "Since ".$foundyear .", ". $chair. " has employed ". $staff. " people.";
		//write into DB, company name
		$sql = mysqli_query($con, "INSERT INTO exer2 (sqlsentence,texture)	
		VALUES (\"". $data["permalink"]. "\", \"". $description."\")");//id auto incremented, no need to be in this SQL sentence. table name exer2

		if(!$sql) 
		{die("Nope");} 
		else 
		{echo "1 record added</br>";}

		mysqli_close($con);
		echo $description;
		}
		else
		{echo "nothing found</br>";}
	}
?>
</body>
</html>