;(function($){


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