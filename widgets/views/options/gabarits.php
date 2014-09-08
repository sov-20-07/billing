<?if($length['to']!='none' || $width['to']!='none' || $height['to']!='none'):?>
	<div class="option_block gabarits <?if($act==1):?>act<?endif?>">
		<div class="head sliding" id="opt3">Размеры<span class="icon down_arrow2 <?if($act==1):?>up_arrow2<?endif?>"></span></div>
		<div class="padds sliding_opt3">
			<?if($length['to']!='none'):?>
				<b>Длина</b>
				<div class="inline_block">
					<div class="from">от</div>
					<div class="field_block"><input type="text" class="text" value="<?=$_GET['lf']==''?'':$_GET['lf']?>" onkeyup="checknumbrintnull(this,<?=$_GET['lf']==''?'\'\'':$_GET['lf']?>);getOpt('lf',this,'ch');" /></div>
					<div class="to">до</div>
					<div class="field_block"><input type="text" class="text" value="<?=$_GET['lt']==''?'':$_GET['lt']?>" onkeyup="checknumbrintnull(this,<?=$_GET['lt']==''?'\'\'':$_GET['lt']?>);getOpt('lt',this,'ch');" /></div>
					<div class="cm">см</div>
				</div>
			<?endif?>
			<?if($width['to']!='none'):?>
				<b>Ширина</b>
				<div class="inline_block">
					<div class="from">от</div>
					<div class="field_block"><input type="text" class="text" value="<?=$_GET['wf']==''?'':$_GET['wf']?>" onkeyup="checknumbrintnull(this,<?=$_GET['wf']==''?'\'\'':$_GET['wf']?>);getOpt('wf',this,'ch');" /></div>
					<div class="to">до</div>
					<div class="field_block"><input type="text" class="text" value="<?=$_GET['wt']==''?'':$_GET['wt']?>" onkeyup="checknumbrintnull(this,<?=$_GET['wt']==''?'\'\'':$_GET['wt']?>);getOpt('wt',this,'ch');" /></div>
					<div class="cm">см</div>
				</div>
			<?endif?>
			<?if($height['to']!='none'):?>
				<b>Высота</b>
				<div class="inline_block">
					<div class="from">от</div>
					<div class="field_block"><input type="text" class="text" value="<?=$_GET['hf']==''?'':$_GET['hf']?>" onkeyup="checknumbrintnull(this,<?=$_GET['hf']==''?'\'\'':$_GET['hf']?>);getOpt('hf',this,'ch');" /></div>
					<div class="to">до</div>
					<div class="field_block"><input type="text" class="text" value="<?=$_GET['ht']==''?'':$_GET['ht']?>" onkeyup="checknumbrintnull(this,<?=$_GET['ht']==''?'\'\'':$_GET['ht']?>);getOpt('ht',this,'ch');" /></div>
					<div class="cm">см</div>
				</div>
			<?endif?>
		</div>
	</div>
<?endif?>