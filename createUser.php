<html>
  <head>
    <title>Voting Poll</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1><img src="cybercat2.jpg" title=" " alt=" " /></h1>
      </div>
      <div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
            <li><a href="index.php">Login</a></li>
          </ul>
        </div>
        
        <div id="main">
          <h2>Create User</h2>
  <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
	      	
          validate();
        }
        
        function validate()
        {
	      	    $db = new PDO("mysql:host=localhost;dbname=gillilandr",'gillilandr','12345');
	            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	      	
	      	    // varibles from the user input
	      	    $username = $_POST['username'];
	      			$givenName = $_POST['givenName'];
	      			$familyName = $_POST['familyName'];
	      			$password = $_POST['password'];
	      			$passwordRetry = $_POST['passwordRetry'];
	      	    $email = $_POST['email'];
	      			
             		
	      			/*Gets the databases usernames and compares with the one inputed
	      			   by the user if the same tells the user to input another name*/
	      			$same = 0;
	      			$db_usernames = array();
	      			$result = $db->query("SELECT username from poll_users");
	      			foreach($result as $row)
	      			{
	      				$db_usernames[] = $row['username'];
	      			}
	      			for($x=0; $x < sizeof($db_usernames); $x++)
	      			{
	      				$compare_username = $db_usernames[$x];
	      				if($username == $compare_username)
	      					$same = 1;
	      			}
	      	
	      			//checks to see if something is blank or duplicated and sends message
	      			if($same == 1)
	      			{
	      				$username = NULL;
	      				print "<p>Username already taken Try Again.</p>";
	      			}
	      			
	      	    if(empty($username))
	      			{
	      	    	$username = NULL;
	      	    	print "<p>Please enter a Username.</p>";
	      	    }
	      			 if(empty($givenName))
	      			{
	      	    	$givenName = NULL;
	      	    	print "<p>Please enter a First Name.</p>";
	      	    }
	      			if(empty($familyName))
	      			{
	      	    	$familyName = NULL;
	      	    	print "<p>Please enter a Last Name.</p>";
	      	    }
	      	    if(empty($email))
	      	    {
	      	     	$email = NULL;
	      	     	print "<p>Please enter your Email Address.</p>";
	      	    }		
	      			if(empty($password))
	      			{
	      	    	$password = NULL;
	      	    	print "<p>Please enter a Password.</p>";
	      	    }
	      			if(empty($passwordRetry))
	      			{
	      	    	$passwordRetry = NULL;
	      	    	print "<p>Renter password</p>";
	      	    }
	      	    
	      	
	      			/*if all the user has filed in all values it checks to see if the password and the 
	      				reenter password match then it proceeds to adding it to the database.
	      			*/
	      	    if($username && $email && $givenName && $familyName && $password && $passwordRetry)
	      			{
	      	       if($passwordRetry != $password)
	      			   {
	      			   	print "passwords dont match";
	      			   }
	      			   	else
	      					{
	      				
	      		              $stmt = $db->prepare("INSERT INTO poll_users(username, given_name, family_name, email, password) VALUES(:uname, :fname, :lname, :email, :password)");
                          $stmt->bindparam(":uname",$username);
	      		              $stmt->bindparam(":fname",$givenName);
	      		              $stmt->bindparam(":lname",$familyName);
	      		              $stmt->bindparam(":email",$email);
	      		              $stmt->bindparam(":password",md5($password));
	      		              
	      		              //execute the prepared statement		
	      		              $stmt->execute();
	      						print "User has been Added Succesfully";
	      					}
	      					
	      	    }
        }//end of validate
	?>
          
        <div id="form">
         <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   
    
    <input name="username" type="text" id="username" placeholder="Username" value='<?php
        if((isset($_POST['username'])) && (strlen($_POST['username']) > 0))
          echo $_POST['username'];?>' ><br>
	
		
    <input name="givenName" type="text" id="givenName" placeholder="First Name" value='<?php
        if((isset($_POST['givenName'])) && (strlen($_POST['givenName']) > 0))
          echo $_POST['givenName'];?>' ><br>
	 
	  
    <input name="familyName" type="text" id="familyName" placeholder="Last Name" value='<?php
        if((isset($_POST['familyName'])) && (strlen($_POST['familyName']) > 0))
          echo $_POST['familyName'];?>' ><br>
	
    
    <input name="email" type="text" id="email" placeholder="Email"  value='<?php
        if((isset($_POST['email'])) && (strlen($_POST['email']) > 0))
          echo $_POST['email'];?>' ><br> 
    
    
    <input name="password" type="password" id="password" placeholder="Password" value='<?php
        if((isset($_POST['password'])) && (strlen($_POST['password']) > 0))
          echo $_POST['password'];?>' ><br>
	
  	
    <input name="passwordRetry" type="password" id="passwordRetry" placeholder="Renter Password" value='<?php
        if((isset($_POST['passwordRetry'])) && (strlen($_POST['passwordRetry']) > 0))
          echo $_POST['passwordRetry'];?>' ><br>
	
	  <input type="submit" value="Sign Up" name="submit" />
	 
</form>
        </div>
       </div>
      </div>
      <div id="footer">
        Copyright &copy; 2017 Purrfect Software
      </div>
    </div>
  </body>
</html>