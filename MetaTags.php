<?php

namespace SocialMarkupTags;

include_once __DIR__ . "/OpenGraph.php";
include_once __DIR__ . "/TwitterCard.php";

class MetaTags extends \stdClass
{
    public $og;
    public $tc;

    public function __construct($siteName, $title, $url, $type, $description)
    {
        $this->og = new OpenGraph($siteName, $title, $url, $type, $description);
        $this->tc = TwitterCard::summary($title, $description, $url);
    }

    public function as_html_meta_tags()
    {
        return $this->og->as_html_meta_tags() . PHP_EOL . $this->tc->as_html_meta_tags();
    }

    public function article($pubDate = 'now', $updated = 'now', $expires = '+5 Years')
    {
        return new ArticleWrapper($this, $pubDate, $updated, $expires);
    }

    public function locale($locale)
    {
        $this->og->locale($locale);
    }
}

class ArticleWrapper extends \stdClass
{
    public function __construct($metaTags, $pubDate = 'now', $updated = 'now', $expires = '+5 Years')
    {
        $this->metaTags = $metaTags;
        $this->article = $metaTags->og->article($pubDate, $updated, $expires);
    }

    public function authors($comma_separated_list_of_all_authors_url)
    {
        $this->article->authors(func_get_args());
    }

    public function image($url, $width = 0, $height = 0, $type='', $secure_url = null)
    {
        $this->metaTags->og->image($url, $width, $height, $type, $secure_url);
        $this->metaTags->tc->image( $url, $width, $height);
    }

    public function section($section_name)
    {
        $this->article->section($section_name);
    }

    public function tags($comma_separated_list_of_all_tags)
    {
        $this->article->tags(func_get_args());
    }
}
