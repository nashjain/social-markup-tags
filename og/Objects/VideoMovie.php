<?php
namespace og;

include_once __DIR__."/Object.php";

class VideoMovie extends Object {
	const PREFIX = 'video';
	const NS = 'http://ogp.me/ns/video#';

	public function __construct($release_date='now', $duration=0) {
        $this->release_date = static::datetime_to_iso_8601($release_date);
        if ( is_int($duration) && $duration > 0 ) $this->duration = $duration;
		$this->actor = array();
		$this->director = array();
		$this->writer = array();
		$this->tag = array();
	}

	public function addActor( $url, $role='' ) {
		if ( OpenGraph::validString($url) && !in_array($url, $this->actor) ) {
			if ( OpenGraph::validString($role) )
				$this->actor[] = array( $url, 'role' => $role );
			else
				$this->actor[] = $url;
		}
		return $this;
	}

	public function addDirector( $url ) {
		if ( OpenGraph::validString($url) && !in_array($url, $this->director) )
			$this->director[] = $url;
		return $this;
	}

	public function addWriter( $url ) {
		if ( OpenGraph::validString($url) && !in_array($url, $this->writer) )
			$this->writer[] = $url;
	}
}
