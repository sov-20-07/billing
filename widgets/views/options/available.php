<div class="option_block <?if($act==1):?>act<?endif?>">
	<div class="head sliding" id="opt1">Наличие на складе<span class="icon down_arrow2 <?if($act==1):?>up_arrow2<?endif?>"></span></div>
	<div class="padds sliding_opt1">
		<?if($_GET['a']==''):?>
			<b>Все</b>
			<span class="separator"></span><a href="?a=1<?=Funcs::getFG('a','&')?>">В наличии</a>
		<?else:?>
			<a href="<?=Funcs::getFG('a','?')?>">Все</a>
			<span class="separator"></span><b>В наличии</b>
		<?endif?>
	</div>
</div>