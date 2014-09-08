<?
class FeaturesWidget{
	function run($row){
		if($_GET['tree']!='new' && $row['type']!='group'){
			$row['select']=FeaturesWidget::getValues($row);
			$row['value']=FeaturesWidget::getValue($row);
			View::widget('features/'.$row['type'],$row);
		}
	}
	function set($row){
		View::widget('features/edit',$row);
	}
	function getValues($row){
		if($_GET['id']){
			$sql='SELECT parent FROM {{tree}} WHERE id='.$_GET['id'];
			$parent=DB::getOne($sql);
			$sql='
				SELECT DISTINCT {{data}}.'.Fields::$features[$row['type']]['type'].' FROM {{data}}
				INNER JOIN {{tree}}	ON {{data}}.tree={{tree}}.id
				WHERE {{tree}}.parent='.$parent.'
					AND {{data}}.field=\''.$row['id'].'\'
				ORDER BY {{data}}.'.Fields::$features[$row['type']]['type'].'
			';
			return DB::getAll($sql,Fields::$features[$row['type']]['type']);
		}else{
			return array();
		}
	}
	function getValue($row){
		if($_GET['id']){
			$sql='
				SELECT '.Fields::$features[$row['type']]['type'].' FROM {{data}}
				WHERE tree='.$_GET['id'].' AND field='.$row['id'].'
			';
			$value=DB::getOne($sql);
			if($value){
				return $value;
			}else{
				if($row['type']=='fstring'){
					return '';
				}else{
					return 0;
				}
			}
		}else{
			return '';
		}
	}
}
?>