<?php
namespace og;

include_once __DIR__ . "/../OpenGraph.php";

use og;

abstract class Object extends \stdClass{
	const PREFIX ='';
	const NS='';

	public function toHTML() {
		return rtrim( og\OpenGraph::buildHTML( get_object_vars($this), static::PREFIX ), PHP_EOL );
	}

    public function addTag( $tag ) {
        if ( is_string($tag) && !empty($tag) && !in_array($tag, $this->tag) )
            $this->tag[] = $tag;
        return $this;
    }

    public function addAuthor( $author_uri ) {
        if ( OpenGraph::validString($author_uri) && !in_array($author_uri, $this->author))
            $this->author[] = $author_uri;
        return $this;
    }

    public static function datetime_to_iso_8601 ($date) {
        if ( is_string($date))
            $date = new \DateTime($date);
        else if ( !$date instanceof \DateTime )
            $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('GMT'));
        return $date->format('c');
    }
}