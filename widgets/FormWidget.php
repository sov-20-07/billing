<?
class FormWidget{
	function run($path){
		$sql='SELECT * FROM {{forms}} WHERE path=\''.$path.'\'';
		$form=DB::getRow($sql);
		$sql='SELECT * FROM {{forms_fields}} WHERE forms='.$form['id'].' ORDER BY num';
		$fields=DB::getAll($sql);
		foreach($fields as $item){
			$item['required']=$item['required']==1?'required':'';
			switch($item['type']){
				case 'string': 		$text.=FormWidget::getString($item); break;
				case 'text': 		$text.=FormWidget::getText($item); break;
				case 'select': 		$text.=FormWidget::getSelect($item); break;
				case 'radio': 		$text.=FormWidget::getRadio($item); break;
				case 'hidden': 		$text.=FormWidget::getString($item); break;
				case '': break;
			}
		}
		
		return str_replace('{content}',$text,View::getWidget('form',$form));
	}
	function getString($row){
		return View::getWidget('fields/string',$row);
	}
	function getText($row){
		return View::getWidget('fields/textarea',$row);
	}
	function getSelect($row){
		$row['options']=explode("\r",$row['options']);
		return View::getWidget('fields/select',$row);
	}
	function getRadio($row){
		return View::getWidget('fields/radio',$row);
	}
}
?>