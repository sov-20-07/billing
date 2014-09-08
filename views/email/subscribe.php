<tr>
	<td colspan="3" height="37">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td width="30" height="37">&nbsp;</td>
				<td width="162">
					<div style="display:block; border-bottom:1px solid #eeeeee; width:162px "></div>
				</td>
				<td width="275" style="font-size: 18px; text-align: center; text-transform: uppercase;">
					<b style="font-size: 18px; text-transform: uppercase;">Появился товар на складе</b>
				</td>
				<td>
					<div style="display:block; border-bottom:1px solid #eeeeee; width:162"></div>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan="3">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td height="275" width="30">&nbsp;</td>
				<td style="vertical-align: top;">
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td height="47">
								<span style="font-size:12px; font-weight:700; color:#333333; display:block; padding-top:13px; text-align:left;"><?=str_replace('[name]',$user['name'],Funcs::$infoblock['email']['subscribe']['description'])?></span>
							</td>
						</tr>
						<tr>
							<td height="50" style="vertical-align:top; font-size:12px; color:#666666; text-align:left;">
								<span style="font-size:12px; font-weight:700; color:#333333; display:block; padding-top:13px; text-align:left;"><?=$name?></span><br />
								<?=$yandex_description?>
								<span style="font-size:12px; font-weight:700; color:#333333; display:block; padding-top:13px; text-align:left;"><?=number_format($price,0,',',' ')?> руб.</span><br />
								<a href="http://<?=$_SERVER['HTTP_HOST']?><?=$path?>"><img src="http://<?=$_SERVER['HTTP_HOST']?>/mail_i/button_buy.jpg" width="111" height="32" border="0" /></a>
							</td>
						</tr>
						<tr>
							<td height="47">
								<span style="font-size:12px; font-weight:700; color:#333333; display:block; padding-top:13px; text-align:left;">&nbsp;</span>
							</td>
						</tr>
					</table>
					<table cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<table>
									<tr>
										<td colspan="3" height="17">&nbsp;</td>
									</tr>
									<tr>
										<td width="177">
											<div style="display:block; border-bottom:1px solid #eeeeee; width:100% "></div>
										</td>
										<td width="235" style="font-size: 18px; text-align: center; text-transform: uppercase;">
											<b>RuClimat</b>
										</td>
											<td width="188">
												<div style="display:block; border-bottom:1px solid #eeeeee; width:100%"></div>
											</td>
										</tr>