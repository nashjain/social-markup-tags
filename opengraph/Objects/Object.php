<?php
namespace OpenGraph;

include_once __DIR__."/../MetaTags.php";

use OpenGraph;

abstract class Object {
	const PREFIX ='';
	const NS='';

	public function toHTML() {
		return rtrim( OpenGraph\MetaTags::buildHTML( get_object_vars($this), static::PREFIX ), PHP_EOL );
	}

    public static function datetime_to_iso_8601 ($date) {
        if ( is_string($date) && strlen($date) >= 10 ) // at least DD-MM-YYYY
            $date = new \DateTime($date);
        else if ( !$date instanceof \DateTime )
            $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('GMT'));
        return $date->format('c');
    }

	public static function is_valid_url( $url ) {
        if ( empty($url) || !is_string($url) ) return false;
        if (!OpenGraph\MetaTags::VERIFY_URLS) return true;
        $url = OpenGraph\MetaTags::is_valid_url( $url, array( 'text/html', 'application/xhtml+xml' ) );
        return !empty($url);
	}
}