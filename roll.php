<div class='roll wpcongress-box'>
<h3 class="roll-title">
<?php echo $b->roll->question." (<small>".$b->roll->bill_id; ?>)</small></h3>
<p class="roll-summary"><?php echo $b->roll->result;?></p>
	<h4 class="breakdown-head">
	<a href="#" onclick="jQuery('.votes-breakdown').toggle(); return false;">
		Vote Breakdown</a></h4>
	<ul class="votes-breakdown">
		<li class="wpcongress_ayes">Ayes: <?php echo $b->roll->vote_breakdown->ayes;?></li>
		<li class="wpcongress_nayes">Nays: <?php echo $b->roll->vote_breakdown->nays;?></li>
		<li class="wpcongress_pres">Present: <?php echo $b->roll->vote_breakdown->present;?></li>
		<li class="wpcongress_novo">Not Voting: <?php echo $b->roll->vote_breakdown->not_voting;?></li>
	</ul>
	<?php foreach($b->roll->party_vote_breakdown as $key => $a) { ?>
		<h4 class="breakdown-head">
	<a href="#" onclick="jQuery('.<?php echo $key ?>-votes').toggle(); return false;">
		<?php echo $key ?> Vote Breakdown</a></h4>
	<ul class="<?php echo $key ?>-votes votes-party-breakdown">
		<li class="wpcongress_ayes">Ayes: <?php echo $a->ayes;?></li>
		<li class="wpcongress_nayes">Nays: <?php echo $a->nays;?></li>
		<li class="wpcongress_pres">Present: <?php echo $a->present;?></li>
		<li class="wpcongress_novo">Not Voting: <?php echo $a->not_voting;?></li>
	</ul>
	<?php } 
	foreach($b->roll->voter_ids as $key => $val) {
		if($val=='+') { $ayes[] = $key; }
		if($val=='-') { $nays[] = $key; }
		if($val=='p') { $pres[] = $key; }

	}
	asort($ayes); 	asort($nays);
	echo '<div class="ayes-list"> <h4>	
	<a href="#" onclick="jQuery(\'.votes-ayes\').toggle(); return false;">Ayes</a></h4><ul class="votes-ayes voter-list collapse">';
	foreach($ayes as $a) {
	echo "<li>".$b->roll->voters->$a->voter->last_name." (".$b->roll->voters->$a->voter->state." ".$b->roll->voters->$a->voter->district.")</li>";
	}
	echo '</div><div class="nays-list"></ul><h4><a href="#" onclick="jQuery(\'.votes-nays\').toggle(); return false;">Nays</a></h4><ul class="votes-nays voter-list collapse">';
	foreach($nays as $a) {
	echo "<li>".$b->roll->voters->$a->voter->last_name." (".$b->roll->voters->$a->voter->state." ".$b->roll->voters->$a->voter->district.")</li>";
	}
	
	echo '</ul></div>';
	
	/*<div style="clear:both"><h4>Present</h4><ul class="votes-pres voter-list">';
	foreach($pres as $a) {
	echo "<li>".$b->roll->voters->$a->voter->last_name." (".$b->roll->voters->$a->voter->state." ".$b->roll->voters->$a->voter->district.")</li>";
	}
	echo "</ul></div>";*/
	?>
	<p style="clear:both"></p>
</div>