<div class="pop-up">
    <h3>Обратный звонок</h3>
    <form class="call_me" action='/popup/sendcallback/' method="post" id="callbackform" onsubmit="return checkForm();">
	    <input type="text" class="text required" value="Ваше имя" name="name" style="width: 246px"/><br/>
	    <input type="text" class="text required" value="Номер телефона" name="phone" style="width: 246px"/><br/>
	    <input onclick="_gaq.push(['_trackEvent', 'Callback', 'Send']); yaCounter14316304.reachGoal('Callback_send'); return true;" type="submit" class="send-sm-but">
		<span class="doted" onclick="closeme()">Спасибо, не надо</span>
	</form>
</div>
<script>
	function checkForm(){
		var f=0;
		$('#callbackform .required').each(function(){
			if (jQuery.trim($(this).val())=='' || jQuery.trim($(this).val())=='Ваше имя' || jQuery.trim($(this).val())=='Номер телефона'){
				$(this).css('border','solid 1px red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if (f==1){
			 return false;
		}else return true;
	}
		$(document).ready(function(){
            //Скрипт работы с inputs
            $('input[type=text]').not('.change-input').each(function(){
                var inputVal=$(this).val();
                $(this).attr('valueName',inputVal);
            });

            $(window).unload(function(){
                $('input[type=text]').each(function(){
                    $(this).val( $(this).attr('valueName'));

                });
            });



            $('input[type=text]').not('.change-input').each(function() {
                $(this).focus(function(){
                    $(this).addClass('focus');
                    if(this.value == $(this).attr('valueName')) {
                        this.value = '';

                    }
                });
                $(this).blur(function(){
                    $(this).removeClass('focus');
                    if( this.value == '') {
                        this.value =$(this).attr('valueName');
                    }
                });
            });
        });
</script>