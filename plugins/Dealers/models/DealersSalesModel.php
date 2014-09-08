<?
class DealersSales {
	public static $sale_one = array(
		'percents' => array(3, 5, 7),
		'limits'   => array(30000, 50000, 100000)
	);
	public static $sale_year = array(
		'percents' => array(2, 3, 5),
		'limits'   => array(30000, 50000, 100000)
	);
	public static function calc($sum,$what) {
		$sale = 0;
		foreach (self::$$what['limits'] as $key=>$item) {
			if ($sum > $item) {
				$sale = self::$$what['percents'][$key] * $sum * 0.01;
			}
		}
		return $sale;
	}
	public static function calcSale($orderId) {
		$order = DealersOrders::getOrderProp($orderId);

		$sql='
			SELECT {{dealers}},*, {{dealers_status}}.sale as statussale FROM {{dealers}}
			LEFT JOIN ((dealers_status)) ON {{dealers}}.status = {{dealers_status}}.id
			WHERE {{dealers}}.id='.$order['dealer'].'
		';
		$dealer = DB::getRow($dealerId);
		$sale_status = $dealer['statussale'];
		$sale_one = self::calc($order['sum'],'sale_one');
		$sale_year = self::calc($order['sum'],'sale_year');
		$sale_total = $sale_status + (max($sale_year,$sale)) + $order['add_sale'];
		return $sale_total;

	}
	public static function getSaleStatus($dealer) {
		return $dealer['statussale'];
		
	}
}
?>
