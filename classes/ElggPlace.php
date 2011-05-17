<?php
/**
 * Extended class to override the time_created
 */
class ElggPlace extends ElggObject {

	/**
	 * Set subtype to place.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "place";
	}
}