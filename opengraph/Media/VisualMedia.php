<?php
namespace OpenGraph;

include_once __DIR__."/Media.php";

abstract class VisualMedia extends Media {
	protected $height;
	protected $width;

	public function getWidth() {
		return $this->width;
	}

	public function setWidth( $width ) {
		if ( is_int($width) && $width >  0 )
			$this->width = $width;
		return $this;
	}

	public function getHeight() {
		return $this->height;
	}

	public function setHeight( $height ) {
		if ( is_int($height) && $height > 0 )
			$this->height = $height;
		return $this;
	}
}