<?php

namespace og;

class OpenGraph extends \stdClass  {
    const META_ATTR = 'property';
    const PREFIX = 'og';
    const NS = 'http://ogp.me/ns#';
    const VERIFY_URLS = false;

    public static function buildHTML(array $og, $prefix = self::PREFIX)
    {
        $outputHtml = '';
        if (empty($og)) return $outputHtml;
        foreach ($og as $property => $content) {
            if (is_object($content) || is_array($content)) {
                if (is_object($content)) $content = get_object_vars($content);
                $current_prefix = $prefix;
                if (!empty($property) && is_string($property)) $current_prefix = $prefix . ':' . $property;
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

    public static function is_valid_url($url, array $accepted_mimes = array())
    {
        if (empty($url) || !is_string($url))
            return '';

        /*
         * Validate URI string by letting PHP break up the string and put it back together again
         * Excludes username:password and port number URI parts
         */
        $url_parts = parse_url($url);
        $url = '';
        if (isset($url_parts['scheme']) && in_array($url_parts['scheme'], array('http', 'https'), true)) {
            $url = "{$url_parts['scheme']}://{$url_parts['host']}{$url_parts['path']}";
            if (empty($url_parts['path']))
                $url .= '/';
            if (!empty($url_parts['query']))
                $url .= '?' . $url_parts['query'];
            if (!empty($url_parts['fragment']))
                $url .= '#' . $url_parts['fragment'];
        }

        if (!empty($url)) {
            // test if URL exists
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
            curl_setopt($ch, CURLOPT_NOBODY, true); // HEAD
            curl_setopt($ch, CURLOPT_USERAGENT, 'Open Graph protocol validator ' . ' (+http://ogp.me/)');
            if (!empty($accepted_mimes))
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: ' . implode(',', $accepted_mimes)));
            curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200) {
                if (!empty($accepted_mimes)) {
                    $content_type = explode(';', curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
                    if (empty($content_type) || !in_array($content_type[0], $accepted_mimes))
                        return '';
                }
            } else {
                return '';
            }
        }
        return $url;
    }

    public function toHTML()
    {
        return rtrim(static::buildHTML(get_object_vars($this)), PHP_EOL);
    }

    public function type($type)
    {
        if (is_string($type) && in_array($type, self::supported_types(true), true))
            $this->type = $type;
        return $this;
    }

    public function title($title)
    {
        if (is_string($title)) {
            $title = trim($title);
            if (strlen($title) > 128)
                $title = substr($title, 0, 128);
            $this->title = $title;
        }
        return $this;
    }

    public function siteName($site_name)
    {
        if (is_string($site_name) && !empty($site_name)) {
            $site_name = trim($site_name);
            if (strlen($site_name) > 128)
                $site_name = substr($site_name, 0, 128);
            $this->site_name = $site_name;
        }
        return $this;
    }

    public function description($description)
    {
        if (is_string($description) && !empty($description)) {
            $description = trim($description);
            if (strlen($description) > 255)
                $description = substr($description, 0, 255);
            $this->description = $description;
        }
        return $this;
    }

    public function url($url)
    {
        if (empty($url) || !is_string($url)) return $this;
        $url = trim($url);
        if (self::VERIFY_URLS) $url = self::is_valid_url($url, array('text/html', 'application/xhtml+xml'));
        if (!empty($url)) $this->url = $url;
        return $this;
    }

    public function determiner($determiner)
    {
        if (in_array($determiner, array('a', 'an', 'auto', 'the'), true))
            $this->determiner = $determiner;
        return $this;
    }

    public function locale($locale)
    {
        if (is_string($locale) && in_array($locale, static::supported_locales(true)))
            $this->locale = $locale;
        return $this;
    }

    public function audio($url, $secure_url=null){
        return $this->addMedia("audio", $url, $secure_url);
    }

    public function image($url, $secure_url=null, $width=0, $height=0){
        return $this->addMedia("image", $url, $secure_url, $width, $height);
    }

    public function video($url, $secure_url=null, $width=0, $height=0){
        return $this->addMedia("video", $url, $secure_url, $width, $height);
    }

    private function addMedia($mediaType, $media_url, $secure_url=null, $width=0, $height=0){
        if (!self::isValidURL($media_url)) return $this;
        $media = new \stdClass();
        $extension = pathinfo(parse_url($media_url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!empty($extension) && array_key_exists($extension, self::$extension_to_content_type_mapping))
            $media->type = self::$extension_to_content_type_mapping[$extension];
        if($this->isPositiveInt($width)) $media->width = $width;
        if($this->isPositiveInt($height)) $media->height = $height;
        if(!empty($secure_url)) if (self::isValidURL($secure_url, "https")) $media->secure_url = $secure_url;

        $value = array($media_url, array($media));
        if (!isset($this->$mediaType))
            $this->$mediaType = array($value);
        else
            array_push($this->$mediaType, $value);
        return $this;
    }

    private function isPositiveInt($value){
        return is_int($value) && $value>0;
    }

    public static function isValidURL($url, $type = "http")
    {
        if (empty($url) || !is_string($url)) return false;
        if(!self::VERIFY_URLS) return true;
        $url = trim($url);
        if (parse_url($url, PHP_URL_SCHEME) !== $type) return false;
        $url = OpenGraph::is_valid_url($url, array('text/html', 'application/xhtml+xml'));
        return !empty($url);
    }
}
