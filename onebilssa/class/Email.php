<?
include $_SERVER['DOCUMENT_ROOT'].'/'.ONESSA_DIR.'/lib/libmail.php';
class Email extends Mail{
	function Text($text,$layout='email'){
		ob_start();
			include($_SERVER['DOCUMENT_ROOT'].'/views/layout/'.$layout.'.php');
			$layout=ob_get_contents();
		ob_end_clean();
		$this->Body(str_replace('{content}',$text,$layout),"html",strip_tags($text));
		$this->From('robot@'.str_replace('www.','',$_SERVER['HTTP_HOST']));
	}
	function mailTo($emails){
		$data=array();
		if(!is_array($emails)){
			$emails=explode(',',$emails);
		}
		if(count($emails)==1)$emails=$emails[0];
		if(!is_array($emails)){
			$emails=explode(';',$emails);
		}
		if(is_array($emails)){
			foreach($emails as $item){
				$this->To(trim($item));
			}
		}else{
			$this->To(trim($emails));
		}
	}
}
?>