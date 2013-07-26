<?php
namespace og;

include_once __DIR__ . "/VideoMovie.php";

class VideoEpisode extends VideoMovie {
	protected $series;

	public function setSeries( $url ) {
		if ( OpenGraph::validString($url) ) $this->series = $url;
		return $this;
	}
}