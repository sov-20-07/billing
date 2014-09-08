		/* HIGHSLIDE */
		langu="";
		hs.graphicsDir = "/js/graphics/";
		hs.outlineType = "";
		hs.wrapperClassName = "draggable-header";
		hs.dimmingOpacity = 0.9;
		hs.align = "center";
		
		var popupCompareOptions = {
			contentId: 'popupCompare',
			transitions: ['fade'],
			fadeInOut: true,
			dimmingOpacity: 0.9,
			dimmingDuration: 0,
			preserveContent: true,
			width: 400
		};
		
		var popupSaveOptions = {
			contentId: 'popupSave',
			transitions: ['fade'],
			fadeInOut: true,
			dimmingOpacity: 0.9,
			dimmingDuration: 0,
			preserveContent: true,
			width: 400
		};
		
		var popupBuyOptions = {
			contentId: 'popupBuy',
			transitions: ['fade'],
			fadeInOut: true,
			dimmingOpacity: 0.9,
			dimmingDuration: 0,
			preserveContent: true,
			width: 400
		};
		
		var galleryOptions = {
			slideshowGroup: 1,
			outlineType: '',
			wrapperClassName: 'projects_gallery',
			dimmingOpacity: 0.9,
			align: 'center',
			transitions: ['expand', 'crossfade'],
			fadeInOut: true,
			marginLeft: 100,
			marginBottom: 0,
			maxWidth: 960,
			maxHeight: 560,
			captionEval: 'this.thumb.alt',
			dimmingDuration: 0
		};
		
		hs.addSlideshow({
			slideshowGroup: 1,
			interval: 5000,
			repeat: false,
			useControls: true,
			overlayOptions: {
				thumbnailId: 'art1gallary',
				className: 'text-controls',
				relativeTo: 'highslide-wrapper',
				offsetY: "50%",
			},
			thumbstrip: {
				thumbnailId: 'art1gallary',
				position: 'bottom center',
				mode: 'horizontal',
				relativeTo: 'highslide-wrapper',
				offsetY: 71
			}
		});
		
		// not dragged
		hs.Expander.prototype.onDrag = function() {
			return false;
		};
		
		// Keep the position after window resize
		hs.addEventListener(window, 'resize', function() { highslideMoveFix(); });		
		hs.addEventListener(window, 'scroll', function() { highslideMoveFix();	});		
		hs.Expander.prototype.onAfterExpand = function () { highslideMoveFix(); };
		
		var ovn=0;
		hs.Expander.prototype.onCreateOverlay=function(){	}
		
		function highslideMoveFix(){
			var i, exp;
			hs.page = hs.getPageSize();
			for (i = 0; i < hs.expanders.length; i++) {
				exp = hs.expanders[i];
				if (exp) {
					var x = exp.x,
							y = exp.y;
					// get new thumb positions
					exp.tpos = hs.getPosition(exp.el);
					x.calcThumb();
					y.calcThumb();
					// calculate new popup position
					x.pos = x.tpos - x.cb + x.tb;
					x.scroll = hs.page.scrollLeft;
					x.clientSize = hs.page.width;
					y.pos = y.tpos - y.cb + y.tb;
					y.scroll = hs.page.scrollTop;
					y.clientSize = hs.page.height;
					exp.justify(x, true);
					exp.justify(y, true);
					// set new left and top to wrapper and outline
					exp.moveTo(x.pos, y.pos);
				}
			}
		}