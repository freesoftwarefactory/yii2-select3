jQuery(document).ready(function($){
	
    $.fn.select3 = function()
    {
		var _this = this;
		$(_this).each(function(){
			var widget = $(this);
            var hidden = widget.find("input[type=hidden]");
         
            widget.find('.activator').click(function(){
                var options = widget.find('.options');
                
                $('.select3 .options:visible').each(function(i,o){ 
                    if($(o).attr('group-id') != options.attr('group-id'))
                        $(o).hide();
                });

                options.toggle();

                options.css({ "width" : options.parent().width() });
            });

            widget.find('[type=checkbox]').change(function(){
                
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
