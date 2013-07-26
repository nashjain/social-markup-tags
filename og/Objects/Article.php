<?php 
namespace og;

include_once __DIR__."/Object.php";

class Article extends Object {
	const PREFIX = 'article';
	const NS = 'http://ogp.me/ns/article#';

	public function __construct($pubDate='now', $updated='now', $expires='+5 Years') {
		$this->author = array();
		$this->tag = array();
        $this->published_time = static::datetime_to_iso_8601($pubDate);
        $this->modified_time = static::datetime_to_iso_8601($updated);
        $this->expiration_time = static::datetime_to_iso_8601($expires);
	}

	public function setSection( $section ) {
		if ( OpenGraph::validString($section)) $this->section = $section;
		return $this;
	}
}
