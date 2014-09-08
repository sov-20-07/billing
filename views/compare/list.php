<div class="compare-page">
	<?CrumbsWidget::run()?>
	<span class="print"><a href="?print">Версия для печати</a></span>
	<h1>Сравнение товаров</h1>
	<?if(count($list['items'])>0):?>
		<div class="head">
			<div class="nav">
				&nbsp;
				<div class="clicker">
					<div class="but"></div>
				</div>
				<span class="all-params">все параметры</span>
				<span class="different dotted">различающиеся</span>
			</div>
			<?foreach($list['items'] as $key=>$item):?>
				<div class="product">
					<div class="annotation">
						<a href="<?=$item['path']?>" class="sm-pic" style="background: url('/of/1<?=$item['pics'][0]['path']?>')"></a>
						<div class="text">
							<a href="<?=$item['path']?>"> <?=$item['name']?></a><br/>
						</div>
					</div>
					<div class="hover">
						<div class="buttons">
							<div class="delete to-click del del_from_compare" id="del<?=$key?>" ids="<?=$item['id']?>"></div>
							<div class="in-basket add_to_basket" path="popup" num="1" ids="<?=$item['id']?>"></div>
						</div>
					</div>
				</div>
			<?endforeach?>
		</div>
		<div class="clear"></div>
		<table>
			<tr>
				<td class="params">
					<b>Стоимость</b>
				</td>
				<?foreach($list['items'] as $key=>$item):?>
					<td class="del<?=$key?>">
						<span class="rub12"><b><?=number_format($item['price'],0,'',' ')?></b></span>
					</td>
				<?endforeach?>
			</tr>
		</table>
		<?if(is_array($list['items'][0]['additional'])):?>
			<?foreach($list['items'][0]['additional'] as $title=>$values):?>
				<div <?if(!isset($list['additional'][$title])):?>class="hideme"<?endif?>>
					<?if(is_array($values)):?>
						<h6><?=$title?></h6>
						<table>
						<?foreach($values as $k=>$v):?>
							<tr <?if(!isset($list['additional'][$title][$k])):?>class="hideme"<?endif?>>
								<td class="params">
									<?=$k?>
								</td>
								<?foreach($list['items'] as $key=>$item):?>
									<td class="del<?=$key?>">
										<?=$item['additional'][$title][$k] ?>
									</td>
								<?endforeach?>
							</tr>
						<?endforeach?>
						</table>
					<?else:?>
						<table>
							<tr <?if(!isset($list['additional'][$title])):?>class="hideme"<?endif?>>
								<td class="params">
									<?=$title?>
								</td>
								<?foreach($list['items'] as $key=>$item):?>
									<td class="del<?=$key?>">
										<?=$item['additional'][$title]?>
									</td>
								<?endforeach?>
							</tr>
						</table>
					<?endif?>
				</div>
			<?endforeach?>
		<?endif?>
	<?endif?>
	<span class="back-link"><a href="/catalog/" >Вернуться к подбору</a></span>
</div>