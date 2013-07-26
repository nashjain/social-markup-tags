<?php
include_once __DIR__ . "/OpenGraph.php";

use SocialMarkupTags\OpenGraph;
use SocialMarkupTags\TwitterCard;

$og = new OpenGraph('Site Name', 'Site Title', 'http://example.com/', 'website', 'Site Description.');
$og->locale( 'en_US' );
$og->determiner( 'the' );
$og->image('http://example.com/image.jpg', 400, 300, 'image/jpeg', 'https://example.com/image.jpg');
$og->audio('http://example.com/audio.mp3', 'https://example.com/audio.mp3');
$og->video('http://example.com/video.swf', 500, 400, 'not_sure', 'https://example.com/video.swf');

$article = $og->article('03-11-2011 01:28', 'now', '+5 Years');
$article->authors('http://example.com/author.html', 'http://example.com/author2.html');
$article->tags('tag1', 'tag2');
$article->section('Front page');

$book = $og->book("978-1451648539", '03-11-2011 01:28');
$book->authors("http://examples.opengraphprotocol.us/profile.html");
$book->tags("Steve Jobs", "Apple");

$og->profile("Naresh", "Jain", "nashjain", "male");

$videoMovie = $og->videoMovie('03-11-2011 01:28', 100);
$videoMovie->actor("http://examples.opengraphprotocol.us/profile.html", "Antagonist");
$videoMovie->directors("http://examples.opengraphprotocol.us/profile.html");
$videoMovie->writers("http://examples.opengraphprotocol.us/profile.html");
$videoMovie->tags("Thriller", "Hollywood");

$videoEpisode = $og->videoEpisode("http://example.com/series.html", '30-11-2012 01:28', 200);
$videoEpisode->actor("http://examples.opengraphprotocol.us/profile.html", "Antagonist");
$videoEpisode->directors("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->writers("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->tags("Thriller", "Hollywood");

display($og, false);

include_once __DIR__ . '/TwitterCard.php';

// build a card
$card = TwitterCard::summary('Title', 'Description', 'http://example.com/');
$card->setImage( 'http://example.com/image.jpg', 600, 330 );
$card->setSiteAccount( 'nytimes', '807095' );
$card->setCreatorAccount( 'nashjain', '24134103' );

display($card);

$card = TwitterCard::photo( 'http://example.com/123/media/?size=l', 'title', 610, 610, 'http://example.com/image.jpg', 'Description');
$card->setSiteAccount( 'instagram', '180505807' );
$card->setCreatorAccount( 'sippey', '4711' );

display($card);

$card = TwitterCard::player('title', 'description', 'http://example.com/', 'https://player/url.com', 435, 251, 'http://image/url.jpg', 480, 360);
$card->setSiteAccount( 'youtube', '10228272' );

display($card);

function display($element, $addBreaks=true)
{
    if($addBreaks) echo "<br><br>";
    echo nl2br(htmlentities($element->asMetaTags()));
}