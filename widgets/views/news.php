<div class="head1"><h1>Мы в прессе</h1></div>
<?foreach($list as $item):?>
	<div class="date"><div><?=date('d.m.Y',strtotime($item['udate']))?></div></div>
	<div class="anons">
		<h2><a href="<?=$item['path']?>"><?=$item['name']?></a></h2>
		<?=$item['preview']?>
	</div>
<?endforeach?>
<div class="all_news"><div><a href="/about/news/" class="is_red">Читать все новости</a></div></div>