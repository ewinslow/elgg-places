<?php
/**
 * Add place
 *
 * @package Places
 */

$page_owner = elgg_get_page_owner_entity();

$title = elgg_echo('places:add');
elgg_push_breadcrumb($title);

$content = elgg_view_form('object/place/add');

$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
));

echo elgg_view_page($title, $body);