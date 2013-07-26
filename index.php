<?php
include_once __DIR__ . "/og/OpenGraph.php";

$og = new og\OpenGraph('Site Name', 'Site Title', 'http://example.com/', 'website', 'Site Description.');
$og->locale( 'en_US' );
$og->determiner( 'the' );
$og->image('http://example.com/image.jpg', 400, 300, 'https://example.com/image.jpg');
$og->audio('http://example.com/audio.mp3', 'https://example.com/audio.mp3');
$og->video('http://example.com/video.swf', 500, 400, 'https://example.com/video.swf');

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

if ( ! class_exists( 'TwitterCard' ) )
    require_once __DIR__ . '/twitter/TwitterCard.php';

// build a card
$card = new SocialMarkupTags\TwitterCard();
$card->setURL( 'http://www.nytimes.com/2012/02/19/arts/music/amid-police-presence-fans-congregate-for-whitney-houstons-funeral-in-newark.html' );
$card->setTitle( 'Parade of Fans for Houston\'s Funeral' );
$card->setDescription( 'NEWARK - The guest list and parade of limousines with celebrities emerging from them seemed more suited to a red carpet event in Hollywood or New York than than a gritty stretch of Sussex Avenue near the former site of the James M. Baxter Terrace public housing project here.' );
// optional
$card->setImage( 'http://graphics8.nytimes.com/images/2012/02/19/us/19whitney-span/19whitney-span-articleLarge.jpg', 600, 330 );
$card->setSiteAccount( 'nytimes', '807095' );
$card->setCreatorAccount( 'nashjain', '24134103' );

display($card);

$card = new SocialMarkupTags\TwitterCard( 'photo' );
$card->setURL( 'http://instagr.am/p/H4IZmoOZDk/' );
$card->setTitle( '' );
$card->setDescription( 'Good Morning, San Francisco' );
$card->setImage( 'http://instagr.am/p/H4IZmoOZDk/media/?size=l', 610, 610 );

// optional
$card->setSiteAccount( 'instagram', '180505807' );
$card->setCreatorAccount( 'sippey', '4711' );

display($card);

$card = new SocialMarkupTags\TwitterCard( 'player' );
$card->setURL( 'http://www.youtube.com/watch?v=AEngFNb5CRU' );
$card->setTitle( 'Apple - The New iPad' );
$card->setDescription( 'iPad is a magical window where nothing comes between you and what you love. Now that experience is even more incredible with the new iPad.' );
$card->setImage( 'http://i2.ytimg.com/vi/AEngFNb5CRU/hqdefault.jpg', 480, 360 );
$card->setVideo( 'https://www.youtube.com/embed/AEngFNb5CRU', 435, 251 );

// optional
$card->setSiteAccount( 'youtube', '10228272' );

display($card);

function display($element, $addBreaks=true)
{
    if($addBreaks) echo "<br><br>";
    echo nl2br(htmlentities($element->toHTML()));
}