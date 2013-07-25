<?php
namespace og;

include_once __DIR__ . "/VideoMovie.php";

class VideoEpisode extends VideoMovie {
	public function setSeries( $url ) {
		if ( static::is_valid_url($url) )
			$this->series = $url;
		return $this;
	}
}