<?php
namespace OpenGraph;

include_once __DIR__."/Object.php";

class Profile extends Object {
	const PREFIX = 'profile';
    const NS = 'http://ogp.me/ns/profile#';

	protected $first_name;
	protected $last_name;
	protected $username;
	protected $gender;

	public function getFirstName() {
		return $this->first_name;
	}

	public function setFirstName( $first_name ) {
		if ( is_string($first_name) && !empty($first_name) )
			$this->first_name = $first_name;
		return $this;
	}

	public function getLastName() {
		return $this->last_name;
	}

	public function setLastName( $last_name ) {
		if ( is_string($last_name) && !empty($last_name) )
			$this->last_name = $last_name;
		return $this;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername( $username ) {
		if ( is_string($username) && !empty($username) )
			$this->username = $username;
		return $this;
	}

	public function getGender() {
		return $this->gender;
	}

	public function setGender( $gender ) {
		if ( is_string($gender) && ( $gender === 'male' || $gender === 'female' ) )
			$this->gender = $gender;
		return $this;
	}
}
