<?php

namespace og;

include_once __DIR__ . "/Objects/Article.php";
include_once __DIR__ . "/Objects/Book.php";
include_once __DIR__ . "/Objects/VideoMovie.php";
include_once __DIR__ . "/Objects/VideoEpisode.php";

class OpenGraph extends \stdClass  {
    const META_ATTR = 'property';
    const PREFIX = 'og';
    const NS = 'http://ogp.me/ns#';

    public function __construct($siteName, $title, $url, $type, $description){
        $this->set("site_name", $siteName, 128);
        $this->set("title", $title, 128);
        $this->set("description", $description, 255);
        if (self::validString($url)) $this->url = trim($url);
        if (self::validString($type) && in_array($type, self::supported_types(true), true)) $this->type = $type;
        $this->audio = array();
        $this->image = array();
        $this->video = array();
        $this->article = array();
        $this->book = array();
        $this->profile = array();
        $this->videoMovie = array();
        $this->videoEpisode = array();
    }

    public static function buildHTML(array $og, $prefix = self::PREFIX)
    {
        $outputHtml = '';
        if (empty($og)) return $outputHtml;
        foreach ($og as $property => $content) {
            if (is_object($content) || is_array($content)) {
                $current_prefix = $prefix;
                if (is_object($content)) $content = get_object_vars($content);
                if (!empty($property) && is_string($property)) {
                    if(array_key_exists($property, self::$validObjectTypes))
                        $current_prefix = self::$validObjectTypes[$property];
                    else
                        $current_prefix = $prefix . ':' . $property;
                }
                $outputHtml .= static::buildHTML($content, $current_prefix);
            } elseif (!empty($content)) {
                $outputHtml .= '<meta ' . self::META_ATTR . '="' . $prefix;
                if (is_string($property) && !empty($property))
                    $outputHtml .= ':' . htmlspecialchars($property);
                $outputHtml .= '" content="' . htmlspecialchars($content) . '">' . PHP_EOL;
            }
        }
        return $outputHtml;
    }

    private static $validObjectTypes = array("article"=>"article", "book"=>"book", "profile"=>"profile", "videoMovie"=>"video", "videoEpisode"=>"video");

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

    public static function supported_types($flatten = false)
    {
        $types = array(
            _('Activities') => array(
                'activity' => _('Activity'),
                'sport' => _('Sport')
            ),
            _('Businesses') => array(
                'company' => _('Company'),
                'bar' => _('Bar'),
                'cafe' => _('Cafe'),
                'hotel' => _('Hotel'),
                'restaurant' => _('Restaurant')
            ),
            _('Groups') => array(
                'cause' => _('Cause'),
                'sports_league' => _('Sports league'),
                'sports_team' => _('Sports team')
            ),
            _('Organizations') => array(
                'band' => _('Band'),
                'government' => _('Government'),
                'non_profit' => _('Non-profit'),
                'school' => _('School'),
                'university' => _('University')
            ),
            _('People') => array(
                'actor' => _('Actor or actress'),
                'athlete' => _('Athlete'),
                'author' => _('Author'),
                'director' => _('Director'),
                'musician' => _('Musician'),
                'politician' => _('Politician'),
                'profile' => _('Profile'),
                'public_figure' => _('Public Figure')
            ),
            _('Places') => array(
                'city' => _('City or locality'),
                'country' => _('Country'),
                'landmark' => _('Landmark'),
                'state_province' => _('State or province')
            ),
            _('Products and Entertainment') => array(
                'music.album' => _('Music Album'),
                'book' => _('Book'),
                'drink' => _('Drink'),
                'video.episode' => _('Video episode'),
                'food' => _('Food'),
                'game' => _('Game'),
                'video.movie' => _('Movie'),
                'music.playlist' => _('Music playlist'),
                'product' => _('Product'),
                'music.radio_station' => _('Radio station'),
                'music.song' => _('Song'),
                'video.tv_show' => _('Television show'),
                'video.other' => _('Video')
            ),
            _('Websites') => array(
                'article' => _('Article'),
                'blog' => _('Blog'),
                'website' => _('Website')
            )
        );
        if ($flatten === true) {
            $types_values = array();
            foreach ($types as $category => $values) {
                $types_values = array_merge($types_values, array_keys($values));
            }
            return $types_values;
        }
        return $types;
    }

