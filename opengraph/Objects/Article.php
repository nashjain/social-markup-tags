<?php 
namespace OpenGraph;

include_once __DIR__."/Object.php";

class Article extends Object {
	const PREFIX = 'article';
	const NS = 'http://ogp.me/ns/article#';

	protected $published_time;
	protected $modified_time;
	protected $expiration_time;
	protected $author;
	protected $section;
	protected $tag;

	public function __construct() {
		$this->author = array();
		$this->tag = array();
	}

	public function getPublishedTime() {
		return $this->published_time;
	}

	public function setPublishedTime( $pubdate ) {
        $this->published_time = static::datetime_to_iso_8601($pubdate);
		return $this;
	}

	public function getModifiedTime() {
		return $this->modified_time;
	}

	public function setModifiedTime( $updated ) {
        $this->modified_time = static::datetime_to_iso_8601($updated);
		return $this;
	}

	public function getExpirationTime() {
		return $this->expiration_time;
	}


	public function setExpirationTime( $expires ) {
        $this->expiration_time = static::datetime_to_iso_8601($expires);
		return $this;
	}

	public function getAuthors() {
		return $this->author;
	}

	public function addAuthor( $author_uri ) {
		if ( static::is_valid_url($author_uri) && !in_array($author_uri, $this->author))
			$this->author[] = $author_uri;
		return $this;
	}

	public function getSection() {
		return $this->section;
	}

	public function setSection( $section ) {
		if ( is_string($section) && !empty($section) )
			$this->section = $section;
		return $this;
	}

	public function getTags() {
		return $this->tag;
	}

	public function addTag( $tag ) {
		if ( is_string($tag) && !empty($tag) )
			$this->tag[] = $tag;
		return $this;
	}
}
