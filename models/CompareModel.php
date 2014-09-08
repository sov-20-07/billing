<?
class Compare{
	public static function setCompare($id){
		$parNew=array_reverse(Tree::getParents($id));
		if(count($_SESSION['compare']>0)){
			$parOld=array_reverse(Tree::getParents(end($_SESSION['compare'])));
		}else{
			$parOld=array();
		}
		if($parNew[3]!=$parOld[3]){
			$_SESSION['compare']=array();
		}
		$_SESSION['compare'][$id]=$id;
		return count($_SESSION['compare']);
	}
	public static function setCompareList($ids){
		foreach($ids as $id){
			$_SESSION['compare'][$id]=$id;
		}
		return count($_SESSION['compare']);
	}
	public static function delCompare($id){
		unset($_SESSION['compare'][$id]);
		return count($_SESSION['compare']);
	}
	public static function getCompare(){
		if(count($_SESSION['compare'])>0){
			$return=array();
			$data=array();
			$i=0;
			foreach($_SESSION['compare'] as $id){
				if($i<3){
					$data[]=Catalog::getOne($id);
				}
				$i++;
			}
			$additional=array();
			if(count($data)>0){
				foreach($data as $item){	
					if(is_array($item['additional'])){	
						foreach($item['additional'] as $title=>$values){
							if(is_array($values)){
								foreach($values as $k=>$v){
									$additional[$title][$k]='';
								}
							}
						}
					}
					//$additional
				}
				foreach($data as $i=>$item){
					foreach($additional as $title=>$values){
						foreach($values as $k=>$v){
							$data[$i]['additional'][$title][$k]=$item['additional'][$title][$k];
						}
					}
				}
				$additional=array();
				if(is_array($data[0]['additional'])){	
					foreach($data[0]['additional'] as $title=>$values){
						if(is_array($values)){	
							foreach($values as $k=>$v){
								$tn='';
								foreach($data as $key=>$item){
									if($tn!=$item['additional'][$title][$k] && $item['additional'][$title][$k]!='' && $tn!=''){
										$additional[$title][$k]=1;
										$n=1;						
									}
									$tn=$item['additional'][$title][$k];
								}
							}
						}else{
							$tn='';
							foreach($data as $key=>$item){
								if($tn!=$item['additional'][$title] && $item['additional'][$title]!='' && $tn!=''){
									$additional[$title]=1;
									$n=1;						
								}
								$tn=$item['additional'][$title];
							}
						}
					}
				}
			}
			return array('items'=>$data,'additional'=>$additional);
		}else{
			return array();	
		}		
	}
}
?>