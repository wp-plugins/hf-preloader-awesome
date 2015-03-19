    jQuery(document).ready(function($){

        $('html').addClass('loadings');

        $(window).load(function(){  
            $('.hf_spinner').fadeOut();
            $('.hf_preloader_container').delay(350).fadeOut('slow');
            $('body').delay(350).css({'overflow':'visible'});
            /*  For scrollBar*/
            $('html').removeClass('loadings');
        });       
    });

