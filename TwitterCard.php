<?php
namespace SocialMarkupTags;

class TwitterCard extends \stdClass
{
    const META_ATTR = 'property';
    const PREFIX = 'twitter';

    private static $allowed_card_types = array('summary', 'large_image_summary', 'photo', 'gallery', 'player', 'product', 'app');

    public function __construct($card_type = 'summary')
    {
        $this->card = in_array($card_type, self::$allowed_card_types) ? $card_type : 'summary';
    }

    public static function is_valid_id($id)
    {
        if (is_int($id)) return true;
        return (is_string($id) && ctype_digit($id));
    }

    public function setURL($url)
    {
        if (self::isValidString($url)) $this->url = $url;
        return $this;
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $title = trim($title);
            // photo cards may explicitly declare an empty title
            if (empty($title) && $this->card !== 'photo')
                return $this;
            $this->title = $title;
        }
        return $this;
    }

    public function setDescription($description)
    {
        if (self::isValidString($description)) {
            $description = trim($description);
            if ($description)
                $this->description = $description;
        }
        return $this;
    }

    public function setImage($url, $width = 0, $height = 0)
    {
        if (!self::isValidString($url)) return $this;
        $image = new \stdClass();
        $image->url = $url;
        if (is_int($width) && is_int($height) && $width > 0 && $height > 0) {
            // prevent self-inflicted pain

            // minimum dimensions for all card types
            if ($width < 60 || $height < 60) return $this;

            // minimum dimensions for photo cards
            if (in_array($this->card, array('large_image_summary', 'photo', 'player'), true) && ($width < 280 || $height < 150)) return $this;

            $image->width = $width;
            $image->height = $height;
        }
        $this->image = $image;
        return $this;
    }

    public function setVideo($url, $width, $height)
    {
        if (!(self::isValidString($url, array('https')) && is_int($width) && is_int($height) && $width > 0 && $height > 0)) return $this;

        $video = new \stdClass();
        $video->url = $url;
        $video->width = $width;
        $video->height = $height;
        $this->video = $video;
        return $this;
    }

    public function setVideoStream($url)
    {
        if (!(isset($this->video) && self::isValidString($url))) return $this;

        $stream = new \stdClass();
        $stream->url = $url;
        $stream->type = 'video/mp4; codecs=&quot;avc1.42E01E1, mpa.40.2&quot;';
        $this->video->stream = $stream;
        return $this;
    }

    public static function filter_account_info($username, $id = '')
    {
        if (!is_string($username)) return null;
        $username = ltrim(trim($username), '@');
        if (!self::isValidString($username)) return null;
        $user = new \stdClass();
        $user->username = $username;
        if ($id && self::is_valid_id($id)) $user->id = (string)$id;
        return $user;
    }

    public function setSiteAccount($username, $id = '')
    {
        $user = self::filter_account_info($username, $id);
        if ($user && isset($user->username)) $this->site = $user;
        return $this;
    }

    public function setCreatorAccount($username, $id = '')
    {
        $user = self::filter_account_info($username, $id);
        if ($user && isset($user->username)) $this->creator = $user;
        return $this;
    }

    private function required_properties_exist()
    {
        if (!(isset($this->url) && isset($this->title))) return false;

        // description required for summary & video but not photo
        if (!isset($this->description) && $this->card !== 'photo') return false;

        // image optional for summary
        if (in_array($this->card, array('photo', 'player'), true) && !(isset($this->image) && isset($this->image->url))) return false;

        // video player needs a video
        if ($this->card === 'player' && !(isset($this->video) && isset($this->video->url) && isset($this->video->width) && isset($this->video->height))) return false;
        return true;
    }

    public function toArray()
    {
        if (!$this->required_properties_exist()) return array();

        // initialize with required properties
        $t = array(
            'card' => $this->card,
            'url' => $this->url,
            'title' => $this->title
        );

        if (isset($this->description))
            $t['description'] = $this->description;

        // add an image
        if (isset($this->image) && isset($this->image->url)) {
            $t['image'] = $this->image->url;
            if (isset($this->image->width) && isset($this->image->height)) {
                $t['image:width'] = $this->image->width;
                $t['image:height'] = $this->image->height;
            }
        }

        // video on a photo card does not make much sense
        if ($this->card !== 'photo' && isset($this->video) && isset($this->video->url)) {
            $t['player'] = $this->video->url;
            if (isset($this->video->width) && isset($this->video->height)) {
                $t['player:width'] = $this->video->width;
                $t['player:height'] = $this->video->height;
            }

            // no video stream without a main video player. content type required.
            if (isset($this->video->stream) && isset($this->video->stream->url) && isset($this->video->stream->type)) {
                $t['player:stream'] = $this->video->stream->url;
                $t['player:stream:content_type'] = $this->video->stream->type;
            }
        }

        // identify the site
        if (isset($this->site) && isset($this->site->username)) {
            $t['site'] = '@' . $this->site->username;
            if (isset($this->site->id))
                $t['site:id'] = $this->site->id;
        }

        //
        if (isset($this->creator) && isset($this->creator->username)) {
            $t['creator'] = '@' . $this->creator->username;
            if (isset($this->creator->id))
                $t['creator:id'] = $this->creator->id;
        }

        return $t;
    }

    public static function build_meta_element($name, $value)
    {
        if (!(is_string($name) && $name && (is_string($value) || (is_int($value) && $value > 0)))) return '';
        return '<meta ' . self::META_ATTR . '="' . self::PREFIX . ':' . htmlspecialchars($name) . '" content="' . htmlspecialchars($value) . '">';
    }

    public function asMetaTags()
    {
        $t = $this->toArray();
        $s = '';
        if (!empty($t))
            foreach ($t as $name => $value)
                $s .= self::build_meta_element($name, $value) . PHP_EOL;
        return rtrim($s);
    }
    
    private static function isValidString($value) {
        return ( !empty($value) && is_string($value));
    }
}

?>