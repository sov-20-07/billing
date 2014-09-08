$(document).ready(function(){

//Все категории
    $(document).click(function(){
        $('.pop-name').removeClass('open');
        $('.to-close').fadeOut(300);
        $('.basket .basket-list').removeClass('visible');
        $('.select-list').fadeOut(300);
    });


    $('.catalog-list').click(function(evt){
        evt.stopPropagation();
        $(this).toggleClass('active');
        $(this).find('.list-category').fadeToggle(100);
    });

    $('.catalog-list .list-category').click(function(evt){
        evt.stopPropagation();
    });


    //Поиск

    $('.search-button').click(function(evt){
        evt.stopPropagation();
        $(this).addClass('submit').attr('onclick','$("#searchform").submit()').find('span').text('Найти');
        $(this).parents('.search-box').find('.search-form').animate({width:394},400);
        $(this).parents('.search-box').find('.search-close').fadeIn(200).click(function(){
            closeSearch();
        });
    });


    $('.search-form .example span').click(function(){
        $('.search').val($(this).text());
    });


    $('.search-box').click(function(evt){
        evt.stopPropagation();
    });


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

    $('input.change-input,textarea').each(function() {
        $(this).focus(function(){
            $(this).addClass('focus');

        });
        $(this).blur(function(){
            $(this).removeClass('focus');

        });
    });


    if($('.fixed-block').length>0){

        $(document).scroll(
            function(){


                if($(document).scrollTop() < $('.card .left-coll').height()-140){
                    if($(document).scrollTop()>311){
                        $('.fixed-block').css('top',$(document).scrollTop()-290);
                        /*$('.fixed-block .white-block').fadeOut(100,function(){
                            $('.fixed-block .up').fadeIn(100);
                        });*/
                    }else{
                        $('.fixed-block').css('top','0');
                        $('.fixed-block .up').fadeOut(100,function(){
                            //$('.fixed-block .white-block').fadeIn(100);
                        });
                    }
                }else if($(document).scrollTop() > $('.card .left-coll').height()){
                    $('.fixed-block').css('top',$('.card .left-coll').height() - $('.fixed-block').height()-20);
                }


            }


        )

    }

    if($('.order-box').length>0){

        $(document).scroll(
            function(){


                if($(document).scrollTop() < $('.purchase .right-coll').height()-10){
                    if($(document).scrollTop()>311){
                        $('.order-box').css('top',$(document).scrollTop()-290);

                    }else{
                        $('.order-box').css('top','0');

                    }
                }else if($(document).scrollTop() > $('.purchase .right-coll').height()){
                    $('.order-box').css('top',$('.purchase .right-coll').height() - $('.order-box').height()-20);
                }


            }


        )

    }




    //product


    $('.product').mouseenter(function(event){
    
        var padding =  $(this).find('.annotation').height()+5;

        $(this).find('.buttons').css('padding-top',padding);
        $(this).css('z-index','20');
        if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
        	document.location.href=$(this).find('a').attr('href');
        }

    });
    $('.product').mouseleave(function(){
        $(this).css('z-index','0')
    });



    //pop-ups

    $('.pop-name').click(function(evt){
        evt.stopPropagation();

        $(this).toggleClass('open');
        $(this).parents('.pop-up-box').find('.pop-box').fadeToggle('300');

    });

    $('.to-close').click(function(evt){
        evt.stopPropagation();

    });

    $('.close').click(function(){
        $(this).parent('.pop-up').fadeOut(300);
        $('.pop-link').css('z-index','1');
    });


    if($("#tabs").size()>0){
        $( "#tabs" ).tabs();
        /* $( "#tabs ul.ui-tabs-nav li:last").css('border-right','1px solid #d7e6ef')*/
    }

    //карусель на карточке товара
    if($(".carousel").size()>0){
        $(".carousel").jCarouselLite({
            btnNext: ".next_pr",
            circular:false,
            btnPrev: ".prev_pr",
            vertical: false

        });}

    if($(".carousel li").size()<6){
        $(".carousel .prev_pr,.carousel .next_pr").css('display','none') ;
    }





//Слайдер на главной

    if($('#slides').size()>0){

        var current = next = auto_rotate = 0;
        $("#slides .nav .dot").click( function(){
            if( !$("#slides .nav .dot").hasClass("dis") ) {
                auto_rotate = 1;
                $(".control.start_stop").addClass("pause");
                if( !$(this).hasClass('act') ) {
                    this_id = $(this).attr('id');
                    var current =  $('#slides ul li.show');
                    var next = $('#slides ul li.c'+this_id);
                    rotate(current, next, 500, auto_rotate);
                }
            }
        } );
        $(".control.start_stop").click( function(){
            if( !auto_rotate ){
                auto_rotate = 1;
                $(this).addClass("pause");
            } else {
                var current =  $('#slides ul li.show');
                var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('#slides ul li:first-child') : current.next()) : $('#slides ul li:first-child'));
                auto_rotate = 0;
                $(this).removeClass("pause");
                setInterval('rotate(current, next, 700, auto_rotate)', 5000);
            }
        } );
        $(".control.next").click( function(){
            if( !$(".control.next").hasClass("dis") ) {
                auto_rotate = 1;
                $(".control.start_stop").addClass("pause");
                var current =  $('#slides ul li.show');
                var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('#slides ul li:first-child') : current.next()) : $('#slides ul li:first-child'));
                rotate(current, next, 500, auto_rotate);
            }
        } );
        $(".control.prev").click( function(){
            if( !$(".control.prev").hasClass("dis") ) {
                auto_rotate = 1;
                $(".control.start_stop").addClass("pause");
                var current =  $('#slides ul li.show');
                var next = ((current.prev().length) ? current.prev() : $('#slides ul li:last-child'));
                rotate(current, next, 500, auto_rotate);
            }
        } );

        if( $("div").hasClass('has_slides') ) {
            rotator();
        }

        $(".sliding").click( function(){
            var this_id = $(this).attr('id');
            $(this).toggleClass("act");
            $(".block_"+this_id).slideToggle(200).toggleClass("act");
        } );

        $(".sliding_parent").click( function(){
            var this_id = $(this).attr('id');
            $(".block_"+this_id).slideToggle(200).parent().parent().toggleClass("act");
        } );
        $(".result_block .ic_close").click( function(){
            $(this).next().next().next().slideToggle(200).parent().parent().toggleClass("act");
        } );

        /*** Slider ***/
        //scrollpane parts
        var scrollPane = $( ".scroll-pane" ),
            scrollContent = $( ".scroll-content" );
        scrollContent.css("width", 174 * $(".scroll-content-item").length);
        //build slider
        var scrollbar = $( ".scroll-bar" ).slider({
            animate: true,
            slide: function( event, ui ) {
                if ( scrollContent.width() > scrollPane.width() ) {
                    scrollContent.stop().animate( { "margin-left": Math.round(
                        ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
                    ) + "px" }, 300);
                } else {
                    scrollContent.stop().animate( { "margin-left": 0  }, 300);
                }
            }
        });
        //append icon to handle
        var handleHelper = scrollbar.find( ".ui-slider-handle" )
            .append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
            .wrap( "<div class='bar_inner_padds'></div>" ).wrap( "<div class='ui-handle-helper-parent'></div>" ).wrap( "<div class='handler_back'></div>" ).parent();

        //change overflow to hidden now that slider handles the scrolling
        scrollPane.css( "overflow", "hidden" );


    }





    //Clicker
    $('.clicker .but').toggle(
        function(){
            clickerBottom();
        },
        function(){
            clickerBoTop();
        }
    );

    $('.compare-page .different').click(
        function(){
            clickerBottom();
        }
    );

    $('.compare-page .all-params').click(
        function(){
            clickerBoTop()
        }
    );



    //##########################################


    if($('.internet-shop').length>0){

        var isMenuList="";
        var isMenuItem;
        var isName=1;
        $('.internet-shop .section-head').each(function(){
            $(this).before('<a name="go'+isName+'"></a>');
            isMenuItem=$(this).find('.section-menu').text();
            isMenuList=isMenuList+'<li><a href="#go'+isName+'">'+isMenuItem+'</a></li>';
            isName++;
        });

        $('.menu-is .top').after('<ul class="menu-go">'+isMenuList+'</ul>');







        $(document).scroll(
            function(){
                if($(document).scrollTop()>305){
                    $('.menu-is .top').addClass('show');

                    /*  $('.menu-is').addClass('fix');*/

                }else{

                    $('.menu-is').removeClass('fix');
                    $('.menu-is .top').removeClass('show');
                }
            }


        )

    }





    $('.center-coll .banner').mouseenter(function(){

        $(this).find('a').css('top','-147px')
    });
    $('.center-coll .banner').mouseleave(function(){

        $(this).find('a').css('top','0')
    });



    //Timer

    // выставим положения черных дней
    //Подставим кол-во дней до конца








    $('.label_check, .label_radio').click(function(){
        setupLabel();
    });
    setupLabel();

    $('.select .select-val').click(function(){


        var defVal=$(this).find('.val').text();

        $(this).parents('.select').find('li').each(function(){
            if($(this).text()==defVal){

                $(this).addClass('selected');
            }else {
                $(this).removeClass('selected');

            }
        });
        $(this).parents('.select').addClass('open');

        $(this).parents('.select').find('.select-list').fadeToggle();

        $(this).parents('.select').find('li').click(function(){

            $(this).parents('.select').find('.select-val .val').text($(this).text());
            $(this).parents('.select').find('input').val($(this).text());
            $(this).parents('.select').find('.select-list').fadeOut();
            $(this).parents('.select').removeClass('open')
        });

    });

    $('.select').click(function(evt){
        evt.stopPropagation();
    });

    $('.select-list').click(function(evt){
        evt.stopPropagation();
    });

    if( $("div").hasClass("slider_pos") ){
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: 100,
            values: [ 5, 55 ],
            slide: function( event, ui ) {
                $("#field_from").val( $("#slider-range").slider("values", 0) * 1000);
                $("#field_to").val( $("#slider-range").slider("values", 1) * 1000);
            }
        });
        $("#field_from").val( $("#slider-range").slider("values", 0) * 1000);
        $("#field_to").val( $("#slider-range").slider("values", 1) * 1000);
    }
    $(".benefit_n_new .case.n1").click( function(){
        $(".benefit_n_new .carousel .lenta2").fadeOut(200);
        $(".benefit_n_new .carousel .lenta1").fadeIn(200);
        $(".benefit_n_new .case.n2").removeClass("act");
        $(this).addClass("act");
    } );
    $(".benefit_n_new .case.n2").click( function(){
        $(".benefit_n_new .carousel .lenta1").fadeOut(200);
        $(".benefit_n_new .carousel .lenta2").fadeIn(200);
        $(".benefit_n_new .case.n1").removeClass("act");
        $(this).addClass("act");
    } );





    //Контакты

    $('.addresses .address').click(function(){
        if(!$(this).hasClass('active')){
            changeContacts($(this))
        }

    });
    if($('.addresses').length>0){
        var cont1=$('.addresses .cont1').height();
        var cont2=$('.addresses .cont2').height();
        var cont3=$('.addresses .cont3').height();
        var contarr=[cont1,cont2, cont3];
        contarr.sort(sDecrease);

        var contHeight=contarr[0];
        $('.cont1,.cont2,.cont3').height(contHeight);

        var dHeight=$('.details ').height();
        $('.details .name').click(function(){
            openDetails(dHeight)

        });
        $('.details .close-but').click(function(){
            openDetails(dHeight)

        });

    }

    //Корзина

    $('.basket .open-basket-list').click(function(evt){
        //evt.stopPropagation();

        //openBasket();
    });
    $('.basket .basket-list').click(function(evt){
        evt.stopPropagation();
    });


    $('.in-basket-but,.buy-sm-but ').click(function(evt){
        evt.stopPropagation();
    });
   
});



