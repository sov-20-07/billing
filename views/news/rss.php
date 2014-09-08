<?
header('Content-type: text/html; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8"?>' . "\r\n"
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?=Funcs::$conf['additional']['rss_title']?></title>
		<link>http://<?=str_replace('www.','',$_SERVER['HTTP_HOST'])?></link>
		<description><?=Funcs::$conf['additional']['rss_description']?></description>
		<atom:link href="http://<?=$_SERVER["HTTP_HOST"] ?>/rss/" rel="self" type="application/rss+xml" />
		<language>ru</language>
		<copyright>Copyright <?=date("Y") ?> <?=Funcs::$conf['additional']['rss_title']?></copyright>
		<image>
			<url>http://<?=$_SERVER['HTTP_HOST']?>/favicon.ico</url>
			<title><?=Funcs::$conf['additional']['rss_title']?></title>
			<link>http://<?=$_SERVER['HTTP_HOST']?></link>
		</image>
		<?foreach($list as $item):?>
			<item>
				<title><?=$item["name"]?></title>
				<link><?=$item["path"]?></link>
				<description><?=$item["preview"]?></description>
				<guid><?=$item["path"]?></guid>
				<pubDate><?=$item["udate"]?></pubDate>
			</item>
		<?endforeach?>
	</channel>
</rss>