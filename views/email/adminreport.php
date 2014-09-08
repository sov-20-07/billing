<tr>
	<td colspan="3" height="37">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td width="30" height="37">&nbsp;</td>
				<td width="162">
					<div style="display:block; border-bottom:1px solid #eeeeee; width:162px "></div>
				</td>
				<td width="275" style="font-size: 18px; text-align: center; text-transform: uppercase;">
					<b style="font-size: 18px; text-transform: uppercase;">Оставлен отзыв</b>
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
								<span style="font-size:12px; font-weight:700; color:#333333; display:block; padding-top:13px; text-align:left;">&nbsp;</span>
							</td>
						</tr>
						<tr>
							<td height="50" style="vertical-align:top; font-size:12px; color:#666666; text-align:left;">
								<b>Ссылка на отзыв:</b> <a href="http://<?=$_SERVER['HTTP_HOST']?><?=$path?>#bkm3">http://<?=$_SERVER['HTTP_HOST']?><?=$path?>#bkm3</a><br />
								<b>Имя:</b> <?=$_SESSION['iuser']['name']?><br />
								<b>Email:</b> <a href="mailto:<?=$_SESSION['iuser']['email']?>"><?=$_SESSION['iuser']['email']?></a><br />
								<b>Рейтинг:</b> <?=$_POST['stars']?><br />
								<b>Отзыв:</b><br /><?=nl2br($_POST['report'])?><br />
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
											<b>FotoBuka</b>
										</td>
											<td width="188">
												<div style="display:block; border-bottom:1px solid #eeeeee; width:100%"></div>
											</td>
										</tr>