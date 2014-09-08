//DOC READY
var scrolls;
$(document).ready( function(){	
	
	var module = {
		sidebar: $(".jsSidebar"),
		sidebarToggle: $(".jsSidebarToggle"),
		scrollContainer: $(".jsScrollContainer"),
		scroll: $(".jsScroll"),
		scrollStatic: $(".jsScrollStatic"),
		scrollInner: $(".jsScrollInner"),
		cell: $(".ltCell"),
		tableCaption: $(".ltTableCap")
	};
	//scroll options
	var scrollOptions = {
		horizontalDragMinWidth: 30,
		verticalDragMinHeight: 30,
		horizontalGutter: 10,
		verticalGutter: 10,
		mouseWheelSpeed: 30
	}
	
	//catalog padding
	catalogPadding(10);
		
	//TIMEPICKER
	( function(){
		var time_widget = $(".widget_time");
		var timepicker = time_widget.find(".input_text");
		
		if( time_widget.length ){
			timepicker.datetimepicker({ dateFormat: "dd.mm.yy" });
			time_widget.on( "click", function(){ $(this).find(".input_text").focus(); });
			$(window).on( "resize", function(){ timepicker.datepicker( "hide" ); });
		};
	})();
	
	//SCROLLPANE
	( function(){
		
		//init scroll
		module.scroll.jScrollPane( scrollOptions );
		module.scroll.on( "jsp-scroll-y", function(e, sx){
			$(this).find(".jsFixedY").css("top", sx+"px");
		});
			
		module.scroll.on( "jsp-scroll-x", function(e, sx){
			$(this).find(".jsFixedX").css("left", sx+"px");
		});
				
		//horizontal mousewheel scroll fix
		module.scroll.on( "mousewheel", function(event, delta, deltaX, deltaY) {
            var api = $(this).data("jsp");
			api.scrollByX(delta*-scrollOptions.mouseWheelSpeed);
            return false;
        });
        module.scroll.on( "jsp-scroll-x", function(e, sx){
			$(this).find(".jsFixedX").css("left", sx+"px");
		});
		
	})();
	
	//WINDOW RESIZE
	( function(){
		//scroll define
		var scrollContainer = module.scrollContainer;
		var cell = module.cell;
		var scroll = [];
		var scrollAPI = [];
		var tableCapHeight = module.tableCaption.height();
		for( var i = 0; i < scrollContainer.length; i++ ){
			scroll[i] = $(scrollContainer[i]).find( module.scroll );
			scrollAPI[i] = scroll[i].data("jsp");
		}
		
		//height fix
		var sizeParent = $(".sizeParent");
		var sizeChild = [];
		for( var i = 0; i < sizeParent.length; i++ ){
			sizeChild[i] = $(sizeParent[i]).find(".sizeChild");
		}
		
		//resizing window
		$(window).on({
			resize: function(){ resizeContent(); },
			load: function(){ resizeContent();	}
		});				
		
		//resizing container function
		resizeContainer = function(selector){
			var	$this = $(selector),
					$scroll = $this.find(".jsScroll"),
					api = $scroll.data("jsp")
			;
			api.reinitialise();
		}
		
		//resizing window function
		resizeContent = function(){		
			//height fix
			for( var i = 0; i < sizeParent.length; i++ ){
				sizeChild[i].height( $(sizeParent[i]).height() );
				sizeChild[i].width( $(sizeParent[i]).width() );
			}
			
			//scroll reinitialize
			for( var i = 0; i < scrollContainer.length; i++ ){
				
				//dimensions of scroll container
				var w = $(scrollContainer[i]).width();
				var h = $(scrollContainer[i]).height();
				
				$(scroll[i]).height( h ); $(scroll[i]).width( w );
				$(scroll[i]).children(".jspContainer").width( w );
				
				//init scroll
				scrollAPI[i].reinitialise();

				//add/remove classes for scroll overflow
				if( scrollAPI[i].getIsScrollableH() ){
					$(scroll[i]).addClass("hasHorizontalScroll");
				}else{
					$(scroll[i])
						.removeClass("hasHorizontalScroll")
				};
				if( scrollAPI[i].getIsScrollableV() ){
					$(scroll[i]).addClass("hasVerticalScroll");
				}else{
					$(scroll[i])
						.removeClass("hasVerticalScroll")
						.find(".jspPane").css({ left: "0" });
					$(scroll[i]).find(".sections_table_caption-holder").css("top", "0");
				}
			}	
		};
		//DRAG, CKEDITOR
		( function(){
			$(".jsMoveContainerLI").dragsort({ dragSelector: ".jsMoveDrag", dragBetween: false, dragEnd: function(){reinitEditor();defineSort('jsMoveContainerLI');},placeHolderTemplate: "<li style='height: 10px; background: #ccc;'></li>" }); 
			$(".jsMoveContainerTR").dragsort({ dragSelector: ".jsMoveDrag", dragBetween: false, dragEnd: function(){defineSort('jsMoveContainerTR');}, placeHolderTemplate: "<tr></tr>" });		
			function reinitEditor(){
				/*for(var instanceName in CKEDITOR.instances){
					console.log(instanceName);
					var editor = CKEDITOR.instances[instanceName]				
					editor.destroy(true);
					initEditor();
				}		*/		
			}
			
		})();
		
		//add CSS3 transitionEnd event
		addTransitionEnd = function( el, func ){
			if(!$.browser.msie || $.browser.version > 9){
				el.on('transitionend', func );
				el.on('webkitTransitionEnd', func );
				el.on('mozTransitionEnd', func );
				el.on('oTransitionEnd', func );
				el.on('msTransitionEnd', func );
			}else{ module.sidebarToggle.on("click", function(){ var t = setTimeout( func, 0 ); } ); }
		}
		addTransitionEnd( module.sidebar, resizeContent );
		
		//CATALOG MENU
		( function(){		
			$(".catalog-menu_toggle").on( "click", function(e){
				var item = $(this).closest(".jsMenuItem");
				
				item.children(".catalog-menu").stop(true, true).slideToggle(400, "easeInOutQuart", function(){
					resizeContent();
					//$(this).find(".jsOpened .catalog-menu_toggle").click();
				});
				
				item.toggleClass("jsClosed");
				item.toggleClass("jsOpened");
				//$(".jsMenuItem").removeClass("jsCurrent");
				if(!item.find(".jsCurrent")){
					if( item.hasClass("jsOpened") ){
						item.addClass("jsCurrent");
					}else{
						item.closest(".jsMenuItem.jsOpened").addClass("jsCurrent");
					}
				}
				
				e.stopPropagation();
				return false;
			});
		})();
				
		//jsTABS
		( function(){
			var container = $(".jsTabs");
			var links = $(".jsTabsLink");
			var tabs = $(".jsTabsTab");
			var content = $(".jsTabsContent");
			var current = $(".jsTabsTabCurrent");
			tabs.hide(); current.show();
			content.height(current.height());
			
			links.on( "click", function(){
				if( !$(this).hasClass("jsTabsLinkCurrent") ){
					links.removeClass("jsTabsLinkCurrent");
					var curLink = $(this);
					curLink.addClass("jsTabsLinkCurrent");
					tabs.fadeOut(400);
					current = $(tabs).eq(curLink.index());
					current.fadeIn(400);
					content.animate({height: current.height()}, 400, "easeInOutSine", function(){
						resizeContent();
					});
				}else{
					links.removeClass("jsTabsLinkCurrent");
					tabs.fadeOut(400);
					content.animate({height: 0}, 400, "easeInOutSine", function(){
						resizeContent();
					});
				}
			});
		})();
	})();
	
	//SLIDE INFO
	( function(){
		$(".jsSlideInfoToggle").on( "click", function(){
			var toggle = $(this);
			toggle.closest(".jsSlideInfoContainer")
				.find(".jsSlideInfoContent")
					.slideToggle(400, 'easeInOutQuart', function(){ resizeContent(); });
		});
	})();	
	
	//SIDEBAR TOGGLE
	( function(){
		var sidebar = module.sidebar;
		var toggle = module.sidebarToggle;
		
		toggle.on( "click", function(){
			sidebar.toggleClass("jsSidebarOpened");
			$(".sizeChild").animate({opacity: "0"}, 150).delay(250).animate({opacity: "1"}, 150);
		});
	})();
	
	//PLACEHOLDER FIX
	(function(){
		$('input[placeholder]').placeholder(); 
		
		var placeholder = "";
		$("input[placeholder]").focus( function(){
			placeholder = $(this).attr('placeholder');
			$(this).attr('placeholder', '');
		});
		
		$("input[placeholder]").blur( function(){
			$(this).attr('placeholder', placeholder);
		});
	})();
	
	//INPUT DISABLED
	(function(){
		$(".input_text.disabled, .disabled .input_text").focus( function(){ $(this).blur(); });
	})();
	
	//LINK CONTAINER (this block, while clicking on it, follows the link inside itself)
	(function(){
		$(".linkContainer a").on("click", function(e){
			e.preventDefault();
		});
		$(".linkContainer").on("click", function(){
			var link = $(this).find("a");
			if( link.length ){
				var href = link.attr("href");
				if( link.attr("target") == "_blank" ) window.open(href);
				else window.location = href;
			}
		});
		
		$(".linkContainer").hover(
			function(){ $(this).find("a, img").addClass("hoverLink"); },
			function(){ $(this).find("a, img").removeClass("hoverLink"); }
		);
	})();
	
	//CUSEL
	( function(){
		cuSel({
			changedEl: ".jsSelectStyled",
			visRows: 5,
			scrollArrows: true
		});
		
		//DISABLED OPTION FIX
		$(".cusel span[disabled]").on( "click", function(){ return false; });
		//$(".cusel span").on( "click", function(){ $(this).removeClass("cuselActive"); $(this).closest(".cusel").click(); })
	})();
	
	
	//POPUPS
	var createPopup = function( event, popup, toggle, type, offX, offY ){
		var popup = $(popup);
		var toggle = $(toggle);
		
		toggle.on( event, function(){
			var w = popup.outerWidth();
			var h = popup.outerHeight();
			var left = $(this).offset().left;
			var top = $(this).offset().top;
			var tw = $(this).width();
			
			switch(type){
				case "sectionSettings":
					popup.attr("ids", $(this).data("popup-id"));
					h = popup.outerHeight();
					if( left+w*1.3 < $(window).width() ){
						popup.css({ left: left+tw+offX, top: top-(h/2)+offY });
					}else{
						popup.addClass("popup_toleft").css({ left: left-w-offX, top: top-(h/2)+offY });
					};
					
					popup.stop(true, true).fadeIn(400);
					$(this).closest(".sections_table_row").addClass("active");
				break;
				case "sectionsSettings":
					popup.css({ left: left-popup.width()+43+offX, top: top+19+offY }).stop(true, true).fadeIn(400);
					resizeContent();
					var h2 = popup.find(".jspPane").outerHeight() + popup.find(".popup_sections-settings_header").outerHeight();
					popup.css({ maxHeight: h2+"px"});
				break;
				case "tooltip":
					popup.find(".jsTooltipContent").text( $(this).data("tooltip") );
					popup.css({ left: left-popup.width()/2+offX+tw/2, top: top+36+offY }).stop(true, true).fadeIn(400);
				break;
				case "preview":					
					var img = new Image();
					img.src = $(this).data('src');
					
					if($.browser.msie && $.browser.version<9){ imgOnLoad(); }
					else{ img.onload = function(){ imgOnLoad(); } }
					
					function imgOnLoad(){
						popup.html(img);
						h = popup.outerHeight();
						w = popup.outerWidth();
						popup.css({ left: left-w-offX, top: top-(h/2)+offY });						
						popup.stop(true, true).fadeIn(400);
					}
					
					toggle.one( "mouseleave", function(){
						popup.stop(true, true).fadeOut(400);
					});
				break;
			};
		});
		
		popup.on( "mouseleave", function(){
			popup
				.stop(true, true)
				.fadeOut(400)
				.removeClass("popup_toleft");
			$(".sections_table_row").removeClass("active");
		});
	};
	createPopup( "mouseenter", ".jsSectionSettingsPopup", ".jsHeaderSettingsToggle", "sectionSettings", 14, 10 ); //настройки в заголовке страницы
	createPopup( "mouseenter", ".jsSectionSettingsPopup", ".jsSectionSettingsToggle", "sectionSettings", 14, 7 ); //настройки в таблице
	createPopup( "mouseenter", ".jsSectionsSettingsPopup", ".jsSectionsSettingsToggle", "sectionsSettings", 0, 0 ); //меню настроек таблицы (выводимые столбцы)
	createPopup( "mouseenter", ".jsTooltipPopup", ".jsTooltipToggle", "tooltip", -14, 0 ); //всплывающие подсказки
	createPopup( "mouseenter", ".jsPreviewPopup", ".jsPreviewToggle", "preview", 24, 10 ); //всплывающие изображения
	
	//SELECT ALL & CLEAR ALL BUTTONS
	( function(){
		var container = $(".jsSectionsSettingsPopup");
		var select = container.find(".jsSelectAll");
		var clear = container.find(".jsClearAll");
		
		select.on( "click", function(){
			container
				.find(".icheckbox, .iradio").addClass("checked")
				.find("input").attr("checked", true);
		});
		
		clear.on( "click", function(){
			container
				.find(".icheckbox, .iradio").removeClass("checked")
				.find("input").removeAttr("checked");
		});
	})();
	
	//SITES MENU
	
	var menu = $(".jsSitesMenu");
	var menuList = menu.find(".jsSitesMenuList");
	var menuPane = menu.find(".jsSitesMenuPane");
	var menuItems = menu.find(".jsSitesMenuItem");
	var menuScroll = menu.find(".jsScrollStatic");
	var menuCurrent = $(".jsSitesMenuCurrent");
	( function(){
		
		function resizeScroll(){
			//var api = module.scrollStatic.data('jsp');
			//if( api ) api.reinitialise();
			menuScroll.css({maxHeight: menuPane.height()});
			var h = menuScroll.height(); var wh = $(window).height()/2;
			if(h > wh) menuScroll.height(wh);
			module.scrollStatic.jScrollPane( scrollOptions );
		}
				
		menuCurrent.on("click", function(){
			menu.toggleClass("jsOpened");
						
			if( menu.hasClass("jsOpened") ){
				menuList.css({paddingTop: menuCurrent.height()+1}).stop(true, true).fadeIn(400, function(){
				});
			}else{
				menuList.fadeOut(400);
			}		
			resizeScroll();
		});
		
		var menuGroup = $(".jsSitesMenuGroup");
		menuGroup.on( "click", function(){
			$(this).find(".jsSitesMenuGroupContents").slideToggle(400, "easeInOutQuart", function(){
				resizeScroll();
			});
		});
		
		$(document).on("click", function(e){
			if ( $(e.target).closest(menu).length) return;
			menuList.fadeOut(400);
			menu.removeClass("jsOpened");
			menuItems.removeClass("jsOpened");
			e.stopPropagation();			
		});
	})();
	
	//:active CHILDREN CSS FIX
	$(".activeChildren").mousedown( function(){ $(this).addClass("activeClicked"); });
	$(".activeChildren").mouseleave( function(){ $(this).removeClass("activeClicked"); });
	$(".activeChildren").mouseup( function(){ $(this).removeClass("activeClicked"); });
	
	//ICHECK
	( function(){
		$('input').iCheck({
			labelHover: false,
			cursor: true
		});
		
		$(".form_label").each( function(){
			if( $(this).find(".disabled").length ) $(this).addClass("disabled");
		});
	})();
	
	//MOVEABLE
	
	/*( function(){
		var moving;
		var current;
		var elements = $(".jsMoveElement");
		var scrollTolerance = 80;
		
		$(".jsMoveDrag").on("mousedown", function(){
			moving = $(this).closest(".jsMoveElement").addClass("jsMoving");
			elements.addClass("jsNoHover");
			
			var scroll = $(this).closest(".jsScroll");			
			scroll.on( "mousemove", function(e){
				clearSelection();
				
				if( scroll.length ){
					var api = scroll.data('jsp');
					var pageY = scroll.offset().top;
					if( e.pageY < pageY + scrollTolerance ){
						api.scrollByY( scrollTolerance / 200 * ( e.pageY - (pageY + scrollTolerance)  ) );
					}
					if( e.pageY > pageY + scroll.height() - scrollTolerance ){
						api.scrollByY( scrollTolerance / 200 * ( e.pageY - (pageY + scroll.height() - scrollTolerance)  )  );
					};
				};
				
				moving.prev(".jsMoveElement").one( "mouseenter", function(){ $(this).before(moving); });
				moving.next(".jsMoveElement").one( "mouseenter", function(){ $(this).after(moving); });
			});
			
			$(document).one( "mouseup", function(){
				elements
					.off("mouseenter")
					.removeClass("jsNoHover");
				moving
					.removeClass("jsMoving");
				scroll.off("mousemove");
			});
		});
	})();*/
	
	//SEPARATOR
	( function(){
		var sp = $(".jsSeparator");
		var sizeable = $(".jsSizeable");
		var dim = { min: parseInt( sizeable.css("min-width") ), max: parseInt( sizeable.css("max-width") ), padding: 20 };
		if( $(".cell_order").length ) dim.padding = 0;
		var t;
		
		var area = $(".ltPage");
		var isMoving = false;
		var cleft = getCookie("jsseparator");
		sp.css({ opacity: 0 });
		if( cleft ){ sp.css({ left: cleft }); sizeable.width( parseInt(cleft)-20 ); } 
		
		sp.on( "mouseenter", function(){ t = setTimeout( function(){ if(!isMoving) sp.animate({opacity: "0.8"}, 700); }, 100); });
		sp.on( "mouseleave", function(){ clearTimeout(t); if(!isMoving) sp.stop(true, true).animate({opacity: "0"}, 700); });
		
		sp.on( "mousedown", function(){
			isMoving = true;
			
			if( menu.hasClass("jsOpened") ) menuCurrent.click();
			
			area.on( "mousemove", function(e){
				var x = e.pageX - area.offset().left;
				var w = area.width();
				var cx = x - dim.padding;
				var px = ( x / w ) * 100 + "%";
				if( cx > dim.min && cx < dim.max ){
					sp.css({left: px});
					sizeable.css({width: px});
					resizeContent();
				}else{
						if( cx < dim.min ){
							sp.css({left: dim.min + dim.padding});
							sizeable.css({width: dim.min});
							resizeContent();
						}
						if( cx > dim.max ){
							sp.css({left: dim.max + dim.padding});
							sizeable.css({width: dim.max});
							resizeContent();
						}
				}
				clearSelection();
			});
		});
		
		area.on( "mouseup", function(){
			isMoving = false; sp.animate({opacity: "0"}, 700);
			
			var date = new Date();
			date.setDate(date.getDate()+1);
			setCookie("jsseparator", sp.css("left"), date, "/");
			
			area.off("mousemove");
		});
	})();
});
function initEditor(editor){
	if( editor.length ){
		editor.ckeditor({
			filebrowserBrowseUrl : onessapath+'ckeditor/ckfinder/ckfinder.html',
			filebrowserImageBrowseUrl : onessapath+'ckeditor/ckfinder/ckfinder.html?type=Images',
			filebrowserFlashBrowseUrl : onessapath+'ckeditor/ckfinder/ckfinder.html?type=Flash', 
		});
		
		for(var instanceName in CKEDITOR.instances){
			var editor = CKEDITOR.instances[instanceName];
			editor.on( "instanceReady", function(){
				$('.cke_button__maximize').click(function(){
					$('body').css('position','absolute');
					setTimeout("$('body').css('position','static');", 100);
				})
				resizeContent();
			});
		}
	}
};
//DOC READY

