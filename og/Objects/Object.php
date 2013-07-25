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

    public static function datetime_to_iso_8601 ($date) {
        if ( is_string($date))
            $date = new \DateTime($date);
        else if ( !$date instanceof \DateTime )
            $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('GMT'));
        return $date->format('c');
    }

	public static function is_valid_url( $url ) {
        if ( empty($url) || !is_string($url) ) return false;
        $url = og\OpenGraph::is_valid_url( $url, array( 'text/html', 'application/xhtml+xml' ) );
        return !empty($url);
	}
}