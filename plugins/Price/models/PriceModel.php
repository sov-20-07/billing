<?
class Price{
	public static $percent=20;
	public static $c=array(
		0=>'value',
		1=>'name',
		2=>'size',
		3=>'purchasePriceUSD',
		5=>'basicDealerPriceUSD',
		7=>'baseRetailPriceUSD',
		11=>'numberWarehouse',
		16=>'numberRetailSales',
		20=>'weight',
		21=>'length',
		22=>'width',
		23=>'height',
	);
	function recalculatePrice(){
		$sql='
			SELECT *, {{tree}}.parent FROM {{data}} 
			INNER JOIN {{tree}} ON {{data}}.tree={{tree}}.id
			WHERE {{data}}.path=\'baseRetailPriceUSD\'
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$sql='
				UPDATE {{data}} SET value_float='.(ceil($item['value_float']*Funcs::$conf['currency']['USD']/10)*10).' 
				WHERE path=\'baseRetailPriceRUR\' AND tree='.$item['tree'].'
			';
			DB::exec($sql);
		}
	}
	public static function import(){
		$data=array();
		if($_FILES['upload']['tmp_name']){
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['upload']['tmp_name']);
			$sheet=$objPHPExcel->setActiveSheetIndex(0);
			$cols=1;
			while($sheet->getCell(Impexp::dfe($cols).'2')->getValue()!=NULL){
				//$data[0][]=$sheet->getCell(Impexp::dfe($i).'1')->getValue();
				$cols++;
			}
			$ii=3;
			while($sheet->getCell('A'.($ii+1))->getValue()!=NULL){
				$partname=$sheet->getCell('B'.($ii+1))->getValue();
				$size=$sheet->getCell('C'.($ii+1))->getValue();
				if($size=='')$size='universal';
				foreach(Price::$c as $i=>$item){
					if($item!='name' && $item!='size'){
						if($size=='universal'){
							$data[$partname]['universal'][$item]=$sheet->getCell(Impexp::dfe($i).($ii+1))->getValue();
							$data[$partname]['nosize'][$item]=$sheet->getCell(Impexp::dfe($i).($ii+1))->getValue();
						}else{
							$data[$partname][$size][$item]=$sheet->getCell(Impexp::dfe($i).($ii+1))->getValue();
						}
					}
				}
				$ii++;
			}
			Price::setList($data);
			//print '<pre>';print_r($data);die;
		}
	}
	public static function setList($list){
		$sql='UPDATE {{catalog}} SET available=0';
		DB::exec($sql);
		foreach($list as $partname=>$items){
			$sql='SELECT tree FROM {{catalog}} WHERE partname="'.$partname.'"';
			$parent=DB::getOne($sql);
			if($parent){
				$available=0;
				foreach($items as $size=>$item){
					$sql='SELECT id FROM {{tree}} WHERE parent='.$parent.' AND name="'.$size.'"';
					$tree=DB::getOne($sql);
					if(!$tree){
						$sql='SELECT id FROM {{tree}} WHERE parent='.$parent.' AND path="'.$size.'"';
						$tree=DB::getOne($sql);
					}
					foreach($item as $k=>$f){
						$sql='SELECT type FROM {{fields}} WHERE module=6 AND path="'.$k.'"';
						$r=DB::getOne($sql);
						$row=array(
							'field'=>Fields::$types[$r]['type'],
							'path'=>$k,
							'value'=>$f,
						);
						Price::updateField($tree,$row);
						if($k=='numberRetailSales' && $f>0)$available=1;
					}
				}
				$sql='UPDATE {{catalog}} SET available='.$available.' WHERE tree='.$parent;
				DB::exec($sql);
			}
		}
	}
	public static function updateField($tree,$item){
		if($tree){
			$sql='
				UPDATE {{data}}
				SET	'.$item['field'].'=\''.$item['value'].'\'
				WHERE tree='.$tree.' AND path=\''.$item['path'].'\'
			';
			//print DB::prefix($sql).'<br>';
			DB::exec($sql);
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