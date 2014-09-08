<a name="up"></a>
<div id="content">
	<?CrumbsWidget::run()?>
	<div class="filter">
		<div class="left-coll">
			<?PanelWidget::vert()?>
		</div>
		<div class="right-coll">
			<h1><?=$name?></h1>
			<div class="hr" style="margin-top: 18px;margin-bottom: 15px;"></div>
			<table class="catalog-list">
			<?foreach($list as $items):?>
				<tr>
				<?foreach($items as $key=>$item):?>
					<?if($item['name']):?>
						<td><?=View::getRenderEmpty('catalog/listmodel',$item)?></td>
						<?if($key<2):?><td class="sep">&nbsp;</td><?endif?>
					<?else:?>
						<td>&nbsp;</td>
						<?if($key<2):?><td class="sep">&nbsp;</td><?endif?>
					<?endif?>
				<?endforeach?>
				</tr>
			<?endforeach?>
			</table>
			<div class="hr" style="margin-bottom: 18px;"></div>
		   	<div class="nav-bar">
				<a href="#up" class="up-but"></a>
				<?PaginationWidget::run()?>
		   </div>
		</div>
	</div>
	<div class="clear"></div>
</div>