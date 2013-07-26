<?php

namespace SocialMarkupTags;

include_once __DIR__ . "/og/ObjectType.php";

class OpenGraph extends \stdClass
{
    const META_ATTR = 'property';
    const PREFIX = 'og';
    private static $validObjectTypes = array("article" => "article", "book" => "book", "profile" => "profile", "videoMovie" => "video", "videoEpisode" => "video");

    private static $extension_to_content_type_mapping = array(
        "swf" => "application/x-shockwave-flash",
        "mp3" => "audio/mpeg",
        "m4a" => "audio/mp4",
        "ogg" => "audio/ogg",
        "oga" => "audio/ogg",
        "jpeg" => "image/jpeg",
        "jpg" => "image/jpeg",
        "png" => "image/png",
        "gif" => "image/gif",
        "svg" => "image/svg+sml",
        "ico" => "image/vnd.microsoft.icon",
        "mp4" => "video/mp4",
        "ogv" => "video/ogg",
        "webm" => "video/webm"
    );

    private static $supported_types = array('activity', 'sport', 'company', 'bar', 'cafe', 'hotel', 'restaurant', 'cause', 'sports_league', 'sports_team', 'band', 'government', 'non_profit', 'school', 'university', 'actor', 'athlete', 'author', 'director', 'musician', 'politician', 'profile', 'public_figure', 'city', 'country', 'landmark', 'state_province', 'music.album', 'book', 'drink', 'video.episode', 'food', 'game', 'video.movie', 'music.playlist', 'product', 'music.radio_station', 'music.song', 'video.tv_show', 'video.other', 'article', 'blog', 'website');

    private static $validDeterminer = array('a', 'an', 'auto', 'the');

    public function __construct($siteName, $title, $url, $type, $description)
    {
        $this->set("site_name", $siteName, 128);
        $this->set("title", $title, 128);
        $this->set("description", $description, 255);
        if (ObjectType::isValidString($url)) $this->url = trim($url);
        if (ObjectType::isValidString($type) && in_array($type, self::$supported_types, true)) $this->type = $type;
        $this->audio = array();
        $this->image = array();
        $this->video = array();
        $this->article = array();
        $this->book = array();
        $this->profile = array();
        $this->videoMovie = array();
        $this->videoEpisode = array();
    }

    public function asMetaTags()
    {
        return rtrim(self::buildMetaTag(get_object_vars($this)));
    }

    public function determiner($determiner)
    {
        if (in_array($determiner, self::$validDeterminer, true)) $this->determiner = $determiner;
        return $this;
    }

    public function locale($locale)
    {
        if (ObjectType::isValidString($locale)) $this->locale = $locale;
        return $this;
    }

    public function audio($url, $secure_url = null, $type='')
    {
        return $this->addMedia("audio", $url, $secure_url, $type);
    }

    public function image($url, $width = 0, $height = 0, $type='', $secure_url = null)
    {
        return $this->addMedia("image", $url, $secure_url, $type, $width, $height);
    }

    public function video($url, $width = 0, $height = 0, $type='', $secure_url = null)
    {
        return $this->addMedia("video", $url, $secure_url, $type, $width, $height);
    }

    public function article($pubDate = 'now', $updated = 'now', $expires = '+5 Years')
    {
        $article = new Article($pubDate, $updated, $expires);
        array_push($this->article, $article);
        return $article;
    }

    public function book($isbn, $release_date = 'now')
    {
        $book = new Book($isbn, $release_date);
        array_push($this->book, $book);
        return $book;
    }

    public function videoMovie($release_date = 'now', $duration = 0)
    {
        $videoMovie = new VideoMovie($release_date, $duration);
        array_push($this->videoMovie, $videoMovie);
        return $videoMovie;
    }

    public function videoEpisode($series, $release_date = 'now', $duration = 0)
    {
        $videoEpisode = new VideoEpisode($series, $release_date, $duration);
        array_push($this->videoEpisode, $videoEpisode);
        return $videoEpisode;
    }

    public function profile($first_name, $last_name, $username, $gender = '')
    {
        $profile = array();
        if (ObjectType::isValidString($first_name)) $profile['first_name'] = $first_name;
        if (ObjectType::isValidString($last_name)) $profile['last_name'] = $last_name;
        if (ObjectType::isValidString($username)) $profile['username'] = $username;
        if (ObjectType::isValidString($gender) && ($gender === 'male' || $gender === 'female')) $profile['gender'] = $gender;
        array_push($this->profile, $profile);
        return $this;
    }

    private static function buildMetaTag(array $metaTagObjects, $prefix = self::PREFIX)
    {
        $outputMetaTag = '';
        if (empty($metaTagObjects)) return $outputMetaTag;
        foreach ($metaTagObjects as $property => $content) {
            if (is_object($content) || is_array($content)) {
                $current_prefix = $prefix;
                if (is_object($content)) $content = get_object_vars($content);
                if (ObjectType::isValidString($property)) {
                    if (array_key_exists($property, self::$validObjectTypes))
                        $current_prefix = self::$validObjectTypes[$property];
                    else
                        $current_prefix = $prefix . ':' . $property;
                }
                $outputMetaTag .= self::buildMetaTag($content, $current_prefix);
            } elseif (!empty($content)) {
                $outputMetaTag .= '<meta '.self::META_ATTR.'="'. $prefix;
                if (ObjectType::isValidString($property))
                    $outputMetaTag .= ':' . htmlspecialchars($property);
                $outputMetaTag .= '" content="' . htmlspecialchars($content) . '">' . PHP_EOL;
            }
        }
        return $outputMetaTag;
    }

    private function addMedia($mediaType, $media_url, $secure_url, $type, $width = 0, $height = 0)
    {
        if (!ObjectType::isValidString($media_url)) return $this;
        $media = array();
        if(ObjectType::isValidString($type) && in_array($type, self::$extension_to_content_type_mapping))
            $contentType = $type;
        else
            $contentType = self::contentType($media_url);
        if (!empty($contentType)) $media['type'] = $contentType;
        if (self::isPositiveInt($width)) $media['width'] = $width;
        if (self::isPositiveInt($height)) $media['height'] = $height;
        if (ObjectType::isValidString($secure_url)) $media['secure_url'] = $secure_url;
        array_push($this->$mediaType, array($media_url, $media));
        return $this;
    }

    private static function contentType($media_url)
    {
        $extension = pathinfo(parse_url($media_url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!empty($extension) && array_key_exists($extension, self::$extension_to_content_type_mapping))
            return self::$extension_to_content_type_mapping[$extension];
        return '';
    }

    private static function isPositiveInt($value)
    {
        return is_int($value) && $value > 0;
    }

    private function set($fieldName, $fieldValue, $maxLength)
    {
        if (ObjectType::isValidString($fieldValue)) {
            $fieldValue = trim($fieldValue);
            if (strlen($fieldValue) > $maxLength)
                $fieldValue = substr($fieldValue, 0, $maxLength);
            $this->$fieldName = $fieldValue;
        }
        return $this;
    }
}
