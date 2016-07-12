<?php

// *** FUNCTIONS ***

function checkEmailExists() {
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $emailCheck;
		
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT email FROM comments WHERE email = :emailCheck");
		$stmt->bindParam(':emailCheck', $emailCheck);
		$stmt->execute();
		
		// return rows affected by query
		return $stmt->rowCount();
		
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;
}

function insertComment() {
			
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $emailCheck;
		
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		// prepare sql and bind parameters
		$stmt = $conn->prepare("INSERT INTO comments (date, time, name, email, comment) 
		VALUES (CURDATE(), CURTIME(), :name, :email, :comment)");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':comment', $comment);
	
		// insert a row
		$name = $_POST['hName'];
		$email = $_POST['hEmail'];
		$comment = $_POST['hComment'];
		$stmt->execute();
	
	} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
	}
	$conn = null;
}

function showComments() {
	
	global $servername;
	global $username;
	global $password;
	global $dbname;
	global $emailCheck;
	
	try {
		
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		// prepare sql and bind parameters
		$stmt = $conn->prepare("SELECT date, name, comment FROM comments ORDER BY date desc, time desc");
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		// start panel group
		?> <div class="panel-group"> <?php
		
		// display results on view guestbook page
		// date("F j Y", strtotime($row['date']))  $row['date']
		foreach($result as $row) {
			?>
        <div class="panel panel-info">
          <div class="panel-heading">
          	<h3 class="h3"><strong><?php echo $row['name'] ?></strong></h3><?php echo date("F j, Y", strtotime($row['date'])) ?>
          </div>
          <div class="panel-body">
						<?php echo $row['comment'] ?>
          </div>
        </div>
      <?php
		}
		
		// end panel group
		?> </div> <?php
		
	} catch(PDOException $e) {
			echo "Error: " . $e->getMessage();
	}
	$conn = null;
}

// *** END FUNCTION ***
		
// *** USE FUNCTIONS ***

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['hName']) && isset($_POST['hEmail']) && isset($_POST['hComment'])) {
	
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "guestbook";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		$nameCheck = mysqli_real_escape_string($conn, $_POST['hName']);
		$emailCheck = mysqli_real_escape_string($conn, $_POST['hEmail']);
		$commentCheck = mysqli_real_escape_string($conn, $_POST['hComment']);
		
		$queryCheck = checkEmailExists();
		
		// if a comment is inserted into the database, then the success message will display
		// if the email already exists in the database, then the error message will display
		// and no insert will occur
		if($queryCheck > 0) {
			?>
			<div class="alert alert-danger fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Error:</strong> This email already exists. Thanks for your previous comment. You can view the guestbook <a href="../guestbook/view-guestbook.php">here</a>.
			</div>
			<?php
		} else {
			?>
			<div class="alert alert-success fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Success:</strong> New comment created successfully! You can view the guestbook <a href="../guestbook/view-guestbook.php">here</a>.
			</div>
			<?php
			insertComment();
		}
	} else {
		?>
    <div class="alert alert-danger fade in">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Error:</strong> You must fill out all fields.
    </div>
    <?php
	}
}

// guestbook posts will only show on the view guestbook page
if($_SERVER['REQUEST_URI'] == '/guestbook/view-guestbook.php') {
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "guestbook";
	
	showComments();
}

// *** END USE FUNCTIONS ***

?>