<?php
namespace SocialMarkupTags;

abstract class ObjectType extends \stdClass
{
    public function tags()
    {
        return $this->addTagTo("tag", func_get_args());
    }

    protected static function datetime_to_iso_8601($date)
    {
        if (ObjectType::isValidString($date))
            $date = new \DateTime($date, new \DateTimeZone('GMT'));
        else if (!$date instanceof \DateTime)
            $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('GMT'));
        return $date->format('c');
    }

    protected function addTagTo($tagName, $tagValues)
    {
        if(!is_array($tagValues)) return $this->addTagTo($tagName, array($tagValues));
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($tagValues));
        foreach ($it as $tagValue)
            if (ObjectType::isValidString($tagValue) && !in_array($tagValue, $this->$tagName))
                array_push($this->$tagName, $tagValue);
        return $this;
    }
    
    public static function isValidString($value) {
        return ( !empty($value) && is_string($value));
    }
}

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
        return $this->addTagTo("section", $sectionName);
    }
}

class Book extends ObjectType {
    public function __construct($isbn, $release_date='now') {
        if(ObjectType::isValidString($isbn)) $this->isbn = $isbn;
        $this->release_date = static::datetime_to_iso_8601($release_date);
        $this->author = array();
        $this->tag = array();
    }

    public function authors()
    {
        return $this->addTagTo("author", func_get_args());
    }
}

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
        if ( ObjectType::isValidString($actor_url) && !in_array($actor_url, $this->actor) ) {
            if ( ObjectType::isValidString($role) )
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

class VideoEpisode extends VideoMovie {
    public function __construct($series, $release_date='now', $duration=0)
    {
        parent::__construct($release_date, $duration);
        if(ObjectType::isValidString($series)) $this->series = $series;
    }
}
