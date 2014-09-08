<!DOCTYPE html>
<html>
	<head>
		<title><?=Funcs::$seo_title?></title>
	</head>
	<body style="font-family: sans-serif;font-size: 13px;">
		<div style="border-bottom:1px solid #999999">
			<img alt="<?=Funcs::$conf['settings']['site_name']?>" src="/i/logo.png">
			<h3 style="float:right;"><?=Funcs::$conf['settings']['phone']?></h3>
		</div>
		<h2><?=$name?></h2>
		<?=$fields['fulltext']?>
		<?=$fields['additional']?>
		<script>
			window.print();
		</script>
	</body>
</html>