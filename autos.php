<!DOCTYPE html>
<html>
<head>
	<title>Prasanna More</title>
</head>
<body>
<?php
if(!isset($_GET['name']))
{die("name parameter missing");}

echo('<h1>'.htmlentities($_GET['name'])."</h1>\n");
if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

  
$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['year']) && isset($_POST['mileage']) ) {
    if ( strlen($_POST['make']) < 1 ) {
        //error_log("Login fail ".$_POST['who']);
        $failure = "Make is required";
    }
    elseif (!is_numeric($_POST['year'])||!is_numeric($_POST['mileage'])) {
        $failure = "year and mileage should be numeric";
     } 

    else {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
 $stmt = $pdo->prepare('INSERT INTO autos
        (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':mi' => $_POST['mileage'])
    );
	echo ('<p style="color: green;">'."record added succesfully"."</p>\n");
        } 
    }
?>
	<form method="POST">
	<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
?>
	<label for="make">Make</label>
     <input type="text" name="make" id="make"><br/>
    <label for="year">Year</label>
     <input type="text" name="year" id="year"><br/>
    <label for="mileage">Mileage</label>
     <input type="text" name="mileage" id="mileage"><br/>

     <input type="submit" name="Add" value="Add">
     <input type="submit" name="logout" value="logout">
 </form>
 <h3>Automobiles</h3>
 	<?php
 	     $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'fred', 'zap');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
 $stmt = $pdo->prepare('SELECT * FROM autos');
    $stmt->execute(array());
    while($result = $stmt->fetch(PDO::FETCH_ASSOC))
    echo ($result['year'].$result['make']."/".$result['mileage']."</br>");
    ?>

</body>
</html>