function setupLabel() {
    if ($('.label_check input').length) {
        $('.label_check').each(function(){
            $(this).removeClass('c_on');
        });
        $('.label_check input:checked').each(function(){
            $(this).parent('label').addClass('c_on');
        });
    }
    if ($('.label_radio input').length) {
        $('.label_radio').each(function(){
            $(this).removeClass('r_on');
        });
        $('.label_radio input:checked').each(function(){
            $(this).parent('label').addClass('r_on');
        });
    }
}

//Работа с корзиной

function openBasket(){

    if(!$('.basket').hasClass('empty')){
        $('.basket .basket-list').toggleClass('visible');
        paintBasketProductList();
    }
}


function addProductInToBasket(/*name,href,price*/){

    $('.basket .basket-list').addClass('visible');
    //$('.basket-product-list li:first').before("<li class='new-add'><a href='"+href+"' >"+name+"</a><span class='price'>"+price+"<span class='rub'>a</span></span></li>");
    paintBasketProductList();
    $('body,html').animate({scrollTop: 0}, 800);
}


function paintBasketProductList(){
    $('.basket-product-list li').removeAttr('style');
    $('.basket-product-list li:odd').css('background','#ffffff')
}


function changeContacts(cont){
    cont.parents('.address').toggleClass('active');
    var notThis =cont.parents('.address');
    $('.addresses .address').not(notThis).toggleClass('active');
}

function sDecrease(i, ii) {
    if (i > ii)
        return -1;
    else if (i < ii)
        return 1;
    else
        return 0;
}

function openDetails(dHeight){
    var dBlock=$('.details');

    var allHeight=$('.details-height').height();
    dBlock.toggleClass('open');
    if(dBlock.hasClass('open')){
        dBlock.animate({height:allHeight},400);
        dBlock.find('.bot').css('display','none');
        dBlock.find('.close-but').css('display','block');

    }else {
        dBlock.animate({height: dHeight},400);
        dBlock.find('.bot').css('display','block');
        dBlock.find('.close-but').css('display','none');
    }
}
var callbackOptions = {
	contentId: 'callback',
	transitions: ['expand', 'crossfade'],
	fadeInOut: true,
	dimmingOpacity: 0.7,
	dimmingDuration: 0
};
var loginOptions = {
	contentId: 'login',
	transitions: ['expand', 'crossfade'],
	fadeInOut: true,
	dimmingOpacity: 0.7,
	dimmingDuration: 0
};