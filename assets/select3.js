jQuery(document).ready(function($){

    $(window).scroll(function(){
        $('.select3 .options:visible').each(function(i,o){ 
            $(o).hide();
        });           
    });
    
    $(window).click(function(e){
        var t = $(e.target);
        if($(t).parents('.select3').length > 0) {
            return;
        }
        $('.select3').find('.options').hide();
    });

    var select3bind = function(widget)
    {

        var hidden = widget.find("input[type=hidden]");
        
        var obj = hidden.val();

        if(obj)
            obj = JSON.parse(window.atob(obj));
     
        setTimeout(function(){ $( document ).trigger( 'select3-initialized', [ obj , widget ]); } , 1);
        
        widget.find('[type=checkbox]').change(function(){
               
            var clicked = $(this);
            
            var checkboxes = $(clicked.attr("data-group")).find("[type=checkbox]");

            var allWasClicked = ('all' == clicked.attr('data-type'));
            
            var obj = {};

            checkboxes.each(function(i, chk){
            
                var iAmAll = ('all' == $(chk).attr('data-type'));
                
                var isDisabled = $(chk).is(":disabled");

                var key = $(chk).val();
                
                if(allWasClicked && !iAmAll && !isDisabled)
                {
                    $(chk).prop('checked', clicked.is(':checked'));
                }

                if(!iAmAll)
                Object.defineProperty( obj , key , 
                    { value: $(chk).is(':checked'), writable: 
                        true, enumerable: true, configurable: true });

            });

            hidden.val(window.btoa(JSON.stringify(obj))); 
	
            $( document ).trigger( 'select3-changed', [ obj , widget ]);
        });

    };

    $.fn.select3 = function()
    {
		var _this = this;
		$(_this).each(function(){
			var widget = $(this);
            var options = widget.find('.options');
            
            var activator = function()
            {
                if(true==widget.hasClass('select3-disabled'))
                    return;

                $('.select3 .options:visible').each(function(i,o){ 
                    if($(o).attr('data-group') != options.attr('data-group'))
                        $(o).hide();
                });

                options.toggle();

                options.css({ "width" : options.parent().width() });
            };

            if(false==widget.hasClass('select3-disabled'))
            {
                widget.find('.activator').click(activator);
            
                if('yes' == widget.find('.text').attr('data-click-behavior'))
                {
                   widget.find('.text').click(activator);
                }
            }
           
            options.css({ 'z-index' : 1000000 });

            select3bind(widget);
		});
	};
    
    $.fn.select3rebind = function(widget)
    {
        select3bind(widget);
    };
        
    $.fn.select3load = function(widget, items, allLabel)
    {
        var options = widget.find('.options');
               
        options.find('.option').remove();
                
        var item = '<label class=\'option option-value option-border-color noselect\'>'
            +'<input type=\'checkbox\' data-group=\''
                +'#'+widget.attr('id')+'\' data-type=\'value\' value=\'\'>'
            +'</label>';
        
        var counter = 0;
        $.each(items, function(key,text){ counter++; });

        if(counter > 1)
        {
            var option = options.append(item).find('.option:last-child');
            option.removeClass('option-value');
            option.addClass('option-all');
            option.find('input').attr('data-type', 'all');
            option.append(allLabel);
        }

        $.each(items, function(key,text){
            var option = options.append(item).find('.option:last-child');
            option.find('input').attr('value', key);
            option.append(text);
        });

        $.fn.select3rebind(widget);
    };

    $.fn.select3Status = function(widget, boolEnabled)
    {
        var cls = 'select3-disabled';
        if(boolEnabled)
        {
            if(widget.hasClass(cls)) widget.removeClass(cls);    
        }
        else
        {
            if(!widget.hasClass(cls)) widget.addClass(cls);    
        }
    };

    $('.select3').select3();

});