//FUNCTIONS
//calculates space from links to underline
function linkBorderSpace( elements, x, clickableArea){
	elements.each( function(){
		if( $(this).css("display") == "inline"){
			$(this).wrap("<span></span>")
				.parent()
					.css({fontSize: $(this).css("fontSize")});
					
			if(!$.browser.msie || $.browser.version>7){
				$(this).parent().css({lineHeight: "0"});
			}
			
			$(this).wrapInner("<span></span>")
				.css("fontSize", 100*x+"%")
				.find("span")
					.css({"fontSize": 100/x+"%"});
					
			$(this).find("span").css({paddingTop: clickableArea});
		}
	});	
}

//clears selection on page
function clearSelection() {
	if(document.selection && document.selection.empty) {
		document.selection.empty();
	} else if(window.getSelection) {
		var sel = window.getSelection();
		sel.removeAllRanges();
	}
}

//catalog padding
function catalogPadding(indent){
	$(".catalog-menu").each( function(){
		if( !$(this).hasClass("main") ){
			var link = $(this).find(".catalog-menu_link");
			var p = parseInt($(this).prev(".catalog-menu_link").css("paddingLeft"));
			link.css( "paddingLeft", ( p+indent )+"px" );
		}
	});	
	
	$(".catalog-menu_item.active").each( function(){
		$(this).removeClass("jsCurrent");
		if( !$(this).find(".active").length ){
			$(this).parent().closest(".active").addClass("jsCurrent");
			$(this).parents(".catalog-menu_item").removeClass("active");
		}
	});	
}

//COOKIES
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}