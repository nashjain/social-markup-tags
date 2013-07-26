<?php
namespace og;

include_once __DIR__ . "/../OpenGraph.php";

use og;

abstract class ObjectType extends \stdClass
{
    public function tags()
    {
        return $this->addTagTo("tag", func_get_args());
    }

    protected static function datetime_to_iso_8601($date)
    {
        if (is_string($date))
            $date = new \DateTime($date);
        else if (!$date instanceof \DateTime)
            $date = new \DateTime();
        $date->setTimezone(new \DateTimeZone('GMT'));
        return $date->format('c');
    }

    protected function addTagTo($tagName, $tagValues)
    {
        foreach ($tagValues as $tagValue)
            if (OpenGraph::validString($tagValue) && !in_array($tagValue, $this->$tagName))
                array_push($this->$tagName, $tagValue);
        return $this;
    }
}