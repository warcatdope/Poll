<?php include "header.php";?>

      <div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
            <li><a href="index.php">Main</a></li>
          </ul>
        </div>
        
        <div id="main">
<?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
         $db = new PDO("mysql:host=localhost;dbname=gillilandr",'gillilandr','12345');
	            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	      	
	      	    // varibles from the user input
	      	    $pollQuestion = $_POST['question'];	
	      			$choice1= $_POST['choiceone'];
					    $choice2= $_POST['choicetwo'];
							$choice3= $_POST['choicethree'];
							$enddate= $_POST['enddate'];
							
					$pushquestion = "Insert into polls(question,starts,ends) values (:question,curdate(),:end)";
					$questionin = $db ->prepare($pushquestion);
					$questionin->bindParam(":question", $pollQuestion);
     		  $questionin->bindParam(":end", $enddate);
     		 	$questionin->execute();
					
					$getquestion	="select id from polls
													where question = :question
													and ends= :end";
					$questionoutid = $db ->prepare($getquestion);
					$questionoutid->bindParam(":question", $pollQuestion);
     		  $questionoutid->bindParam(":end", $enddate);
     		 	$questionoutid->execute();
					$polldbid= $questionoutid->fetch();
					$pollid=$polldbid ['id'];
					
					
					$pushchoices = "Insert into polls_choices(poll,name) values (:id,:choice)";
					$choicein = $db ->prepare($pushchoices);
					$choicein->bindParam(":id", $pollid);
     		  $choicein->bindParam(":choice", $choice1);
     		 	$choicein->execute();
					
					$pushchoices = "Insert into polls_choices(poll,name) values (:id,:choice)";
					$choicein = $db ->prepare($pushchoices);
					$choicein->bindParam(":id", $pollid);
     		  $choicein->bindParam(":choice", $choice2);
     		 	$choicein->execute();
					
					$pushchoices = "Insert into polls_choices(poll,name) values (:id,:choice)";
					$choicein = $db ->prepare($pushchoices);
					$choicein->bindParam(":id", $pollid);
     		  $choicein->bindParam(":choice", $choice3);
     		 	$choicein->execute();
			?>	
<h2>Your Poll was created! 
					</h2>
		<?php die();
					}
	?>
          
        <div id="form">
         <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   
    
    <input name="question" type="text" id="question" placeholder="Poll Question" value='<?php
        if((isset($_POST['question'])) && (strlen($_POST['question']) > 0))
          echo $_POST['question'];?>' ><br>
	
		
    <input name="choiceone" type="text" id="choiceone" placeholder="Answer Choice 1" value='<?php
        if((isset($_POST['choiceone'])) && (strlen($_POST['choiceone']) > 0))
          echo $_POST['choiceone'];?>' ><br>
	   <input name="choicetwo" type="text" id="choicetwo" placeholder="Answer Choice 2" value='<?php
        if((isset($_POST['choicetwo'])) && (strlen($_POST['choicetwo']) > 0))
          echo $_POST['choicetwo'];?>' ><br>
		  <input name="choicethree" type="text" id="choicethree" placeholder="Answer Choice 3" value='<?php
        if((isset($_POST['choicethree'])) && (strlen($_POST['choicethree']) > 0))
          echo $_POST['choicethree'];?>' ><br>
		 End Date:
		 <input type="date" name="enddate"  id="enddate" placeholder="enddate" value='<?php
        if((isset($_POST['enddate'])) && (strlen($_POST['enddate']) > 0))
          echo $_POST['enddate'];?>' ><br>
					 <br>
	 
	
	  <input type="submit" value="Submit Poll" name="submit" />
	 
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