<div class='bill wpcongress-box'>
<h3 class="bill-title">
<?php echo $b->bill->code." ".$b->bill->short_title; ?></h3>
<p class="bill-official"><?php echo $b->bill->official_title;?></p>
<p class="bill-status"><?php echo $b->bill->state;?></p>
	<div id="bill-votes">
	<h4 class="bill-head">
	<a href="#" onclick="jQuery('.bill-votes').toggle(); return false;">
		Votes</a></h4>
	<ul class="bill-votes collapse">
	<?php foreach($b->bill->votes as $a) { ?>
		<li class="bill-vote"><span class="date"><?php echo date('Y-m-d',strtotime($a->voted_at)); ?></span> <span class="vote-result"> <?php echo $a->result; ?></span> - <?php echo $a->text; ?></li>
	<?php  } ?> 
	</ul>
	</div>
	<div id="bill-actions">
		<h4 class="bill-head">
		<a href="#" onclick="jQuery('.bill-actions').toggle(); return false;">
		Actions</a></h4>	
		<ul class="bill-actions collapse">
	<?php foreach($b->bill->actions as $a) { ?>
		<li class="bill-action"><span class="date"><?php echo date('Y-m-d',strtotime($a->acted_at)); ?></span> <?php echo $a->text; ?></li>
	<?php  } ?> 
		</ul>
	</div>
	<div id="bill-sponsors">
		<h4 class="bill-head">
		<a href="#" onclick="jQuery('.bill-sponsors').toggle(); return false;">
		Sponsors</a></h4>	
		<div class="bill-sponsors collapse">
			<p class="sponsor"><?php echo $b->bill->sponsor->title." ".$b->bill->sponsor->first_name." ".$b->bill->sponsor->last_name." (".$b->bill->sponsor->party." - ".$b->bill->sponsor->state." ".$b->bill->sponsor->district.")"; ?></p>
				<p><?php echo $b->bill->cosponsors_count;?> Cosponsors</p>
				<ul class="bill-cosponsors">
					<?php asort($b->bill->cosponsors); 	 if($b->bill->cosponsors_count > 0) { foreach($b->bill->cosponsors as $a) { ?>
					<li class="bill-cosponsor"><?php echo $a->first_name." ".$a->last_name." (".$a->party." ".$a->state." ".$district.")"; ?></li>
					<?php  } ?> 
				</ul><?php } ?>
					<p style="clear:both"></p>
		</div>
	</div>
</div>