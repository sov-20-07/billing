<center>
<table width="100%" cellpadding="10" cellspacing="0" style="font-family: Arial; color:#333333; font-size: 12px; line-height: 18px;">
	<tr>
		<td valign="bottom" style="border-bottom:1px solid #dcdcdc">
			<a href="http://<?=$_SERVER['HTTP_HOST']?>"><img alt="" src="http://<?=$_SERVER['HTTP_HOST']?>/i/logo.png" style="border:0;" /></a>
		</td>
	</tr>
	<tr>
		<td>{content}</td>
	</tr>
	<tr>
		<td>			
				<a href="http://<?=$_SERVER['HTTP_HOST']?>" class="fn org url"><?//=Funcs::$conf['site_name']?></a><br />
			<?/*?>
	            Тел.:<?=$this->config['tel']?>; факс: <?=$this->config['fax']?><br />
	            <?=$this->config['fulladdress']?><br />
	            <a href="mailto:<?=$this->config['email']?>"><?=$this->config['email']?></a><br />
			<?*/?>
            <br />Это письмо написано роботом, на него не надо отвечать.			
		</td>
	</tr>
</table>