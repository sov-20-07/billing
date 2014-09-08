<style>
.popup .close {
background: url('/i/pop-up-close.png') no-repeat 0 0px !important;
top: 10px !important;
right: 10px !important;
}
</style><div class="pop-up2" style="width: 100%;">
<?foreach ($list as $item){?>
<div style="display: inline-block; width: 570px; height: 180px;">
<span class="name"><?=$item['name']?></span>
<div style="width: 100%; display: inline-block;">
<div style="float: left; width: 150px; height: 180px;">
<img src="/of/9<?=$item['pics'][0]['path']?>" alt="<?=$pics[0]['name']?>" style="width: 141px;margin-top: 10px;"/>
</div>

<div class="text">
<?=$item['additional']['small_characteristics']?>
</div>
<div style="float: left; height: 180px;">
<span class="price"><?=number_format($item['price'],0,'',' ')?><span class="rub">a</span></span><br /><br />
<a target="_top" href="<?=$item['path']?>" class="pop-up-but">Подробнее</a>
</div>

</div>
</div>
<?}?>
</div>
