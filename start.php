<?php
/**
 * Places
 *
 * @package ElggPlace
 *
 */

elgg_register_event_handler('init', 'system', 'places_init');

/**
 * Init places plugin.
 */
function places_init() {
	elgg_register_library('elgg:places', elgg_get_plugins_path() . 'place/lib/places.php');

	// add a site navigation item
	$item = new ElggMenuItem('places', elgg_echo('places:places'), 'places/all');
	elgg_register_menu_item('site', $item);

	// add to the main css
	elgg_extend_view('css/elgg', 'places/css');

	// register the place's JavaScript
	elgg_register_js('elgg.places', $place_js);

	// routing of urls
	elgg_register_page_handler('places', 'places_page_handler');

	// override the default url to view a place object
	elgg_register_entity_url_handler('object', 'place', 'places_url_handler');

	// Register for search.
	elgg_register_entity_type('object', 'place');
}

/**
 * Dispatches place pages.
 * URLs take the form of
 *  All places:       places/all
 *  User's places:    places/owner/<username>
 *  Friends' place:   places/friends/<username>
 *  User's archives:  places/archives/<username>/<time_start>/<time_stop>
 *  Place post:       places/view/<guid>/<title>
 *  New post:         places/add/<guid>
 *  Edit post:        places/edit/<guid>/<revision>
 *  Preview post:     places/preview/<guid>
 *  Group place:      places/group/<guid>/owner
 *
 * Title is ignored
 *
 * @todo no archives for all places or friends
 *
 * @param array $page
 * @return NULL
 */
function places_page_handler($page) {

	elgg_load_library('elgg:places');

	// push all places breadcrumb
	elgg_push_breadcrumb(elgg_echo('places:places'), "places/all");

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			$params = places_get_page_content_list($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			$params = places_get_page_content_friends($user->guid);
			break;
		case 'archive':
			$user = get_user_by_username($page[1]);
			$params = places_get_page_content_archive($user->guid, $page[2], $page[3]);
			break;
		case 'view':
			$params = places_get_page_content_read($page[1]);
			break;
		case 'add':
			gatekeeper();
			$params = places_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			gatekeeper();
			$params = places_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'group':
			$params = places_get_page_content_list($page[1]);
			break;
		case 'all':
		default:
			$title = elgg_echo('places:title:all_places');
			$params = places_get_page_content_list();
			break;
	}

	$params['sidebar'] .= elgg_view('places/sidebar', array('page' => $page_type));

	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
}

/**
 * Format and return the URL for places.
 *
 * @param ElggObject $entity Place object
 * @return string URL of place.
 */
function places_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "places/view/{$entity->guid}/$friendly_title";
}

/**
 * Runs when place plugin is activated. See manifest file.
 */
function places_on_activate() {
	add_subtype('object', 'place', 'ElggPlace');
}