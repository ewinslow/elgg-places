<?php

$defaults = array(
	'name' => 'location',
);

echo elgg_view('input/text', array_merge($defaults, $vars));