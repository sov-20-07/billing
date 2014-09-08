<?='<?xml version="1.0" encoding="utf-8"?>'?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="<?=date('Y-m-d H:i')?>">
<shop>
	<name><?=Funcs::$conf['settings']['sitename']?></name>
 	<company><?=Funcs::$conf['settings']['sitename']?></company>
  	<url>http://<?=$_SERVER['HTTP_HOST']?>/</url>
  	<currencies>
  		<currency id="RUR" rate="1"/>
  	</currencies>
  	<categories>
	<?foreach($categories as $item):?>
		<category id="<?=$item['id']?>" <?if($item['parent']):?>parentId="<?=$item['parent']?>"<?endif?>><?=$item['name']?></category>
	<?endforeach?>
  	</categories>
  	<offers>
  	<?foreach($list as $item):?>
  		<offer id="<?=$item['id']?>" type="vendor.model" available="<?if($item['available']==1):?>true<?else:?>false<?endif?>" <?if($item['bid']>0):?>bid="<?=$item['bid']?>"<?endif?> <?if($item['cbid']>0):?>cbid="<?=$item['cbid']?>"<?endif?>>
  			<url>http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?></url>
  			<price><?=$item['price']?></price>
  			<currencyId>RUR</currencyId>
  			<categoryId><?=$item['parent']?></categoryId>
  			<?if($item['fields']['files_gal']['image'][0]['path']):?><picture>http://<?=$_SERVER['HTTP_HOST']?><?=$item['fields']['files_gal']['image'][0]['path']?></picture><?endif?>
  			<delivery>true</delivery>
			<local_delivery_cost><?=$item['local_delivery_cost']?></local_delivery_cost>
			<?
			switch ($item['parent']) {
			case 3:
				$typePrefix = 'Видеорегистратор';
				break;
			case 4:
				$typePrefix = 'Антирадар';
				break;
			case 5:
				$typePrefix = 'GPS навигатор';
				break;
			case 7:
				$typePrefix = 'Карта памяти';
				break;
			case 8:
				$typePrefix = 'Разветвитель';
				break;
			case 9:
				$typePrefix = 'Алкотестер';
				break;
			case 10:
				$typePrefix = 'GPS-трекер';
				break;
			case 294:
				$typePrefix = 'Камера для спорта';
				break;
				}
			?>
			<typePrefix><?=$typePrefix?></typePrefix>
  			<?/*if($item['typePrefix']):?><typePrefix><?=$item['typePrefix']?></typePrefix><?endif*/?>
  			<?if($item['vendor']):?><vendor><?=$item['vendor']?></vendor><?endif?>
  			<model><?=$item['name']?><?if($item['akcia']=='1'){?><?=' '.Funcs::$conf['akcia']['pristavka']?><?}?></model>
  			<?if($item['yandex_description']):?><description><?=$item['yandex_description']?></description><?endif?>
  		</offer>
  	<?endforeach?>
  	</offers>
</shop>
</yml_catalog>