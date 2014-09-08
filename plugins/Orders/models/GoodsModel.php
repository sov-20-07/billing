<?
class Goods{
	public static function getOne($id){
		$fields=Goods::getReserveFieldsByModulePath('catalog');
		$sql='
			SELECT {{catalog}}.*, {{tree}}.* FROM {{catalog}} 
			INNER JOIN {{tree}} ON {{catalog}}.tree={{tree}}.id
			WHERE {{tree}}.id ='.$id.'
		';
		$model=DB::getRow($sql);
		if($model){
			foreach($fields as $key=>$item){
				if(in_array($item['path'],OneSSA::$catalogStandart)){
					$temp[$item['path']]=$model[$item['path']];
				}
			}
			$return=$temp;
			$return['id']=$id;
			if($model['vendor']){
				$sql='SELECT path FROM {{reference}} WHERE id ='.$model['vendor'].'';
				$vendorpath=DB::getOne($sql);
			}
			$return['path']=$parentpath.$vendorpath.'/'.$id.'/';
			$return['tree']=$id;
			$return['name']=$model['name'];
			$return['parent']=$model['parent'];
			$return['price']=$model['price'];
			$return['rating']=$model['rating'];
			$return['vendorname']=Funcs::$referenceId['vendor'][$return['vendor']]['name'];
			$fields=Goods::getFieldsByTree($id);
			$return['color']=Funcs::$referenceId['color'][$fields['color']]['name'];
			$return['pics']=$fields['gal']['image'];
			$return['files']=$fields['files_gal']['application'];
			unset($fields['files_gal']);
			unset($fields['gal']);
			$return['additional']=$fields;
			return $return;
		}
	}
	public function getReserveFieldsByModulePath($path){
		$data=array();
		$return=array();
		$sql='
			SELECT {{fields}}.* FROM {{modules}}
			INNER JOIN {{fields}} ON {{fields}}.module={{modules}}.id
			WHERE {{modules}}.path=\''.$path.'\' AND {{fields}}.innerf=1
			ORDER BY {{fields}}.num
		';
		$data=DB::getAll($sql);
		return $data;
	}
	public function getFieldsByTree($id,$option=''){
		$gal=0;
		$data=array();
		$return=array();
		$sql='SELECT * FROM {{data}} WHERE tree='.$id.' ORDER BY num';
		$additional=DB::getAll($sql);
		foreach ($additional as $item){
			if($item['type']=='editor' || $item['type']=='text'){
				$data[$item['path']]=$item['value_text'];
			}elseif($item['type']=='string'){
				$data[$item['path']]=$item['value_string'];
			}elseif($item['type']=='integer'){
				$data[$item['path']]=$item['value_int'];
			}elseif($item['type']=='radio'){
				//$data[$item['path']]=$item['value_int'];
				$data[$item['path']]=$item['value_int']==1?'Да':'Нет';
			}elseif($item['type']=='float'){
				$data[$item['path']]=$item['value_float'];
			}elseif($item['type']=='select'){
				$data[$item['path']]=$item['value_text'];
			}elseif($item['type']=='gallery'){
				$sql='
					SELECT id2 FROM {{relations}}
					WHERE modul1=\'data\' AND modul2=\'files\' AND id1='.$item['id'].'
				';
				$fileId=DB::getAll($sql,'id2');
				if(count($fileId)>0){
					$sql='
						SELECT * FROM {{files}}
						WHERE id IN ('.implode(',',$fileId).')
						ORDER BY num
					';
					$temp=DB::getAll($sql);
					foreach($temp as $file){
						$file['file']=Funcs::getFileInfo($file['path']);
						$data['gal'][$file['mime']][]=$file;
					}
				}
			}
		}
		return $data;
	}
	public function getSizes($id){
		$data=array();
		$sql='
			SELECT id, name FROM {{tree}} WHERE parent='.$id.'
			ORDER BY num
		';
		$refsizes=DB::getAll($sql);
		foreach($refsizes as $item){
			$fields=Goods::getFieldsByTree($item['id']);
			$fields['name']=$item['name'];
			$fields['id']=$item['id'];
			$data[]=$fields;
		}
		return $data;
	}
	public static function getSize($id){
		$sql='SELECT id, name FROM {{tree}} WHERE id='.$id.'';
		$item=DB::getRow($sql);
		$fields=Goods::getFieldsByTree($item['id']);
		$fields['name']=$item['name'];
		$fields['id']=$item['id'];
		return $fields;
	}
	public static function getSizeByName($id,$name){
		if($name!=''){
			$sql='SELECT id, name FROM {{tree}} WHERE parent='.$id.' AND name=\''.$name.'\' AND visible=1';
			$item=DB::getRow($sql);
			$fields=Goods::getFieldsByTree($item['id']);
			$fields['name']=$item['name'];
			$fields['id']=$item['id'];
			return $fields;
		}
	}
	public static function getPrice($goods,$sizeId){
		$size=Goods::getSize($sizeId);
		$price=$size['baseRetailPriceRUR'];
		return $price;
	}
}
?>