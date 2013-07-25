<?php
namespace og;

include_once __DIR__."/Object.php";

class Profile extends Object {
	const PREFIX = 'profile';
    const NS = 'http://ogp.me/ns/profile#';

    public function __construct($first_name, $last_name, $username, $gender=''){
        if(OpenGraph::validString($first_name)) $this->first_name = $first_name;
        if(OpenGraph::validString($last_name)) $this->last_name = $last_name;
        if(OpenGraph::validString($username)) $this->username = $username;
        if(OpenGraph::validString($gender) && ( $gender === 'male' || $gender === 'female' )) $this->gender = $gender;
    }
}
