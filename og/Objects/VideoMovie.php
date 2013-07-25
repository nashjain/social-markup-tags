<?php
namespace og;

include_once __DIR__."/Object.php";

class VideoMovie extends Object {
	const PREFIX = 'video';
	const NS = 'http://ogp.me/ns/video#';

	public function __construct() {
		$this->actor = array();
		$this->director = array();
		$this->writer = array();
		$this->tag = array();
	}

	public function addActor( $url, $role='' ) {
		if ( static::is_valid_url($url) && !in_array($url, $this->actor) ) {
			if ( !empty($role) && is_string($role) )
				$this->actor[] = array( $url, 'role' => $role );
			else
				$this->actor[] = $url;
		}
		return $this;
	}

	public function addDirector( $url ) {
		if ( static::is_valid_url($url) && !in_array($url, $this->director) )
			$this->director[] = $url;
		return $this;
	}

	public function addWriter( $url ) {
		if ( static::is_valid_url($url) && !in_array($url, $this->writer) )
			$this->writer[] = $url;
	}

	public function setDuration( $duration ) {
		if ( is_int($duration) && $duration > 0 )
			$this->duration = $duration;
		return $this;
	}

	public function setReleaseDate( $release_date ) {
        $this->release_date = static::datetime_to_iso_8601($release_date);
		return $this;
	}

    public function addTag( $tag ) {
        if ( is_string($tag) && !empty($tag) && !in_array($tag, $this->tag) )
            $this->tag[] = $tag;
        return $this;
    }
}
