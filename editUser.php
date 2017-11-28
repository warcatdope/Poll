<?php
include "header.php";

?>
      <div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
            <li><a href="main.php">Main</a></li>
          </ul>
        </div>
        <div id="main">
 <h2>Make corrections only to the areas you need changing</h2>
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
	      			$password = md5($_POST['password']);
	      	    $email = $_POST['email'];
              $accid = $_SESSION['id'];
             
	      			
             		
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
	      	
	      			//Puts in the users current information
	      			if($same == 1)
	      			{
	      				$username = $_SESSION['username'];
	      				print "<p>Username already taken Try Again.</p>";
	      			}
	      			
	      	    if(empty($username))
	      			{
	      	    	$username = $_SESSION['username'];
	      	    }
	      			 if(empty($givenName))
	      			{
	      	    	$givenName = $_SESSION['firstname'];
	      	    }
	      			if(empty($familyName))
	      			{
	      	    	$familyName = $_SESSION['lastname'];
	      	    }
	      	    if(empty($email))
	      	    {
	      	     	$email = $_SESSION['email'];
	      	    }		
	      			if(empty($password))
	      			{
	      	    	$password = $_SESSION['password'];
	      	    }
	      	   
              if($username && $email && $givenName && $familyName && $password)
							{
		       			
	      		    $stmt = $db->prepare("UPDATE poll_users SET username = '$username', given_name = '$givenName', family_name = '$familyName', 
                                      email = '$email', password = '$password' WHERE id= '$accid'");           
	      		    //execute the prepared statement		
	      		    $stmt->execute();
	      			  print "Your Account has been updated";	
	      	    }
        }//end of validate
	?>
          
        <div id="form">
         <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   
    
    <input name="username" type="text" id="username" placeholder="<?php echo $_SESSION['username'] ?>" value='<?php
        if((isset($_POST['username'])) && (strlen($_POST['username']) > 0))
          echo $_POST['username'];?>' ><br>
	
		
    <input name="givenName" type="text" id="givenName" placeholder="<?php echo $_SESSION['firstname'] ?>" value='<?php
        if((isset($_POST['givenName'])) && (strlen($_POST['givenName']) > 0))
          echo $_POST['givenName'];?>' ><br>
	 
	  
    <input name="familyName" type="text" id="familyName" placeholder="<?php echo $_SESSION['lastname'] ?>" value='<?php
        if((isset($_POST['familyName'])) && (strlen($_POST['familyName']) > 0))
          echo $_POST['familyName'];?>' ><br>
	
    
    <input name="email" type="text" id="email" placeholder="<?php echo $_SESSION['email'] ?>"  value='<?php
        if((isset($_POST['email'])) && (strlen($_POST['email']) > 0))
          echo $_POST['email'];?>' ><br> 
    
    
    <input name="password" type="password" id="password" placeholder=" Change Password" value='<?php
        if((isset($_POST['password'])) && (strlen($_POST['password']) > 0))
          echo $_POST['password'];?>' ><br>
	
	  <input type="submit" value="Change" name="submit" />
	 
</form>
                
<?php
	include "footer.php";
?>