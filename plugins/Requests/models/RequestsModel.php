<?
class Requests{
	public static function getList(){
		$data=array();
		$order=$_GET['sort']==''?'{{requests}}.cdate':$_GET['sort'];
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
		if(isset($_GET['paid']) && $_GET['paid']!=='')$where.=' AND paid='.$_GET['paid'];
		$sql='
			SELECT {{requests}}.*, {{iusers}}.name FROM {{requests}} 
			INNER JOIN {{iusers}} ON {{requests}}.iuser={{iusers}}.id
			WHERE {{iusers}}.author=1 '.$where.' ORDER BY '.$order.'
		';
		//print DB::prefix($sql);
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
	public static function setPaid($id){
		$sql='
			UPDATE {{requests}}
			SET paid=1,
				fdate=NOW(),
				user='.$_SESSION['user']['id'].',
				ip=\''.$_SERVER['REMOTE_ADDR'].'\'
			WHERE id='.$id.'
		';
		DB::exec($sql);
	}
	public static function export(){
		$sql='
			SELECT {{requests}}.*, {{iusers}}.name FROM {{requests}} 
			INNER JOIN {{iusers}} ON {{requests}}.iuser={{iusers}}.id
			WHERE {{iusers}}.author=1 ORDER BY {{requests}}.cdate
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
		$sheet->setCellValue('C1','Автор');
		$sheet->setCellValue('D1','Сумма запроса, руб.');
		$sheet->setCellValue('E1','Статус');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		foreach($list as $i=>$item){
			$sheet->setCellValue('A'.($i+2),$item['request_id']);
			$sheet->setCellValue('B'.($i+2),date('d.m.Y H:i:s',strtotime($item['cdate'])));
			$sheet->setCellValue('C'.($i+2),$item['name']);
			$sheet->setCellValue('D'.($i+2),$item['amount']);
			$sheet->setCellValue('E'.($i+2),$item['paid']==0?'Новая':'Обработана');
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('B'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('D'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('E'.($i+1))->getAlignment()->setWrapText(true);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Лист 1');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	public static function history(){
		$data=array();
		$order=$_GET['sort']==''?'{{requests}}.fdate':$_GET['sort'];
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
		if(isset($_GET['paid']) && $_GET['paid']!=='')$where.=' AND paid='.$_GET['paid'];
		$sql='
			SELECT {{requests}}.*, {{users}}.login FROM {{requests}} 
			LEFT JOIN {{users}} ON {{requests}}.user={{users}}.id
			WHERE paid=1 '.$where.' ORDER BY '.$order.'
		';
		//print DB::prefix($sql);
		$list=DB::getPagi($sql);
		foreach($list as $item){
			if(!$item['login'])$item['login']='unknown';
			$data['list'][]=$item;
		}
		return $data;
	}
	public static function historyExport(){
		$sql='
			SELECT {{requests}}.*, {{users}}.login FROM {{requests}} 
			LEFT JOIN {{users}} ON {{requests}}.user={{users}}.id
			WHERE paid=1 ORDER BY {{requests}}.fdate
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
		$sheet->setCellValue('A1','Дата');
		$sheet->setCellValue('B1','Пользователь');
		$sheet->setCellValue('C1','IP');
		$sheet->setCellValue('D1','Действие пользователя');
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		foreach($list as $i=>$item){
			$sheet->setCellValue('A'.($i+2),date('d.m.Y H:i:s',strtotime($item['fdate'])));
			$sheet->setCellValue('B'.($i+2),$item['login']);
			$sheet->setCellValue('C'.($i+2),$item['ip']);
			$sheet->setCellValue('D'.($i+2),'Одобрение заявки ID '.$item['request_id']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('B'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('C'.($i+1))->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('D'.($i+1))->getAlignment()->setWrapText(true);
		}
		$objPHPExcel->getActiveSheet()->setTitle('Лист 1');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}
?>