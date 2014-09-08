<tr>
	<td style="color: #000000;font-size: 14px;text-transform: uppercase;text-align: center;font-weight: bold;padding-top: 7px;padding-bottom: 7px;">
		Оставьте отзыв
	</td>
</tr>
<tr>
	<td style="background: #fff;padding: 25px;">
		<table cellpadding="0" cellspacing="0" style="font-size: 13px;">
			<tr>
				<td>
					<table width="100%" cellpadding="8" cellspacing="0" border="0">
						<tr>
							<td style="width: 82px; padding: 8px 0 2px; vertical-align: top; font-size: 11px; border-bottom: #ededed 1px solid;"></td>
							<td style="padding: 8px 15px 2px 0; vertical-align: top; font-size: 11px; border-bottom: #ededed 1px solid;font-family: Arial, Helvetica, sans-serif; color: #333;">Название</td>
							<td style="width: 100px; padding: 8px 0 2px; vertical-align: top; font-size: 11px; border-bottom: #ededed 1px solid;font-family: Arial, Helvetica, sans-serif; color: #333;">Цена</td>
							<td style="width: 90px; padding: 8px 0 2px; vertical-align: top; font-size: 11px; border-bottom: #ededed 1px solid;"></td>
						</tr>
						<?foreach($list as $i=>$item):?>
							<tr>
								<td style="padding: 8px 15px 2px 0; vertical-align: top; border-bottom: #ededed 1px solid;">
									<?if($item['pics'][0]['path']):?>
										<img src="http://<?=$_SERVER['HTTP_HOST']?>/of/1<?=$item['pics'][0]['path']?>" />
									<?endif?>
									
								</td>
								<td style="padding: 8px 0; vertical-align: top; border-bottom: #ededed 1px solid;font-family: Arial, Helvetica, sans-serif; color: #333;font-size: 12px;"><a href="http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?>?report=<?=md5($email.'report')?>#bkm4" style="color: #485666;"><?=$item['name']?></a> &nbsp; </td>
								<td style="padding: 8px 0; vertical-align: top; border-bottom: #ededed 1px solid;font-family: Arial, Helvetica, sans-serif; color: #333;font-size: 12px;"><?=number_format($item['price'],0,',',' ')?> руб.</td>
								<td style="padding: 8px 0; vertical-align: top; border-bottom: #ededed 1px solid;font-family: Arial, Helvetica, sans-serif; color: #333;font-size: 12px;"><a href="http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?>?report=<?=md5($email.'report')?>#bkm4" style="color: #485666;">Оставьте отзыв</a></td>
							</tr>
						<?endforeach?>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td style="color: #000000;font-size: 14px;text-transform: uppercase;text-align: center;font-weight: bold;padding-top: 7px;padding-bottom: 7px;">
		Оставьте отзыв
	</td>
</tr>