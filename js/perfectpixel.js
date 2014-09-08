

    function perfectPixel(imgUrl){
        console.log(imgUrl);
        $('body').prepend('<div id="perfect-pixel"></div>')
        var documentWidth=$(document).width();
        var documentHeight=$(document).height();
        var divBg = imgUrl;
        var pixelDiv=$('#perfect-pixel');
        // $('#perfect-pixel').prepend('<img src="/layout.jpg" />')
        $('#perfect-pixel').css({
            'width':documentWidth,
            'height':documentHeight,
            'opacity':'0.5',
            // 'border':'1px solid red',
            'position':'absolute ',
            'z-index':'1000',
            'text-align':'center',
            'overflow':'hidden',
            'background':'url('+divBg+') center top no-repeat',
            'display':'none'
        })

        pixelDiv.click(
            function(){
                $(this).fadeOut(2);
            }
        )

        $(document).keydown(
            function(eventObject){


                if(eventObject.which==0 || eventObject.which==192){
                    pixelDiv.fadeToggle(2);

                }

            }
        )


    }



