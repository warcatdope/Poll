<?php
session_start();
$_SESSSION['user_id'] =1;

$DB_host = "localhost";
$DB_user = "gillilandr";
$DB_pass = "12345";
$DB_name = "gillilandr";

try
{
	$db = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo $e->getMessage();
}


if(!isset($_GET['poll'])) {
	header('Location: main.php');	
} else {
	$id = (int)$_GET['poll'];
	// Get general poll information
	$pollQuery = $db->prepare("
				SELECT id, question
				FROM polls
				WHERE id = :poll
	");
	
	$pollQuery -> execute(array('poll' => $id));
	
	$poll = $pollQuery->fetchObject();
	//Get the user answer for the polls
	$answerQuery = $db->prepare("
		SELECT polls_choices.id AS choice_id, polls_choices.name AS choice_name
		FROM polls_answers
		JOIN polls_choices
		ON polls_answers.choice = polls_choices.id
		WHERE polls_answers.user = :user
		AND polls_answers.poll = :poll
	");
	$answerQuery -> execute(array('user' => $_SESSION['user_id'], 'poll' => $id));

	// Has the user completed the poll
	$completed = $answerQuery->rowcount() ? true : false;
	
	if($completed) {
		// get answers
		$answersQuery = $db->prepare("
				SELECT
				polls_choices.name,
				COUNT(polls_answers.id) * 100 / (
				SELECT COUNT(*)
				FROM polls_answers
				WHERE polls_answers.poll = :poll) AS percentage
				FROM polls_choices
				LEFT JOIN polls_answers
				ON polls_choices.id = polls_answers.choice
				WHERE polls_choices.poll = :poll
				GROUP BY polls_choices.id
		");
		$answersQuery->execute(array(
				'poll' => $id));
		// Extract the answers
			while($row = $answersQuery->fetchObject()) {
				$answers[] = $row;
			}
	} else {
	     //Get poll choices
		   $choicesQuery = $db->prepare("
					SELECT polls.id, polls_choices.id AS choice_id, polls_choices.name
					FROM polls
					JOIN polls_choices
					ON polls.id = polls_choices.poll
					WHERE polls.id = :poll
		    ");
		   $choicesQuery -> execute(array('poll' => $id));
	     // Extract choices
	    while($row = $choicesQuery->fetchObject()) {
		  $choices[] = $row;
	    }
	}
}

?>
<html>
  <head>
    <title>Voting Poll</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1><img src="cybercat1.jpg" title=" " alt=" " /></h1>
      </div>
      <div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
            <li><a href="index.php">Main</a></li>
            <li><a href="main.php">Polls</a></li>
          </ul>
        </div>
        
        <div id="main">	
  
<!-- Place HTML here for the client page -->
<?php if(!$poll): ?>
					<p>That poll doesn't exist</p>
<?php else: ?>				
   <div class="poll">
			<div class="poll-question">
				<?php echo $poll->question; ?>
			</div>
		 
		 <?php if($completed): ?>
		 	<p>
				 You have completed the poll, Thank You
		 </p>
		 <ul>
			 
		 <?php foreach($answers as $answer): ?>
		 	<li><?php echo $answer->name; ?> (<?php echo number_format($answer->percentage, 2); ?>%)</li>
		 <?php endforeach; ?>
		 </ul>
		 <?php else: ?>
		 <?php if(!empty($choices)): ?>
			<form action="vote.php" method="post">	
				<div class="poll-options">
					
						<?php foreach($choices as $index => $choice): ?>
						<div class="poll-option">
								<input type="radio" name="choice" value="<?php echo $choice->choice_id ?>" id="c<?php echo $index; ?>">
								<label for="c<?php echo $index; ?>"><?php echo $choice->name; ?></label>
						</div>
					<?php endforeach; ?>
				</div>
				<input type="submit" value="Submit Answer">
				<input type="hidden" name="poll" value="<?php echo $id; ?>">
			</form>
		 <?php else: ?> 
		 	<p>
				There are no choices right now.
		 </p>
		 <?php endif; ?>
		 <?php endif; ?>
   </div>
<?php endif; ?>
		
<?php
	include "footer.php";
?>
		