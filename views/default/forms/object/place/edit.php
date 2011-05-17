<?php
/**
 * Edit a place
 *
 * @package Places
 */

$place = $vars['entity'];

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div class="elgg-input-wrapper">
	<label class="elgg-input-label"><?php echo elgg_echo('name'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $place->title)); ?>
</div>
<div class="elgg-input-wrapper">
	<label class="elgg-input-label"><?php echo elgg_echo('places:streetAddress'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'streetAddress', 'value' => $place->streetAddress)); ?>
</div>
<div class="elgg-input-wrapper">
	<label class="elgg-input-label"><?php echo elgg_echo('places:locality'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'locality', 'value' => $place->locality)); ?>
</div>
<div class="elgg-input-wrapper">
	<label class="elgg-input-label"><?php echo elgg_echo('places:region'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'region', 'value' => $place->region)); ?>
</div>
<div class="elgg-input-wrapper">
	<label class="elgg-input-label"><?php echo elgg_echo('places:postalCode'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'postalCode', 'value' => $place->postalCode)); ?>
</div>
<div class="elgg-input-wrapper">
	<label class="elgg-input-label"><?php echo elgg_echo('places:country'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'country', 'value' => $place->country)); ?>
</div>
<div class="elgg-input-wrapper">
<?php

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $place->guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>