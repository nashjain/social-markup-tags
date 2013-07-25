<?php
namespace og;

include_once __DIR__."/Object.php";

class Book extends Object {
	const PREFIX = 'book';
	const NS = 'http://ogp.me/ns/book#';

	public function __construct($isbn, $release_date='now') {
        $this->setISBN($isbn);
        $this->release_date = static::datetime_to_iso_8601($release_date);
		$this->author = array();
		$this->tag = array();
	}

    public function addTag( $tag ) {
        if ( is_string($tag) && !empty($tag) && !in_array($tag, $this->tag) )
            $this->tag[] = $tag;
        return $this;
    }

    public function addAuthor( $author_uri ) {
        if ( static::is_valid_url($author_uri) && !in_array($author_uri, $this->author))
            $this->author[] = $author_uri;
        return $this;
    }

	private function setISBN( $isbn ) {
		if ( is_string( $isbn ) ) {
			$isbn = trim( str_replace('-', '', $isbn) );
			if ( strlen($isbn) === 10 && is_numeric( substr($isbn, 0 , 9) ) ) { // published before 2007
				$verifysum = 0;
				$chars = str_split( $isbn );
				for( $i=0; $i<9; $i++ ) {
					$verifysum += ( (int) $chars[$i] ) * (10 - $i);
				}
				$check_digit = 11 - ($verifysum % 11);
				if ( $check_digit == $chars[9] || ($chars[9] == 'X' && $check_digit == 10) )
					$this->isbn = $isbn;
			} elseif ( strlen($isbn) === 13 && is_numeric( substr($isbn, 0, 12 ) ) ) {
				$verifysum = 0;
				$chars = str_split( $isbn );
				for( $i=0; $i<12; $i++ ) {
					$verifysum += ( (int) $chars[$i] ) * ( ( ($i%2) ===0 ) ? 1:3 );
				}
				$check_digit = 10 - ( $verifysum%10 );
				if ( $check_digit == $chars[12] )
					$this->isbn = $isbn;
			}
		}
		return $this;
	}
}
