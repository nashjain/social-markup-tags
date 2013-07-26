<?php
namespace og;

include_once __DIR__ . "/VideoMovie.php";

class VideoEpisode extends VideoMovie {
    public function __construct($series, $release_date='now', $duration=0)
    {
        parent::__construct($release_date, $duration);
        $this->series = array();
        $this->addTagTo("series", array($series));
    }
}