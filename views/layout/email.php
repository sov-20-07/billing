<table  cellpadding="0" cellspacing="0" width="100%" style="background:#052247;font: 14px Calibri, Arial, Helvetica, sans-serif;height: 100%">
    <tr>
        <td width="100%" style="height: 100%;padding-bottom: 30px;">
            <table cellpadding="0" cellspacing="0" align="center" width="800" style="background: #fff; ">
                <? /* <tr>
                    <td style="width: 604px;height:90px;background-color:#ffffff;padding-left: 20px;padding-right: 20px;padding-top: 20px;padding-bottom: 20px;">
                       <table cellpadding="0" cellspacing="0" style="color: #000000;width: 100%">
                            <tr>
                                <td style="width: 215px;">
                                    <img src="http://<?=$_SERVER['HTTP_HOST']?>/i/logo-mail.jpg" alt=""/>
                                </td>
                                <td style="width: 200px;color: #666666;font-size: 12px;vertical-align: top;padding-left: 30px;">
                                    Москва,<br/>
                                    <?=date('d')?> <?=Funcs::$monthsRus[date('n')-1]?> <?=date('Y')?> года
                                </td>
                                <td style="vertical-align: top;font-size: 11px;">
                                    <span style="text-transform: uppercase">наш номер</span><br/>
                                    <span style="font-size: 20px;font-weight: bold;"><?=Funcs::$conf['settings']['phone']?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>*/ ?>
				{content}
				<? /* 
                <tr>
                    <td style="width: 644px;height:90px;background-color:#e5f2ff;color: #666666;text-align: center;font-size: 11px">
                        Вы получили письмо как клиент <a href="http://<?=$_SERVER['HTTP_HOST']?>/" style="color: #fff"><?=$_SERVER['HTTP_HOST']?></a><br/>
                        Не отвечайте на это письмо — оно рассылается автоматически.<br/>
                        Служба поддержки клиентов: <a href="<?=Funcs::$conf['settings']['email']?>" style="color: #666666"><?=Funcs::$conf['settings']['email']?></a><br/>
                    </td>
                </tr> */ ?>
                
            </table>
        </td>
    </tr>
</table>
