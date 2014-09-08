<div class="right-block-content" style="position: relative;">
    <?CrumbsWidget::run()?>
    <span class="print"><a href="print" target="_blank" class="icon ic_print">Версия для печати</a></span>
	<h1><?=$name?></h1>
	<?=$fields['fulltext']?>
	<span class="back-link"><a href="/<?=Funcs::$uri[0]?>/<?=Funcs::$uri[1]?>/">Вернуться к новостям</a></span>
	<span class="print"><a href="print" target="_blank" class="icon ic_print">Версия для печати</a></span>
</div>
<div class="left-block-content">
	<?MenuWidget::LeftMenu()?>
	<?BannersWidget::run()?>
</div>