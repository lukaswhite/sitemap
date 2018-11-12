# Sitemap

A PHP 7.1+ library for building sitemaps, to be written to various formats; most notably as an XML sitemap.

[![CircleCI](https://circleci.com/gh/lukaswhite/sitemap.svg?style=svg)](https://circleci.com/gh/lukaswhite/sitemap)

## Installation

Install the package using Composer:

```
composer require lukaswhite/sitemaps
```

> This package requires PHP version 7.1 or greater

## Creating a Sitemap

```php
use Lukaswhite\Sitemap\Sitemap;
$sitemap = Sitemap( );
```

You can also provide the location of the sitemap. This is required for certain formats, such as RSS and Atom.

```php
$sitemap->setLocation( 'http://example.com/sitemap.rss' );
```

It's also a good idea to set the date & time that the sitemap was modified; particularly if you're generating a sitemap list:

```php
$sitemap->setLastModified( new \DateTime( ) );
// or
$sitemap->setLastModified(
	( new \DateTime( ) )->setDate( 2018, 11, 15 )->setTime( 9, 45, 0 )
);
// or, if youre using Carbon:
$sitemap->setLastModified( Carbon::now( ) );
```

## Adding Pages

To create a page with the minimum information:

```php
use Lukaswhite\Sitemap\Page;

$sitemap
	->addPage(
		new Page(
			'http://www.example.com'
		)
	);
```

You may also provide a title, the date & time the page was last modified, the sitemap priority and/or the change frequency:

```php
use Lukaswhite\Sitemap\Page;

$sitemap
	->addPage(
		new Page(
			'http://www.example.com',
			'Homepage',
			( new \DateTime( ) )->setDate( 2018, 11, 20 ),
			1,
			Page::CHANGE_FREQ_MONTHLY
		)
);
```

> The title isn't used for XML sitemaps, but it's required for RSS and Atom sitemaps.

> The sitemap priority is a float between 0 and 1, and if it isn't provided then it defaults to 0.5.

There are also some convenience methods for setting the page frequency:

```php
$page->alwaysChanges( );
$page->changesYearly( );
$page->changesMonthly( );
$page->changesWeekly( );
$page->changesDaily( );
$page->changesHourly( );
$page->neverChanges( );
```

## Creating an XML Sitemap

Once you've created your sitemap programmatically, the most common scenario is probably to render it as an XML sitemap.

```php
use Lukaswhite\Sitemap\Writer\Xml;

$writer = new Xml( $sitemap );

$xml = $writer->write( );
// or
$writer->save( '/path/to/sitemap.xml' );
```

If you want to provide an XSL stylesheet, which means that you can provide it in HTML format if someone visits it in a browser directly, you can do so like this:

```php
$writer->addXslStylesheet( 'http://example.com/styles.xsl' );
```

You can add any additional processing instructions using `addProcessingInstruction( $name, value )`.

You may also wish to add comments; for example, you could use this to display aa human-readable indication of when the sitemap was generated, or how it was generated.

```php
$writer->addComment( sprintf( 'Generated on %s.', date('d/m/Y' ) );
$writer->addComment( 'Generated using Sitemap by Lukas White' );
```

## Plain-text Sitemaps

A plain-text sitemap is simply a text file, with the URLs that make up the sitemap separated by newlines. They're supported by Google as an alternative to XML sitemaps, although note that information such as the priority and change frequency isn't included by design, so they're rather more limited than XML sitemaps.

```php
use Lukaswhite\Sitemap\Writer\Text;

$writer = new Text( $sitemap );

$text = $writer->write( );
// or
$writer->save( '/path/to/sitemap.txt' );
```

## RSS Sitemaps

You can also create a sitemap in RSS format.

> The RSS writer is pretty limited; You may wish to consider using [my feed writer package](https://github.com/lukaswhite/php-feed-writer) instead.

```php
use Lukaswhite\Sitemap\Writer\RSS;

$writer = new RSS( $sitemap );

$feed = $writer->write( );
// or
$writer->save( '/path/to/sitemap.rss' );
```

> You must set the location of the sitemap in order to create a valid feed.

Note that a valid RSS feed requires that the `<channel>` element includes a title and description, although they aren't really required for sitemaps. Because they are required for the feed to validate, the library outputs some defaults. If you wish, though, you can override these:

```php
$writer->setChannelTitle( 'My Sitemap' );
$writer->setChannelDescription( 'This is a sitemap' );
```

## Atom Sitemaps

You can also create a sitemap in Atom format.

> The Atom writer is pretty limited; You may wish to consider using [my feed writer package](https://github.com/lukaswhite/php-feed-writer) instead.

```php
use Lukaswhite\Sitemap\Writer\Atom;

$writer = new Atom( $sitemap );

$feed = $writer->write( );
// or
$writer->save( '/path/to/sitemap.atom' );
```

> You must set the location of the sitemap in order to create a valid feed.

Note that a valid Atom feed requires that the `<feed>` element includes a title, ID and author, although they aren't really required for sitemaps. Because they are required for the feed to validate, the library outputs some defaults. If you wish, though, you can override these:

```php
$writer->setFeedId( 'my-custom-feed-id' );
$writer->setFeedTitle( 'My Atom Sitemap Feed' );
$writer->setFeedAuthor( 'Bob', 'bob@example.com' );
```

You can also set the ID on individual pages using -`>setId()`.


## HTML Sitemaps

You can use the HTML writer to generate an HTML-based sitemap.

It's pretty simple; it simply generates an unordered list of links. 

```php
use Lukaswhite\Sitemap\Writer\Html;

$writer = new Html( $sitemap );

$ul = $writer->write( );
```

Here's an example:

```php
$sitemap = new Sitemap( );

$sitemap
	->addPage( new Page(
	    'http://www.example.com',
	    'Homepage'
	) )
	->addPage( new Page(
		'http://www.example.com/about'
	)
);
```

The result:

```html
<ul>
	<li><a href="http://www.example.com" title="Homepage">Homepage</a></li>
	<li><a href="http://www.example.com/about">http://www.example.com/about</a></li>
</ul>
```

## JSON Sitemaps

JSON isn't a format generally used for sitemaps. However, there are some circumstances in which it might be useful.

For a large application, it might be helpful to be able to inspect a sitemap from an admin panel. One way of doing this is to build a component that displays the current sitemap from a JSON API; that's where this writer might come in.

```php
use Lukaswhite\Sitemap\Writer\Json;

$writer = new Json( $sitemap );

$feed = $writer->write( );
// or
$writer->save( '/path/to/sitemap.json' );
```

## Custom Writers

You're free to create your own custom writer; simply extend `AbstractWriter` and implement the `write()` method.

## Getting Data

Alternatively, you may wish to pull data out of the sitemap for manipulation, sorting, or other purposes.

The `getPages()` method on the `Sitemap` class returns an array of instances of the `Page` class. This in turn provides methods such as `getUrl()`, `getTitle()`, `getPriority()` and `getChangeFreq()`.

## Splitting Up Large Sitemaps

If your sitemap starts to get very large, you may split it up into separate files. This is done by creating a **sitemap list**.

```php

use Lukaswhite\Sitemap\SitemapList;
use Lukaswhite\Sitemap\Sitemap;

$list = new SitemapList( );
$list
	->addSitemap(
		( new Sitemap( ) )->setLocation(
			'http://example.com/sitemap1.xml'
		)->setLastModified( ( new \DateTime( ) )->setDate( 2018, 11, 20 ) )
	)
	->addSitemap(
		( new Sitemap( ) )->setLocation(
			'http://example.com/sitemap2.xml'
		)->setLastModified( ( new \DateTime( ) )->setDate( 2018, 11, 24 ) )
);

$list = $writer->write( );
// or
$list->save( '/path/to/sitemap-list.xml' );
```

> Note that in order to create a sitemap, you MUST set the location of the sitemap, for obvious reasons.

> You need to create a Sitemap instance in order to craete a sitemap list, but you don't necessarily need to build them fully at the same time, since all the sitemap list includes is the URL and last modified date/time.

## Sorting the Sitemap

Most often, the library will probably be used for generating XML sitemaps; in which case the order of the entries makes no difference.

However if you're creating a JSON representation for inspecting in your back-end, or an HTML representation to embed in a page then it might be useful to sort the sitemap; for example by priority.

```php
$sitemap->sortByPriority( );
// or
$sitemap->sortByTitle( );
```

## Extensions

The library supports the following extensions:

* Links
* Images
* Videos

### Links

The links extension allows you to specify alternate version of pages, either in different languages or for specified locales. For example in Spanish, or in English for British audiences.

You still need to set the URL of a page as normal &mdash; this is then the "default" location of the page &mdash; and then you can add links as follows:

```php
$page->addAlternate( 'http://www.example.com/de', 'de' );
$page->addAlternate( 'http://www.example.com/gb', 'en-GB' );
```

### Images

You can associate one or more images with a page for more effective search engine crawling. an image requires a location (URL), but may also have a title, caption, geo-location and / or a license.

Here's a minimal example:

```php
use Lukaswhite\Sitemap\Extensions\Image;

$page->addImage(
	new Image( 'http://www.example.com/image1.jpg' )
);
```

Here's a more comprehensive example:

```php
use Lukaswhite\Sitemap\Extensions\Image;

$page->addImage(
	( new Image( 'http://www.example.com/image1.jpg' ) )
	->setCaption( 'Test image caption' )
	->setTitle( 'Test image title' )
	->setGeoLocation( 'London' )
	->setLicense( 'http://www.example.com/license.html' )
);
```

### Videos

You may also associate one or more videos with a page.

Here is an example that shows most of the available options:

```php

use Lukaswhite\Sitemap\Extensions\Video;
use Lukaswhite\Sitemap\Support\Video\Player;
use Lukaswhite\Sitemap\Support\Video\Price;
use Lukaswhite\Sitemap\Support\Video\Platform;
use Lukaswhite\Sitemap\Support\Video\Resriction;
use Lukaswhite\Sitemap\Support\Video\Uploader;

$page->addVideo(
$video =
	( new Video(  ) )
	->setTitle( 'Grilling steaks for summer' )
	->setDescription( 'Alkis shows you how to get perfectly done steaks every time' )
	->setContentLocation( 'http://streamserver.example.com/video123.mp4' )
	->setPlayer(
		new Player(
			'http://www.example.com/videoplayer.php?video=123',
			true // allow embedding
		)
	)
	->setDuration(600 )
	->setExpirationDate(
		( new \DateTime( ) )->setDate( 2021, 11, 05 )
		->setTime( 19, 20, 30 )
	)
	->setPublicationDate(
		( new \DateTime( ) )->setDate( 2007, 11, 05 )
		->setTime( 19, 20, 30 )
	)
	->setRating( 4.2 )
	->setPrice(
		( new Price( 1.99, 'EUR' ) )
		->setType( Price::OWN )
		->setResolution( Price::HD )
	)
	->addRestriction(
		( new Restriction( 'IE', 'GB', 'US', 'CA' ) )
		->allows( )
		)
	->setPlatform(
		( new Platform(
			Platform::TV,
			Platform::WEB
		) )
		->denies( )
	)
	->setLive( )
	->setFamilyFriendly( )
	->setRequiresSubscription( )
	->setViewCount( 1000 )
	->setTags( 'steak', 'grilling', 'summer' )
	->setCategories( 'Cooking', 'Beef' )
	->setUploader(
		new Uploader(
			'GrillyMcGrillerson',
			'http://www.example.com/users/grillymcgrillerson' // optional
		)
	);
);
```

Some notes on the example above:

* In the example the content location (i.e. the URL of the media file) is specified; either this *or* a URL to a thumbnail is required &mdash; you can set that using `setThumbnailLocation()`
* The price in the example is to own the high definition version; you can set the type to "rent" and/or the resolution to "sd", though the only required information is the actual price and the currency
* You can specify per-country restrictions; in this example we're allowing people in Great Britain, Ireland, the US and Canada to view it. You can also create a restriction type that denies access to certain countries
* You can allow or deny access to particular platforms (web, mobile, TV). In this example we're denying access to TV and Web; therefore making it mobile-only