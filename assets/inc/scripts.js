;(function($){
$('.main-hero').slick({
        arrows: false,
        dots: true,
        autoplay: true,
        autoplaySpeed: 9000,
    });

    $(document).ready(function(){
        $(".mobile-menu").click(function(){
            $("#navbarSupportedContent").addClass('show-time',1000);
        });

        $(".menu-close").click(function(){
            $("#navbarSupportedContent").removeClass('show-time',1000);
        });
    });
	
$('#mobilfaq').on('change', function() {
var tabID = $(this).val();
$(tabID).tab("show");
});
	
})(jQuery);