<?
class OptionsWidget{
	public static $fields=array('float'=>'value_float','string'=>'value_string','integer'=>'value_int','text'=>'value_text','fnumber'=>'value_float','fstring'=>'value_string','fcheckbox'=>'value_int');
	function run($data){
		$list=array();
		foreach(Funcs::$referenceId['options'] as $key=>$item){
			if(is_numeric($item['value'])){
				$list[$item['path']]=$data[$item['path']];
				$list[$item['path']]['act']=$item['value'];
				$list[$item['path']]['path']=$item['path'];
			}else{
				$value=explode("\n",$item['value']);
				if((in_array(end(Funcs::$uri),explode(';',$value[2])) && $value[2]!='') || $value[2]==''){
					if($item['path']=='select' || $item['path']=='checkbox' || $item['path']=='radio'){
						$temp=OptionsWidget::getValuesSelect($item['name']);
					}elseif($item['path']=='number'){
						$temp=OptionsWidget::getValuesNumber($item['name']);
					}elseif($item['path']=='link'){
						$temp=OptionsWidget::getValuesLink($value);
					}
					if(count($temp)>0){
						$list[$item['value']]['list']=$temp;
						$list[$item['value']]['name']=trim($value[0]);
						$list[$item['value']]['path']=$item['path'];
						$list[$item['value']]['title']=trim($value[1])==''?$item['name']:$value[1];
					}
				}
			}
		}
		$tree=Tree::getTreeByUrl();
		foreach(Fields::getFeaturesList($tree['id']) as $items){
			foreach($items['list'] as $item){
				if($item['filtertype']=='checkbox' || $item['filtertype']=='checkboxgroup' || $item['filtertype']=='select'){
					$temp=OptionsWidget::getValuesSelect($item['path']);
				}elseif($item['filtertype']=='number'){
					$temp=OptionsWidget::getValuesNumber($item['path']);
				}
				$list[$item['path']]['list']=$temp;
				$list[$item['path']]['name']=$item['path'];
				$list[$item['path']]['path']=$item['filtertype'];
				$list[$item['path']]['title']=$item['name'];
				$list[$item['path']]['comment']=$item['comment'];
			}
		}
		View::widget('options',array('list'=>$list));
	}
	public static function getValuesSelect($path){
		$data=array();
		$tree=Tree::getTreeByUrl();
		$ids[]=$tree['id'];
		$ids=array_merge($ids,Tree::getChilds($tree['id']));
		$sql='
			SELECT DISTINCT type, value_int, value_float, value_string, value_text FROM {{data}}
			WHERE path=\''.$path.'\' AND tree IN ('.implode(',',$ids).')
		';
		$list=DB::getAll($sql);
		foreach($list as $item){
			$data[]=$item[Fields::$fieldsName[$item['type']]];
		}
		return $data;
	}
	public static function getValuesNumber($path){
		$data=array();
		$tree=Tree::getTreeByUrl();
		$ids[]=$tree['id'];
		$ids=array_merge($ids,Tree::getChilds($tree['id']));
		$sql='
			SELECT DISTINCT type FROM {{data}}
			WHERE path=\''.$path.'\' AND tree IN ('.implode(',',$ids).')
		';
		$type=DB::getOne($sql);
		if($type){
			$sql='
				SELECT MAX('.Fields::$fieldsName[$type].') AS maxv, MIN('.Fields::$fieldsName[$type].') AS minv FROM {{data}}
				WHERE path=\''.$path.'\' AND tree IN ('.implode(',',$ids).')
			';
			$data=DB::getRow($sql);
			$data['type']=substr($type,0,1);
		}
		if($data['maxv']>0){
			return $data;
		}else{
			return array();
		}
	}
}
?>