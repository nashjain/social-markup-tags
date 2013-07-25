<?php
include_once __DIR__ . "/og/MarkupTags.php";

$ogp = new og\MarkupTags();
$ogp->locale( 'en_US' );
$ogp->siteName( 'Happy place' );
$ogp->title( 'Hello world' );
$ogp->description( 'We make the world happy.' );
$ogp->type( 'website' );
$ogp->url( 'http://example.com/' );
$ogp->determiner( 'the' );
$ogp->image('http://example.com/image.jpg', 'https://example.com/image.jpg', 400, 300);
$ogp->audio('http://example.com/audio.mp3', 'https://example.com/audio.mp3');
$ogp->video('http://example.com/video.swf', 'https://example.com/video.swf', 500, 400);
var_dump($ogp->toHTML());

include_once __DIR__ . "/og/Objects/Article.php";
$article = new og\Article();
$article->setPublishedTime( '03-11-2011 01:28' );
$article->setModifiedTime( 'now' );
$article->setExpirationTime( '31-12-2011 23:59' );
$article->setSection( 'Front page' );
$article->addTag( 'weather' );
$article->addTag( 'football' );
$article->addAuthor( 'http://example.com/author.html' );
var_dump($article->toHTML());

include_once __DIR__ . "/og/Objects/Book.php";
$book = new og\Book();
$book->addAuthor("http://examples.opengraphprotocol.us/profile.html");
$book->setISBN("978-1451648539");
$book->setReleaseDate('03-11-2011 01:28');
$book->addTag("Steve Jobs");
$book->addTag("Apple");
var_dump($book->toHTML());

include_once __DIR__ . "/og/Objects/Profile.php";
$profile = new og\Profile();
$profile->setFirstName("Naresh");
$profile->setLastName("Jain");
$profile->setGender("male");
$profile->setUsername("nashjain");
var_dump($profile->toHTML());

include_once __DIR__ . "/og/Objects/VideoMovie.php";
$videoEpisode = new og\VideoMovie();
$videoEpisode->addActor("http://examples.opengraphprotocol.us/profile.html", "Antagonist");
$videoEpisode->addDirector("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addWriter("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addTag("Thriller");
$videoEpisode->addTag("Hollywood");
$videoEpisode->setReleaseDate('03-11-2011 01:28');
$videoEpisode->setDuration(100);
var_dump($videoEpisode->toHTML());

include_once __DIR__ . "/og/Objects/VideoEpisode.php";
$videoEpisode = new og\VideoEpisode();
$videoEpisode->addActor("http://examples.opengraphprotocol.us/profile.html", "Antagonist");
$videoEpisode->addDirector("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addWriter("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addTag("Thriller");
$videoEpisode->addTag("Hollywood");
$videoEpisode->setReleaseDate('03-11-2011 01:28');
$videoEpisode->setDuration(100);
$videoEpisode->setSeries("http://example.com/series.html");
var_dump($videoEpisode->toHTML());

if ( ! class_exists( 'TwitterCard' ) )
    require_once __DIR__ . '/twitter/MarkupTags.php';

// build a card
$card = new SocialMarkupTags\TwitterCard();
$card->setURL( 'http://www.nytimes.com/2012/02/19/arts/music/amid-police-presence-fans-congregate-for-whitney-houstons-funeral-in-newark.html' );
$card->setTitle( 'Parade of Fans for Houston\'s Funeral' );
$card->setDescription( 'NEWARK - The guest list and parade of limousines with celebrities emerging from them seemed more suited to a red carpet event in Hollywood or New York than than a gritty stretch of Sussex Avenue near the former site of the James M. Baxter Terrace public housing project here.' );
// optional
$card->setImage( 'http://graphics8.nytimes.com/images/2012/02/19/us/19whitney-span/19whitney-span-articleLarge.jpg', 600, 330 );
$card->setSiteAccount( 'nytimes', '807095' );
$card->setCreatorAccount( 'nashjain', '24134103' );

// echo a string of <meta> elements
var_dump($card->asHTML());

$card = new SocialMarkupTags\TwitterCard( 'photo' );
$card->setURL( 'http://instagr.am/p/H4IZmoOZDk/' );
$card->setTitle( '' );
$card->setDescription( 'Good Morning, San Francisco' );
$card->setImage( 'http://instagr.am/p/H4IZmoOZDk/media/?size=l', 610, 610 );

// optional
$card->setSiteAccount( 'instagram', '180505807' );
$card->setCreatorAccount( 'sippey', '4711' );

// echo a string of <meta> elements
var_dump($card->asHTML());

$card = new SocialMarkupTags\TwitterCard( 'player' );
$card->setURL( 'http://www.youtube.com/watch?v=AEngFNb5CRU' );
$card->setTitle( 'Apple - The New iPad' );
$card->setDescription( 'iPad is a magical window where nothing comes between you and what you love. Now that experience is even more incredible with the new iPad.' );
$card->setImage( 'http://i2.ytimg.com/vi/AEngFNb5CRU/hqdefault.jpg', 480, 360 );
$card->setVideo( 'https://www.youtube.com/embed/AEngFNb5CRU', 435, 251 );

// optional
$card->setSiteAccount( 'youtube', '10228272' );

// echo a string of <meta> elements
var_dump($card->asHTML());