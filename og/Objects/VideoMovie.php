<?php
namespace og;

include_once __DIR__ . "/ObjectType.php";

class VideoMovie extends ObjectType {
	public function __construct($release_date='now', $duration=0) {
        $this->release_date = static::datetime_to_iso_8601($release_date);
        if ( is_int($duration) && $duration > 0 ) $this->duration = $duration;
		$this->actor = array();
		$this->director = array();
		$this->writer = array();
		$this->tag = array();
	}

	public function actor($actor_url, $role='')
    {
        if ( OpenGraph::validString($actor_url) && !in_array($actor_url, $this->actor) ) {
            if ( OpenGraph::validString($role) )
                array_push($this->actor, array( $actor_url, 'role' => $role ));
            else
                array_push($this->actor, $actor_url);
        }
        return $this;
    }

    public function directors()
    {
        return $this->addTagTo("director", func_get_args());
    }

    public function writers()
    {
        return $this->addTagTo("writer", func_get_args());
    }
}
