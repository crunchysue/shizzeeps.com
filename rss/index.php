<?php  
	define('URL_BASE','http://'.$_SERVER['SERVER_NAME']);
	header('Content-type: application/rss+xml');
	$pub_time = date('D, d M Y H:i:s +0000');

	$feed_title = 'Shizzeeps';
	
	
	//needs to be populated
	$places = array();
	$places[] = "test_place";
	$places[] = "test_place";
	
	/*
	
	Request from @donpdonp
	
	<item>
	<title>4 people are checked in at the Urban Grind Northwest</title>
	<description></description>
	<geo:lat>45.513122</geo:lat>
	<geo:long>-122.644189</geo:long>
	<georss:point>45.513122 -122.644189</georss:point>
	<link>http://www.shizzeeps.com/thingy/17883</link>
	<guid>http://www.shizzeeps.com/thingy/17883</guid>
	<pubDate>Tue, 03 Mar 2009 21:23:37 PST</pubDate>
	</item>

	*/
	
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	>

	<channel>
		<title><?=$feed_title?></title>
		<atom:link href="<?=URL_BASE?><?=$_SERVER['REQUEST_URI']?>" rel="self" type="application/rss+xml" />
		<link><?=URL_BASE?></link>
		<description>Feed of trending places from Shizzeeps</description>
		<pubDate><?=$pub_time ?></pubDate>
		<language>en</language>
		<sy:updatePeriod>hourly</sy:updatePeriod>
		<sy:updateFrequency>1</sy:updateFrequency>
		

		
		<?php foreach ($places as $place): ?>
			
			<item>
			<title>4 people are checked in at the Urban Grind Northwest</title>
			<description></description>
			<geo:lat>45.513122</geo:lat>
			<geo:long>-122.644189</geo:long>
			<georss:point>45.513122 -122.644189</georss:point>
			<link>http://www.shizzeeps.com/thingy/17883</link>
			<guid>http://www.shizzeeps.com/thingy/17883</guid>
			<pubDate><?=$pub_time?></pubDate>
			</item>
		
		<?php endforeach ?>
		
	</channel>

</rss>