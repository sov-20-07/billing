Добрый день, <?=$dealer['name']?>.<br>
Статус Вашего заказа №D<?=date("dmY",strtotime($order['cdate']))?>-<?=$order['id']?> изменился на &laquo;<?=$order['statusname']?>&raquo;<br>
