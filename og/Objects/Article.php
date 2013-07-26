<?php 
namespace og;

include_once __DIR__ . "/ObjectType.php";

class Article extends ObjectType {
	public function __construct($pubDate='now', $updated='now', $expires='+5 Years') {
		$this->author = array();
		$this->tag = array();
		$this->section = array();
        $this->published_time = static::datetime_to_iso_8601($pubDate);
        $this->modified_time = static::datetime_to_iso_8601($updated);
        $this->expiration_time = static::datetime_to_iso_8601($expires);
	}

    public function authors() {
        return $this->addTagTo("author", func_get_args());
    }

    public function section($sectionName)
    {
        return $this->addTagTo("section", array($sectionName));
    }
}
