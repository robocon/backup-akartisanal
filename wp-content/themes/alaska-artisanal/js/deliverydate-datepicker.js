jQuery.noConflict();
(function( $ ) {
  $(function() {
    
    if($('#shipping_deliverydate').length > 0){
        $('#shipping_deliverydate').datepicker({
            beforeShowDay: function(date){ 
                var day = date.getDay(); 
                return [day == 2 || day == 3 || day == 4 || day == 5,""];
            },
            dateFormat: "mm/dd/yy"
        });
    }
  });
})(jQuery);
