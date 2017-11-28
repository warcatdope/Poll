<?php
include "header.php";

$pollsQuery = $db->query("
			SELECT id, question
			FROM polls
");

while($row = $pollsQuery->fetchObject()) {
		$polls[] = $row;
}

?>
      <div id="content">
        <div id="nav">
          <h3>Navigation </h3>
          <ul>
            <li><a href="index.php">Main</a></li>
						<li><a href="editUser.php">Edit Account</a></li>
          </ul>
        </div>
        
        <div id="main">

				<?php if(!empty($polls)): ?>
						<ul>
							<?php foreach($polls as $poll): ?>
							<li><a href="poll.php?poll=<?php echo $poll->id; ?>"><?php echo $poll->question; ?></a></li>
							<?php endforeach; ?>
						</ul>
				<?php else: ?>
					<p>
						Sorry, no polls available right now.
					</p>
				<?php endif; ?>
				
<?php
	include "footer.php";
?>     