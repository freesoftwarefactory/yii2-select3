jQuery(document).ready(function($){
	
    $.fn.select3 = function()
    {
		var _this = this;
		$(_this).each(function(){
			var z = $(this);
            var hidden = z.find("input[type=hidden]");
          
            z.find('[type=checkbox]').change(function(){
                
                var clicked = $(this);
                
                var checkboxes = $(clicked.attr("data-group")).find("[type=checkbox]");

                var allWasClicked = ('all' == clicked.attr('data-type'));
                
                var obj = {};

                checkboxes.each(function(i, chk){
                
                    var iAmAll = ('all' == $(chk).attr('data-type'));
                    
                    var key = $(chk).val();
                    
                    if(allWasClicked && !iAmAll)
                    {
                        $(chk).prop('checked', clicked.is(':checked'));
                    }

                    if(!iAmAll)
                    Object.defineProperty( obj , key , 
                        { value: $(chk).is(':checked'), writable: 
                            true, enumerable: true, configurable: true });

                });

                console.log(obj);
                hidden.val(window.btoa(JSON.stringify(obj))); 
            });

		});
	};

    $('.select3').select3();

});
