<div id="content">
	<?CrumbsWidget::run()?>
	<div class="filter">
		<div class="left-coll">
		<?if (Funcs::$uri[0]=='opt' && count(Funcs::$uri)==1){?>
		<div style="margin-top: 10px;">
		<span style="font-weight: bold; font-size: 12px;">Мы являемся официальным дилером ведущих компаний-производителей радар-детекторов и видеорегистраторов</span>
		<br /><br />
		<table style="width: 100%; border-collapse: collapse;">
		<colgroup>
		<col width="50%"><col width="50%">
		</colgroup>
		<tr>
		<td style="text-align: left; vertical-align: middle;"><img src="/i/logos/1.png" /></td><td style="text-align: left; vertical-align: middle;"><img src="/i/logos/2.png" /></td>
		</tr>
		<tr>
		<td style="text-align: left; vertical-align: middle;"><img src="/i/logos/3.jpg" /></td><td style="text-align: left; vertical-align: middle;"><img src="/i/logos/4.png" /></td>
		</tr>
		<tr>
		<td><img src="/i/logos/5.png" /></td><td style="text-align: left; vertical-align: middle;"><img src="/i/logos/6.jpg" /></td>
		</tr>
		<tr>
		<td><img src="/i/logos/7.jpg" /></td><td style="text-align: left; vertical-align: middle;"><img src="/i/logos/8.png" /></td>
		</tr>
		<tr>
		<td><img src="/i/logos/9.jpg" /></td><td style="text-align: left; vertical-align: middle;"><img src="/i/logos/10.jpg" /></td>
		</tr>
		<tr>
		<td><img src="/i/logos/11.png" /></td><td style="text-align: left; vertical-align: middle;"><img src="/i/logos/12.png" /></td>
		</tr>
		<tr>
		<td><img src="/i/logos/13.jpg" /></td>
		</tr>
		</table>
		</div>
		<?}?>
			<?MenuWidget::LeftMenu()?>
			<?BannersWidget::run()?>
		</div>
		<div class="right-coll">
			<h1><?=$name?></h1>
			<?foreach($fields as $item):?>
				<?=$item?>
			<?endforeach?>
			<?/*?>
			<div <?if($_SESSION['user']):?>contenteditable onblur="alert('saving')"<?endif?>>
				<?=$fields['fulltext']?>
			</div>
			<?*/?>
		</div>
	</div>
	<div class="clear"></div>
</div>