<?php
require_once('simplepie.inc');

/**
 * Extends SimplePie (feed parser library for Rss, Atom, etc)
 */
class EC_Feed_Parser extends SimplePie {
	var $ec_cachelocation = 'cache';
	var $ec_fetchdone = false;

	/**
	 * Parse the feed url.
	 * @param String Feed url (RSS, ATOM etc)
	 * @param Integer Timeout value (to try connecting to url)
	 */
	function ec_dofetch($url, $timeout=10) {
		$this->set_timeout($timeout);
		$this->set_feed_url($url);
		$this->enable_order_by_date(false);
		$this->enable_cache(false);
		$this->init();
		$this->ec_fetchdone = true;
	}

	/**
	 * Parse the content as feed.
	 * @param String Feed content
	 */
	function ec_doparse($content) {
		$this->set_raw_data($content);
		$this->init();
		$this->ec_fetchdone = true;
	}
}
?>
