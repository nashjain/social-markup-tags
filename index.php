<?php
include_once __DIR__."/OpenGraph/MetaTags.php";

$image = new OpenGraph\Image();
$image->setURL( 'http://example.com/image.jpg' );
$image->setSecureURL( 'https://example.com/image.jpg' );
$image->setType( 'image/jpeg' );
$image->setWidth( 400 );
$image->setHeight( 300 );

$video = new OpenGraph\Video();
$video->setURL( 'http://example.com/video.swf' );
$video->setSecureURL( 'https://example.com/video.swf' );
$video->setType( OpenGraph\Video::extension_to_media_type( pathinfo( parse_url( $video->getURL(), PHP_URL_PATH ), PATHINFO_EXTENSION ) ) );
$video->setWidth( 500 );
$video->setHeight( 400 );

$audio = new OpenGraph\Audio();
$audio->setURL( 'http://example.com/audio.mp3' );
$audio->setSecureURL( 'https://example.com/audio.mp3' );
$audio->setType('audio/mpeg');

$ogp = new OpenGraph\MetaTags();
$ogp->setLocale( 'en_US' );
$ogp->setSiteName( 'Happy place' );
$ogp->setTitle( 'Hello world' );
$ogp->setDescription( 'We make the world happy.' );
$ogp->setType( 'website' );
$ogp->setURL( 'http://example.com/' );
$ogp->setDeterminer( 'the' );

$ogp->addImage($image);
$ogp->addAudio($audio);
$ogp->addVideo($video);
var_dump($ogp->toHTML());

include_once __DIR__."/OpenGraph/Objects/Article.php";
$article = new OpenGraph\Article();
$article->setPublishedTime( '03-11-2011 01:28' );
$article->setModifiedTime( 'now' );
$article->setExpirationTime( '31-12-2011 23:59' );
$article->setSection( 'Front page' );
$article->addTag( 'weather' );
$article->addTag( 'football' );
$article->addAuthor( 'http://example.com/author.html' );
var_dump($article->toHTML());

include_once __DIR__."/OpenGraph/Objects/Book.php";
$book = new OpenGraph\Book();
$book->addAuthor("http://examples.opengraphprotocol.us/profile.html");
$book->setISBN("978-1451648539");
$book->setReleaseDate('03-11-2011 01:28');
$book->addTag("Steve Jobs");
$book->addTag("Apple");
var_dump($book->toHTML());

include_once __DIR__."/OpenGraph/Objects/Profile.php";
$profile = new OpenGraph\Profile();
$profile->setFirstName("Naresh");
$profile->setLastName("Jain");
$profile->setGender("male");
$profile->setUsername("nashjain");
var_dump($profile->toHTML());

include_once __DIR__."/OpenGraph/Objects/VideoMovie.php";
$videoEpisode = new OpenGraph\VideoMovie();
$videoEpisode->addActor("http://examples.opengraphprotocol.us/profile.html", "Antagonist");
$videoEpisode->addDirector("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addWriter("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addTag("Thriller");
$videoEpisode->addTag("Hollywood");
$videoEpisode->setReleaseDate('03-11-2011 01:28');
$videoEpisode->setDuration(100);
var_dump($videoEpisode->toHTML());

include_once __DIR__."/OpenGraph/Objects/VideoEpisode.php";
$videoEpisode = new OpenGraph\VideoEpisode();
$videoEpisode->addActor("http://examples.opengraphprotocol.us/profile.html", "Antagonist");
$videoEpisode->addDirector("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addWriter("http://examples.opengraphprotocol.us/profile.html");
$videoEpisode->addTag("Thriller");
$videoEpisode->addTag("Hollywood");
$videoEpisode->setReleaseDate('03-11-2011 01:28');
$videoEpisode->setDuration(100);
$videoEpisode->setSeries("http://example.com/series.html");
var_dump($videoEpisode->toHTML());
