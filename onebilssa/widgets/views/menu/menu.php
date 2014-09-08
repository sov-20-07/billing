<div class="ltCell cell_site-tree sizeParent jsSizeable">
	<div class="ltContainer ltFullWidth sizeChild">
		<?if(Funcs::$uri[1]=='tree'):?>
			<div class="ltRow">
				<div class="widget_search input_text_holder"><span class="icon_search"></span><input type="text" class="input_text"></div>
				<hr class="widget_search_separator">
			</div>
		<?endif?>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll grayOverflow">
					<ul class="catalog-menu main">
					<?foreach($list as $item):?>
						<li class="catalog-menu_item jsMenuItem jsOpened">
							<a class="catalog-menu_link main" href="<?=$item['path']?>"><?=$item['name']?></a>											
							<?if(count($item['list'])>0 && $item['selected']):?>
								<ul class="catalog-menu">
								<?foreach($item['list'] as $item2):?>
									<li class="catalog-menu_item jsMenuItem <?if($item2['selected']):?>active<?endif?>">
										<a class="catalog-menu_link" href="<?=$item2['path']?>"><?=$item2['name']?></a>												
									</li>
								<?endforeach?>
								</ul>
							<?endif?>
						</li>
					<?endforeach?>
					</ul>
				</div>
			</div>
		</div>
		<div class="ltRow cell_site-tree_footer">
		</div>
	</div>
</div>