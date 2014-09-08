(function($) {
	$.fn.banner = function(options) {
		var opts = $.extend({}, $.fn.banner.defaults, options);
		return this.each(function() {
			$this 				= $(this);
			var o 				= $.meta ? $.extend({}, opts, $this.data()) : opts;
			var banner_width 	= $this.width();
			//Области
			var $areas			= $this.find('.ca_zone');
			//Пока никаких шагов нет
			var step 			= 0;
			//Изменяем шаг со скоростью o.speed в o.speed секунд
			if(o.steps.length > 0)
			setInterval(function(){
				++step;
				//от последнего перехода к первому
				if(step > o.total_steps) step = 1;
				
				$areas.each(function(){
					var $area 		= $(this);
					var idx			= $area.index();
					//Элемент, в котором расположены изображения для данной области
					var $wrap		= $area.find('.ca_wrap');
					//Текущее выводимое изображение
					var $current	= $wrap.find('img:visible');
					var current_idx = $current.index();
					var config		= o.steps[step-1][idx];
					//Следующая позиция изображения
					var next_idx 	= config[0].to;
					//Используемый эффект
					var effect		= config[1].effect;
					//Если это другое изображение
					if(parseInt(current_idx+1) != next_idx){
						//Следующий элемнт, который будет появляться
						var $next 	= $wrap.find('img:nth-child('+ next_idx +')');
						//Какой эффект использовать?
						switch(effect){
							case 'slideOutRight-slideInRight':
								$area.data('l',$area.css('left'));
								$area.stop().animate({'left': banner_width + 20 + 'px'},400,function(){
									$current.removeClass('ca_shown').hide();
									$next.addClass('ca_shown').show();
									$area.animate({'left': $area.data('l')},400,'easeOutSine');//try 'easeOutBack'
								});
								break;	
							case 'slideOutLeft-slideInLeft':
								$area.data('l',$area.css('left'));
								$area.stop().animate({'left': 0-$area.width()-20 + 'px'},400,function(){
									$current.removeClass('ca_shown').hide();
									$next.addClass('ca_shown').show();
									$area.animate({'left': $area.data('l')},400,'easeOutSine');
								});
								break;
							case 'slideOutTop-slideInTop':
								$area.data('t',$area.css('top'));
								$area.stop().animate({'top': 0-$area.height()-20 + 'px', 'opacity': 0},400,function(){
									$current.removeClass('ca_shown').hide();
									$next.addClass('ca_shown').show();
									$area.animate({'top': $area.data('t'), 'opacity': 1},400,'easeOutSine');
								});
								break;
							case 'slideOutBottom-slideInTop':
								$area.data('t',$area.css('top'));
								
								$area.stop().animate({'top': $area.height()+220 + 'px', 'opacity': 0},400,function(){
									$area.css('top',0-$area.height()-220 + 'px');
									$current.removeClass('ca_shown').hide();
									$next.addClass('ca_shown').show();
									$area.animate({'top': $area.data('t'), 'opacity': 1},400,'easeOutSine');
								});
								break;
							case 'slideOutTop-slideInBottom':
								$area.data('t',$area.css('top'));
								
								$area.stop().animate({'top': 0-$area.height()-220 + 'px'},400,function(){
									$area.css('top',$area.height()+220 + 'px');
									$current.removeClass('ca_shown').hide();
									$next.addClass('ca_shown').show();
									$area.animate({'top': $area.data('t')},400, 'easeOutSine');
								});
								break;
							default:
								$current.removeClass('ca_shown').hide();
								$next.addClass('ca_shown').show();
						}
					}
						
				});
			},o.speed);
		});
	};
	$.fn.banner.defaults = {
		steps   	: [],
		total_steps : 1,
		speed		: 5000	
	};	
})(jQuery);