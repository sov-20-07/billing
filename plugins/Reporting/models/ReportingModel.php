<?
class Reporting{
	public static function getList(){
		$data=array();
		$order=$_GET['sort']==''?'cdate':$_GET['sort'];
		$order.=$_GET['desc']=='on'?' DESC ':'';
		
		$where='';
		if(trim($_GET['q']))$where=' AND ({{iusers}}.code=\''.$_GET['q'].'\' OR {{iusers}}.name LIKE \'%'.$_GET['q'].'%\')';
		if($_GET['from'] && $_GET['to']){
			$where.=' AND (cdate BETWEEN \''.date('Y-m-d H:i:00',strtotime($_GET['from'])).'\' AND \''.date('Y-m-d H:i:00',strtotime($_GET['to'])).'\')';
		}elseif($_GET['from']){
			$where.=' AND cdate>=\''.date('Y-m-d H:i:00',strtotime($_GET['from'])).'\'';
		}elseif($_GET['to']){
			$where.=' AND cdate<=\''.date('Y-m-d H:i:00',strtotime($_GET['to'])).'\'';
		}
		$sql='
			SELECT {{orders}}.*, iusers.name AS iusername, iusers.code AS iusercode, 
				authors.name AS authorname, authors.code AS authorcode FROM {{orders}} 
			INNER JOIN {{iusers}} iusers ON {{orders}}.iuser=iusers.id
			INNER JOIN {{iusers}} authors ON {{orders}}.author=authors.id
			WHERE {{orders}}.paid=1 '.$where.'
			ORDER BY '.$order.'
		';
		$list=DB::getPagi($sql);
		foreach($list as $item){
			$data[]=$item;
		}
		return $data;
	}
	public static function getOne($id){
		$sql='
			SELECT {{requests}}.*, {{iusers}}.name, {{iusers}}.balance FROM {{requests}} 
			INNER JOIN {{iusers}} ON {{requests}}.iuser={{iusers}}.id
			WHERE {{requests}}.id='.$id.'
		';
		$data=DB::getRow($sql);
		return $data;
	}
	public static function export(){
		$sql='
			SELECT {{orders}}.*, iusers.name AS iusername, iusers.code AS iusercode, 
				authors.name AS authorname, authors.code AS authorcode FROM {{orders}} 
			INNER JOIN {{iusers}} iusers ON {{orders}}.iuser=iusers.id
			INNER JOIN {{iusers}} authors ON {{orders}}.author=authors.id
			WHERE {{orders}}.paid=1
			ORDER BY cdate
		';
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
		$sheet->setCellValue('B1','Дата');
		$sheet->setCellValue('C1','Пользователь');
		$sheet->setCellValue('D1','Товар');
		$sheet->setCellValue('E1','Цена, руб.');
		$sheet->setCellValue('F1','Автор');
		$sheet->setCellValue('G1','% перечисления');
		$sheet->setCellValue('H1','Сумма перечисления');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		foreach($list as $i=>$item){
			$sheet->setCellValue('A'.($i+2),$item['payid']);
			$sheet->setCellValue('B'.($i+2),date('d.m.Y H:i:s',strtotime($item['cdate'])));
			$sheet->setCellValue('C'.($i+2),$item['iusername']);
			$sheet->setCellValue('D'.($i+2),$item['goodsname']);
			$sheet->setCellValue('E'.($i+2),$item['iuserprice']);
			$sheet->setCellValue('F'.($i+2),$item['authorname']);
			$sheet->setCellValue('G'.($i+2),$item['commision']);
			$sheet->setCellValue('H'.($i+2),$item['iuserprice']-$item['authorprice']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('B'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('D'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('E'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('F'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('G'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('H'.($i+1))->getAlignment()->setWrapText(true);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Лист 1');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
?>