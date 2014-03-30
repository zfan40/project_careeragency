<html>

<body>

<?php
// Create connection
$con=mysqli_connect("localhost","root","root","projectone");
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

echo $data['permalink'];
echo "next\n";
echo $data['homepage_url'];
echo "next\n";
echo $data['number_of_employees'];
echo "next\n";
echo $data['founded_year'];
echo "next"+"\n";
echo $data['tag_list'];
echo "next\n";
echo $data['overview'];
echo "next\n";
echo "crunchbase.com/".$data['image']['available_sizes'][0][1];
echo "next\n";
?>

you are going to add information of <?php echo $companyname; ?> to DB. If it exists...</br>


<?php 

	//$name_requested = mysqli_query($con,"SELECT sqlsentence,texture FROM exer2 WHERE sqlsentence = \"".$companyname."\"");//table name exer2
	$name_requested = mysqli_query($con,"SELECT companyname,staffnumber, FROM companies WHERE companyname = '$companyname'");//table name exer2
	//$row = mysqli_fetch_array($name_requested)
	$row = $name_requested->fetch_array(MYSQLI_NUM);
	if ($row!== NULL)
	{echo "information updated";
	 echo $row[1];
	 //update the row
	}
	else
	{
	  	echo "else";
	  	$chair = $data["relationships"][0]["person"]["first_name"]." ".$data["relationships"][0]["person"]["last_name"]; 
	  	$foundyear = $data["founded_year"];
	  	$staff = $data["number_of_employees"];
	  	if ($staff == null)
	  	{$staff = "numerous";}
		if ($data["name"])//if api could get info about that company
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