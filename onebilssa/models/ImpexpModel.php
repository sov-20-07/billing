<?
require_once $_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/lib/Excel/PHPExcel.php';
class Impexp{
	public static $treeFields=array('id','parent','name','udate','seo_title','seo_keywords','seo_description','path');
	public static $treeFieldsRus=array('id','parent','Имя','Дата','SEO Заголовок','SEO Ключ. слова','SEO Описание','Путь');
	public static $treeFieldsRusConvert=array('id'=>'id','parent'=>'parent','Имя'=>'name','Дата'=>'udate','SEO Заголовок'=>'seo_title','SEO Ключ. слова'=>'seo_keywords','SEO Описание'=>'seo_description','Путь'=>'path');
	public static $usingFieldsByType=array('string','integer','radio','float','select'/*,'editor'*/);
	public static function export(){
		$list=Impexp::getList();
		/*foreach($list[0] as $i=>$item){
			print Impexp::dfe($i).'1,'.$item.'<br>';
		}
		//for($i=65;$i<=90;$i++)print chr($i);
		print '<pre>';print_r($list);die;*/
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
		foreach($list[0] as $i=>$item){
			$sheet->setCellValue(Impexp::dfe($i).'1',$item);
			$sheet->getColumnDimension(Impexp::dfe($i))->setAutoSize(true);
		}
		foreach($list as $i=>$items){
			if($i!=0){
				foreach($items as $ii=>$item){
					$sheet->setCellValue(Impexp::dfe($ii).($i+1),$item);
					$objPHPExcel->getActiveSheet()->getStyle(Impexp::dfe($ii).($i+1))->getAlignment()->setWrapText(true);
				}
			}
		}
		$objPHPExcel->getActiveSheet()->setTitle('Лист 1');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	public static function getList(){
		$data=array();
		$row=0;
		$is_catalog=false;
		foreach(Impexp::$treeFieldsRus as $item){
			$data[$row][]=$item;
		}
		$sql='SELECT * FROM {{tree}} WHERE parent='.Funcs::$uri[3].' ORDER BY num';
		$list=DB::getAll($sql);
		$module=Module::getModuleByTree($list[0]['id']);
		$moduleFields=Module::getFieldList($module['id'],'all');
		foreach($moduleFields as $item){
			if(in_array($item['type'],Impexp::$usingFieldsByType)){
				$data[$row][]=$item['name'];
			}
		}
		$row++;
		$sql='SELECT id FROM {{catalog}} WHERE tree='.$list[0]['id'];
		if(DB::getOne($sql)){$is_catalog=true;}
		foreach($list as $item){
			foreach(Impexp::$treeFields as $field){
				$data[$row][]=$item[$field];
			}
			$fields=Impexp::getFieldsByTree($item['id']);
			if($is_catalog){
				$sql='SELECT * FROM {{catalog}} WHERE tree='.$item['id'];
				$item=DB::getRow($sql);
				foreach($moduleFields as $field){
					if(in_array($field['type'],Impexp::$usingFieldsByType)){
						if(in_array($field['path'],OneSSA::$catalogStandart)){
							$data[$row][]=$item[$field['path']];
						}else{
							$data[$row][]=$fields[$field['path']];
						}
					}
				}
			}else{
				foreach($moduleFields as $field){
					if(in_array($field['type'],Impexp::$usingFieldsByType)){
						$data[$row][]=$fields[$field['path']];
					}
				}
			}
			$row++;
		}
		return $data;
	}
	public static function import(){
		$data=array();
		if($_FILES['upload']['tmp_name']){
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['upload']['tmp_name']);
			$sheet=$objPHPExcel->setActiveSheetIndex(0);
			$cols=0;
			while($sheet->getCell(Impexp::dfe($cols).'1')->getValue()!=NULL){
				//$data[0][]=$sheet->getCell(Impexp::dfe($i).'1')->getValue();
				$cols++;
			}
			$ii=0;
			while($sheet->getCell('A'.($ii+1))->getValue()!=NULL){
				for($i=0;$i<$cols;$i++){
					$data[$ii][$i]=$sheet->getCell(Impexp::dfe($i).($ii+1))->getValue();
				}
				$ii++;
			}
			Impexp::setList($data);
			/*print '<pre>';
			print_r($data);
			die;*/
		}
	}
	public static function setList($list){
		$row = 1;
		$is_catalog=false;
		$module='';
		$moduleFieldsAll='';
		$moduleFields='';
		foreach($list as $data){
	    	if($row==1){
	    		$getfields=$data;
	    	}else{
	    		if($row==2){
		    		$fields=Impexp::getFieldsByTree($data[0]);
			    	$sql='SELECT id FROM {{catalog}} WHERE tree='.$data[0];
					if(DB::getOne($sql)){$is_catalog=true;}
    				$module=Module::getModuleByTree($data[0]);
					$moduleFieldsAll=Module::getFieldList($module['id'],'all');
	    			foreach($moduleFieldsAll as $item){
						$moduleFields[$item['name']]=$item;
					}
		    	}
		    	$n=0;
		    	foreach($getfields as $item){
		    		if($data[0]>0){
			    		if(in_array($item,Impexp::$treeFieldsRus)){
			    			if($item!='id'){
				    			if($item=='Дата'){
				    				$sql='UPDATE {{tree}} SET '.Impexp::$treeFieldsRusConvert[$item].'=\''.date('Y-m-d H:i:s',strtotime($data[$n])).'\' WHERE id='.$data[0].'';
				    			}else{
				    				$sql='UPDATE {{tree}} SET '.Impexp::$treeFieldsRusConvert[$item].'=\''.$data[$n].'\' WHERE id='.$data[0].'';
				    			}
				    			DB::exec($sql);
			    			}
			    		}else{
			    			if($is_catalog){
			    				if(in_array($moduleFields[$item]['path'],OneSSA::$catalogStandart)){
			    					$sql='UPDATE {{catalog}} SET '.$moduleFields[$item]['path'].'=\''.$data[$n].'\' WHERE tree='.$data[0].'';
			    					DB::exec($sql);
			    				}else{
			    					$sql='UPDATE {{data}} SET '.Impexp::getFei($moduleFields[$item]['type']).'=\''.$data[$n].'\' WHERE tree='.$data[0].' AND path=\''.$moduleFields[$item]['path'].'\'';
			    					DB::exec($sql);
			    				}
			    			}else{
			    				$sql='UPDATE {{data}} SET '.Impexp::getFei($moduleFields[$item]['type']).'=\''.$data[$n].'\' WHERE tree='.$data[0].' AND path=\''.$moduleFields[$item]['path'].'\'';
			    				DB::exec($sql);
			    			}
			    		}
			    		//print DB::prefix($sql);
				    	//print '<br>';
		    		}
		    		$n++;
		    	}
	    	}
	        $row++;
	    }
	}
	public static function getFieldsByTree($id){
		$gal=0;
		$data=array();
		$return=array();
		$sql='SELECT * FROM {{data}} WHERE tree='.$id.' ORDER BY num';
		$additional=DB::getAll($sql);
		foreach ($additional as $item){
			if($item['type']=='string'){
				$data[$item['path']]=$item['value_string'];
			}elseif($item['type']=='integer'){
				$data[$item['path']]=$item['value_int'];
			}elseif($item['type']=='radio'){
				$data[$item['path']]=$item['value_int'];
			}elseif($item['type']=='float'){
				$data[$item['path']]=$item['value_float'];
			}elseif($item['type']=='select' || $item['type']=='editor' || $item['type']=='text'){
				$data[$item['path']]=$item['value_text'];
			}
		}
		return $data;
	}
	public static function getFei($type){
		if($type=='string'){
			return 'value_string';
		}elseif($type=='integer' || $type=='radio'){
			return 'value_int';
		}elseif($type=='float'){
			return 'value_float';
		}elseif($type=='select'){
			return 'value_text';
		}
		
	}
	public static function dfe($num){
		$data='';
		if(floor($num/26)==0){
			$data.=chr($num+65);
		}elseif(floor($num/26/26)==0){
			$data.=chr(floor($num/26-1)%26+65).chr($num%26+65);
		}elseif(floor($num/26/26/26)==0){
			$data.=chr(floor($num/26/26-1)%26+65).chr(floor($num/26-1)%26+65).chr($num%26+65);
		}
		return $data;
	}
}
?>