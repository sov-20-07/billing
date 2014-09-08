<?
class Selling{
	public static function getList($author=0){
		$order=$_GET['sort']==''?'code':$_GET['sort'];
		$order.=$_GET['desc']=='on'?' DESC ':'';
		$where='';
		if(trim($_GET['q']))$where=' AND (code=\''.$_GET['q'].'\' OR name LIKE \'%'.$_GET['q'].'%\')';
		if(is_numeric($_GET['from']) && is_numeric($_GET['to'])){
			$where.=' AND (balance BETWEEN '.$_GET['from'].' AND '.$_GET['to'].')';
		}elseif(is_numeric($_GET['from'])){
			$where.=' AND balance>='.$_GET['from'].'';
		}elseif(is_numeric($_GET['to'])){
			$where.=' AND balance<='.$_GET['to'].'';
		}
		$sql='SELECT * FROM {{iusers}} WHERE author='.$author.' '.$where.' ORDER BY '.$order.'';
		return DB::getPagi($sql);
	}
	public static function getOne($id){
		$sql='SELECT * FROM {{iusers}} WHERE id='.$id.'';
		$data=DB::getRow($sql);
		$order=$_GET['sort']==''?'{{iusers}}.id':$_GET['sort'];
		$order.=$_GET['desc']=='on'?' DESC ':'';
		$where='';
		if(trim($_GET['goods']))$where=' AND (goodsid=\''.$_GET['goods'].'\' OR goodsname LIKE \'%'.$_GET['goods'].'%\')';
		if($_GET['from'] && $_GET['to']){
			$where.=' AND (cdate BETWEEN \''.date('Y-m-d H:i:00',strtotime($_GET['from'])).'\' AND \''.date('Y-m-d H:i:00',strtotime($_GET['to'])).'\')';
		}elseif($_GET['from']){
			$where.=' AND cdate>=\''.date('Y-m-d H:i:00',strtotime($_GET['from'])).'\'';
		}elseif($_GET['to']){
			$where.=' AND cdate<=\''.date('Y-m-d H:i:00',strtotime($_GET['to'])).'\'';
		}
		$field1='iuser';
		$field2='author';
		if($data['author']==1) {
			$field1='author';
			$field2='iuser';
		}
		$data['field']=$field2;
		$sql='
			SELECT {{orders}}.*, {{iusers}}.name AS iusername, {{iusers}}.code FROM {{orders}} 
			INNER JOIN {{iusers}} ON {{orders}}.'.$field2.'={{iusers}}.id
			WHERE 1=1 '.$where.' AND {{orders}}.'.$field1.'='.$id.' 
			ORDER BY '.$order.'
		';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			//$sql='SELECT name FROM {{iusers}} WHERE id='.$item[$field2].'';
			//$item['iusername']=DB::getOne($sql);
			$data['list'][]=$item;
		}
		return $data;
	}
	public static function export($author){
		$sql='SELECT * FROM {{iusers}} WHERE author='.$author.' ORDER BY code';
		$list=DB::getAll($sql);
		header('Content-Type: text/html; charset=utf-8');
		header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		header('Content-transfer-encoding: binary');
		header('Content-Disposition: attachment; filename=export.xls');
		header('Content-Type: application/octet-stream');
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("")
									 ->setLastModifiedBy("")
									 ->setTitle("Office 2007 XLSX")
									 ->setSubject("Office 2007 XLSX")
									 ->setDescription("Document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("GBROS file");

		$sheet=$objPHPExcel->setActiveSheetIndex(0);
		$sheet->setCellValue('A1','ID');
		$sheet->setCellValue('B1','Имя');
		$sheet->setCellValue('C1','Баланс, руб.');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		foreach($list as $i=>$item){
			$sheet->setCellValue('A'.($i+2),$item['code']);
			$sheet->setCellValue('B'.($i+2),$item['name']);
			$sheet->setCellValue('C'.($i+2),$item['balance']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('B'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.($i+1))->getAlignment()->setWrapText(true);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Лист 1');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
?>