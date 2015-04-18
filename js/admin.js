jQuery(document).ready(function($){
    
    jQuery('.beefup').beefup({
        openSingle: true
    });
    
    jQuery('.single_option').click(function(){
        jQuery('.single_option').removeClass("active");
        jQuery(this).addClass("active");
        jQuery('div.single_option[checked="checked"]').css("border-color", "#0074a2");
    })
});

