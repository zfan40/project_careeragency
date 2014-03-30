<html>
<body>

<h1>
	Welcome to Career Fair Agency.</br>
</h1>

<p>	Find out your next working oppotunity.</p>
<?php 
if ($_POST["username"]!=NULL && $_POST["password"]!=NULL)
echo "successfully signed up!";
 ?>
<form action="list.php" method="post">

Username:<input type="text" name="username"><br>

Password:<input type="password" name="password"><br>

<input type="submit" value="Sign in">

</form>

</body>
</html>
