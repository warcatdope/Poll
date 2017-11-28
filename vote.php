<?php
include "header.php";
?>
<div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
						<li><a href="main.php">Return to Poll</a></li>
            <li><a href="index.php">Main</a></li>
          </ul>
        </div>
        
        <div id="main">
<?php
if(isset($_POST['poll'], $_POST['choice'])) {
	$poll = $_POST['poll'];
	$choice = $_POST['choice'];


	$voteQuery = $db->prepare("
			INSERT INTO polls_answers (user, poll, choice)
			SELECT :user, :poll, :choice
			FROM polls
			WHERE EXISTS (
				SELECT id
				FROM polls
				WHERE id = :poll)
			AND EXISTS (
				SELECT id
				FROM polls_choices
				WHERE id = :choice
				AND poll = :poll)
				
		");
	$voteQuery -> execute(array('user' => $_SESSION['user_id'], 'poll' => $poll, 'choice' => $choice));

}

?>
   <h1>Thank you for your vote</h1>  