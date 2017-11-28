<?php
include "header.php";
?>
      <div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
						
            <li><a href="createUser.php">Create New User</a></li>
          </ul>
        </div>
        
        <div id="main">
        
<?php
/***************************** HANDLING CLIENT LOGOUT *******************************/

	if(isset($_POST['logout']))
	{
		$_SESSION = array();
		session_destroy();
?>
		<!-- Once we start outputting HTML, 
		     we can no longer do anything involving headers -->
		<h1>Thank You for Visting</h1>
<?php
	}

/************************** HANDLING CLIENT LOGIN ATTEMPT ***************************/
	if((isset($_POST['username']))
		&&(isset($_POST['password']))
		&&(isset($_POST['loginbutton'])))
	{
		// Begin by attempting to connect to the database containing the users
		try
		{
			$db = new PDO("mysql:host=localhost;dbname=gillilandr", "gillilandr", "12345");
			
		}
		catch (Exception $error) {  //If attempt failed, send error
			die("Connection to user database failed: " . $error->getMessage());
		}
		
		// Now, let's try to access the database table containing the users
		try
		{
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "SELECT * FROM poll_users WHERE username = :user and password = :pw";
			$statement = $db -> prepare($query);
			$statement -> execute(array(
				'user' => $_POST['username'], 
				'pw' => md5($_POST['password']))
			);
			if ($statement -> rowCount() == 1)
			{
				$_SESSION['loggedin']=TRUE;
				// Get the user details from the SINGLE returned database row
				$row = $statement -> fetch();
				$_SESSION['firstname'] = $row['given_name'];
				$_SESSION['lastname'] = $row['family_name'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['email'] = $row['email'];
				//change to user_id
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['password'] = $row['password'];
				
			}
			else
				echo("<h3>Invalid userid or password</h3><h3>A common mistake that people make when trying to design something
				completely foolproof is to underestimate the ingenuity of complete fools.
				</h3>");		

			// Close the statement and the database
			$statement = null;
			$db = null;
		}
		catch (Exception $error) 
		{
			echo "Error occurred accessing user privileges: " . $error->getMessage();
		}
	}

/*********************** PRESENTING CLIENT WITH LOGIN SCREEN ************************/
	if(!isset($_SESSION['loggedin']))
	{
?>
		<h2>Login</h2>		
		<div id="form">			
		<form name='login' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
		<input type='text' name='username' placeholder='Username'/><br />
		<input type='password' name='password' placeholder='Password'/><br />
		<input type='submit' name='loginbutton' value='Click here to log in' />
		</form>
		</div>
<?php
	}
/****************** PRESENTING LOGGED IN CLIENT WITH BASIC SCREEN *******************/
	if(isset($_SESSION['loggedin']))
	{
		
?>		
<!-- Place HTML here for the client page -->
		<h2>
			Welcome,  
			<?= $_SESSION['firstname'] ?> 
			<?= $_SESSION['lastname'] ?> to the<br> voting poll<br>
		</h2>
		<div id="form">		
			<form name='home' method='post' action='main.php'>
			<input type='submit' value='View Polls'	name='home'>
			</form>
			<form name='home' action='create_poll.php'>
				<input type='submit' value='Create a Poll' name='home'>
			</form>
		<form name='logout' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' >
			<input type='submit' value='Click to logout' name='logout'>
		</form>
		</div> 
<?php
	}
	include "footer.php";
?>
		
