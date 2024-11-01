<div class='legislator wpcongress-box'>
<h3 class='legislator'><?php echo $c->legislator->first_name." ".$c->legislator->last_name; ?> <small>(<?php echo $c->legislator->party." - ".$c->legislator->state." ".$c->legislator->district; ?>)</small></h3>
<ul class='legislator-sponsorship'>
	<li class='sp'>Sponsored: <?php echo $c->legislator->sponsorships->sponsored; ?></li>
	<li class='sp_en'>Enacted: <?php echo $c->legislator->sponsorships->sponsored_enacted; ?></li>
	<li class='co'>Cosponsored: <?php echo $c->legislator->sponsorships->cosponsored; ?></li>
	<li class='co_en'>Enacted: <?php echo $c->legislator->sponsorships->cosponsored_enacted; ?></li>
</ul>
<h3 class="legislator-bills">Sponsored Bills</h3>
<div class='legislator-sp-bills'>
<?php $i=0; foreach( $bills->bills as $b) { ?>
<h4 class="bill-title" ><a href="#" onclick="jQuery('#<?php echo $b->code; ?>').toggle(); return false;">
<?php echo $b->code." ".$b->short_title; ?></a></h4>
<div id="<?php echo $b->code; ?>" class="bill-body collapse">
<p class="bill-official"><?php echo $b->official_title;?></p>
	<ul class="bill-actions">
	<?php foreach($b->actions as $a) { ?>
	<li class="bill-action"><span class="date"><?php echo date('Y-m-d',strtotime($a->acted_at)); ?></span> <?php echo $a->text; ?></li>
	<?php  } ?> 
	</ul>
	</div>
<?php } ?>
</div>
<h3 class="legislator-bills">Cosponsored Bills</h3>
<div class='legislator-co-bills'>
<?php foreach( $bills2->bills as $b) { ?>
<h4 class="bill-title" ><a href="#" onclick="jQuery('#<?php echo $b->code; ?>').toggle(); return false;">
<?php echo $b->code." ".$b->short_title; ?></a></h4>
<div id="<?php echo $b->code; ?>" class="bill-body collapse">
<p class="bill-official"><?php echo $b->official_title;?></p>
	<ul class="bill-actions">
	<?php foreach($b->actions as $a) { ?>
	<li class="bill-action"><span class="date"><?php echo date('Y-m-d',strtotime($a->acted_at)); ?></span> <?php echo $a->text; ?></li>
	<?php  } ?> 
	</ul>
	</div>
<?php } ?>
</div>
<?php if(get_option('wpcongress_scorecards')) { ?>
<table class='legislator-scorecards collapse'>
<tr><th>Name</th><th>Rating</th><th>Time Span</th></tr>
<?php foreach( $c->legislator->ratings as $r) { ?>
<tr><td class='name'><?php echo $r->name; ?></td><td class='rating'><?php echo $r->rating; ?></td><td class='timespan'><?php echo $r->timespan; ?></td></tr>
<?php } ?>
</table>
<?php } ?>
</div>