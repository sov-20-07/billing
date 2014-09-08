$(document).ready(function(){
	a=document.createElement('a');
	url=baseUrl();
	u=window.location.toString();
	res=u.match(/parent=(.*)/);
	
	a.href=url+"popup/dbfield?parent="+res[1];
	a.id="dbfieldpopup";
	$("#frm")[0].appendChild(a);
	$("select").each(function(){
		
		if (this.name.match(/^data\[field_name\]/)){
			
			$(this).change(function(){
				
				if (this.value=="__new__"){
					o=$("#dbfieldpopup")[0];
					hs.htmlExpand( o, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 380,contentId: 'highslide-html', cacheAjax: false } );
				}
				
			});
			
		}
		
	});
	
});