    public static function supported_locales($keys_only = false)
    {
        $locales = array(
            'af_ZA' => _('Afrikaans'),
            'ar_AR' => _('Arabic'),
            'az_AZ' => _('Azeri'),
            'be_BY' => _('Belarusian'),
            'bg_BG' => _('Bulgarian'),
            'bn_IN' => _('Bengali'),
            'bs_BA' => _('Bosnian'),
            'ca_ES' => _('Catalan'),
            'cs_CZ' => _('Czech'),
            'cy_GB' => _('Welsh'),
            'da_DK' => _('Danish'),
            'de_DE' => _('German'),
            'el_GR' => _('Greek'),
            'en_GB' => _('English (UK)'),
            'en_US' => _('English (US)'),
            'eo_EO' => _('Esperanto'),
            'es_ES' => _('Spanish (Spain)'),
            'es_LA' => _('Spanish (Latin America)'),
            'et_EE' => _('Estonian'),
            'eu_ES' => _('Basque'),
            'fa_IR' => _('Persian'),
            'fi_FI' => _('Finnish'),
            'fo_FO' => _('Faroese'),
            'fr_CA' => _('French (Canada)'),
            'fr_FR' => _('French (France)'),
            'fy_NL' => _('Frisian'),
            'ga_IE' => _('Irish'),
            'gl_ES' => _('Galician'),
            'he_IL' => _('Hebrew'),
            'hi_IN' => _('Hindi'),
            'hr_HR' => _('Croatian'),
            'hu_HU' => _('Hungarian'),
            'hy_AM' => _('Armenian'),
            'id_ID' => _('Indonesian'),
            'is_IS' => _('Icelandic'),
            'it_IT' => _('Italian'),
            'ja_JP' => _('Japanese'),
            'ka_GE' => _('Georgian'),
            'ko_KR' => _('Korean'),
            'ku_TR' => _('Kurdish'),
            'la_VA' => _('Latin'),
            'lt_LT' => _('Lithuanian'),
            'lv_LV' => _('Latvian'),
            'mk_MK' => _('Macedonian'),
            'ml_IN' => _('Malayalam'),
            'ms_MY' => _('Malay'),
            'nb_NO' => _('Norwegian (bokmal)'),
            'ne_NP' => _('Nepali'),
            'nl_NL' => _('Dutch'),
            'nn_NO' => _('Norwegian (nynorsk)'),
            'pa_IN' => _('Punjabi'),
            'pl_PL' => _('Polish'),
            'ps_AF' => _('Pashto'),
            'pt_PT' => _('Portuguese (Brazil)'),
            'ro_RO' => _('Romanian'),
            'ru_RU' => _('Russian'),
            'sk_SK' => _('Slovak'),
            'sl_SI' => _('Slovenian'),
            'sq_AL' => _('Albanian'),
            'sr_RS' => _('Serbian'),
            'sv_SE' => _('Swedish'),
            'sw_KE' => _('Swahili'),
            'ta_IN' => _('Tamil'),
            'te_IN' => _('Telugu'),
            'th_TH' => _('Thai'),
            'tl_PH' => _('Filipino'),
            'tr_TR' => _('Turkish'),
            'uk_UA' => _('Ukrainian'),
            'vi_VN' => _('Vietnamese'),
            'zh_CN' => _('Simplified Chinese (China)'),
            'zh_HK' => _('Traditional Chinese (Hong Kong)'),
            'zh_TW' => _('Traditional Chinese (Taiwan)')
        );
        if ($keys_only === true) {
            return array_keys($locales);
        }
        return $locales;
    }

    public function toHTML()
    {
        return rtrim(static::buildHTML(get_object_vars($this)));
    }

    public function determiner($determiner)
    {
        if (in_array($determiner, array('a', 'an', 'auto', 'the'), true))
            $this->determiner = $determiner;
        return $this;
    }

    public function locale($locale)
    {
        if (self::validString($locale) && in_array($locale, static::supported_locales(true)))
            $this->locale = $locale;
        return $this;
    }

    public function audio($url, $secure_url=null){
        return $this->addMedia("audio", $url, $secure_url);
    }

    public function image($url, $width=0, $height=0, $secure_url=null){
        return $this->addMedia("image", $url, $secure_url, $width, $height);
    }

    public function video($url, $width=0, $height=0, $secure_url=null){
        return $this->addMedia("video", $url, $secure_url, $width, $height);
    }

    public function article($pubDate='now', $updated='now', $expires='+5 Years'){
        $article = new Article($pubDate, $updated, $expires);
        array_push($this->article, $article);
        return $article;
    }

    public function book($isbn, $release_date='now')
    {
        $book = new Book($isbn, $release_date);
        array_push($this->book, $book);
        return $book;
    }

    public function videoMovie($release_date='now', $duration=0)
    {
        $videoMovie = new VideoMovie($release_date, $duration);
        array_push($this->videoMovie, $videoMovie);
        return $videoMovie;
    }

    public function videoEpisode($series, $release_date='now', $duration=0)
    {
        $videoEpisode = new VideoEpisode($series, $release_date, $duration);
        array_push($this->videoEpisode, $videoEpisode);
        return $videoEpisode;
    }

    public function profile($first_name, $last_name, $username, $gender='')
    {
        $profile = array();
        if(self::validString($first_name)) $profile['first_name'] = $first_name;
        if(self::validString($last_name)) $profile['last_name'] = $last_name;
        if(self::validString($username)) $profile['username'] = $username;
        if(self::validString($gender) && ( $gender === 'male' || $gender === 'female' )) $profile['gender'] = $gender;
        array_push($this->profile, $profile);
        return $this;
    }

    private function addMedia($mediaType, $media_url, $secure_url, $width=0, $height=0){
        if (!self::validString($media_url)) return $this;
        $media = array();
        $contentType = self::contentType($media_url);
        if(!empty($contentType)) $media['type'] = $contentType;
        if(self::isPositiveInt($width)) $media['width'] = $width;
        if(self::isPositiveInt($height)) $media['height'] = $height;
        if(self::validString($secure_url)) $media['secure_url'] = $secure_url;
        array_push($this->$mediaType, array($media_url, $media));
        return $this;
    }

    public static function validString($value) {
        return ( !empty($value) && is_string($value));
    }

    private static function contentType($media_url)
    {
        $extension = pathinfo(parse_url($media_url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!empty($extension) && array_key_exists($extension, self::$extension_to_content_type_mapping))
            return self::$extension_to_content_type_mapping[$extension];
        return '';
    }

    private static function isPositiveInt($value){
        return is_int($value) && $value>0;
    }

    private function set($fieldName, $fieldValue, $maxLength)
    {
        if (self::validString($fieldValue)) {
            $fieldValue = trim($fieldValue);
            if (strlen($fieldValue) > $maxLength)
                $fieldValue = substr($fieldValue, 0, $maxLength);
            $this->$fieldName = $fieldValue;
        }
        return $this;
    }
}
