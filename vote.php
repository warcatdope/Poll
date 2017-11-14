<?php
include "header.php";

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
		header('Location: poll.php?poll=' . $poll);
}

header('Location: main.php');

?>
     