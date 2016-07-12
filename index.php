<?php
	include_once("header.php");		//include the header
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center">Guestbook with Bootstrap, PHP, and MySQL</h1>
    </div>
  </div>
</div>

<hr>

<div class="container">
  <div class="alert-info">
	<!-- Include functions library -->
	<?php include_once("includes/functions.php"); ?>
  </div>
  
  <form action="index.php" method="post">
    <div class="form-group">
    	<label for="hName">Name</label>
      <input type="text" class="form-control" id="hName" placeholder="Name (required)" name="hName" maxlength="50" required>
    </div>
    <div class="form-group">
      <label for="hEmail">Email Address</label>
      <input type="email" class="form-control" id="hEmail" placeholder="Email Address (required)" name="hEmail" maxlength="50" required>
    </div>
    <div class="form-group">
      <label for="comment">Comment:</label>
      <textarea class="form-control" rows="5" id="hComment" placeholder="Comment (required)" name="hComment" maxlength="500" required></textarea>
    </div>
    <button type="submit" class="btn btn-success" name="submit">Submit</button>
</form>
</div>
  
<?php
	include_once("footer.php");		//include the footer
?>