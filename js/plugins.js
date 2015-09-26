(function( $ ){
    $.fn.categorized = function( settings, options ) {
        for(var i=0;i<options.length;i++)
            options[i] = $.extend({
                resolution: 0,   //mandatory
                columns: 0,   //mandatory
                itemMarginRight: 0,
                itemMarginBottom: 0,
                containerPaddingTop: 0,
                containerPaddingBottom: 0,
                containerPaddingLeft: 0,
                containerPaddingRight: 0,
                itemHeight: 0   //mandatory
            }, options[i]);
        settings = $.extend({
            itemClass: '',   //mandatory
            time: 0,   //mandatory
            allCategory: '',   //mandatory
            categoryAttribute: 'data-categories'
        }, settings);
        var t = this.get(0);
        var t_container = $(t);
        var t_items = t_container.children('.'+settings.itemClass);
        var t_items_length = t_items.length;
        var t_items_categorized = [];
        var t_category_all = settings.allCategory;
        var t_category;
        if(settings.initialCategory!==undefined)
            t_category = settings.initialCategory;
        else
            t_category = t_category_all;
        var t_category_previous = t_category_all;
        var t_index = -1;
        var x_categorize = function(){
            for(var i=0;i<t_items_length;i++){
                var x_current = t_items.filter(':eq('+i+')');
                t_items_categorized.push({
                    item: x_current,
                    categories: x_current.attr(settings.categoryAttribute).replace(/^\s+/,'').replace(/\s+$/,'').replace(/\s+/g,' ').toLowerCase().split(' ')
                });
            };
        };
        x_categorize();
        var x_sortResolutions = function(){
            for(var i=0;i<options.length-1;i++){
                var i_max = i;
                for(var j=i+1;j<options.length;j++)
                    if(options[j].resolution>options[i_max].resolution){
                        i_max = j;
                    }
                if(i_max>i){
                    var temp = options[i];
                    options[i] = options[i_max];
                    options[i_max] = temp;
                }
            }
        };
        x_sortResolutions();
        var x_arrangeItems = function(){
            t_container.width(options[t_index].resolution);
            var x_width = Math.floor((options[t_index].resolution-options[t_index].containerPaddingLeft-options[t_index].containerPaddingRight-(options[t_index].columns-1)*options[t_index].itemMarginRight)/options[t_index].columns);
            var x_height = t_items.height();
            x_height = options[t_index].itemHeight;
            var x_index = 0;
            for(var i=0;i<t_items_length;i++){
                if(-1!==t_items_categorized[i].categories.indexOf(t_category)||t_category===t_category_all){
                    if(-1!==t_items_categorized[i].categories.indexOf(t_category_previous)||t_category_previous===t_category_all){
                        t_items_categorized[i].item.stop().animate({
                            top: options[t_index].containerPaddingTop+Math.floor(x_index/options[t_index].columns)*(x_height+options[t_index].itemMarginBottom),
                            left: options[t_index].containerPaddingLeft+(x_index%options[t_index].columns)*(x_width+options[t_index].itemMarginRight)
                        },{duration:settings.time,queue:false,easing:'linear'});
                    }else{
                        t_items_categorized[i].item.stop().css({
                            top: options[t_index].containerPaddingTop+Math.floor(x_index/options[t_index].columns)*(x_height+options[t_index].itemMarginBottom),
                            left: options[t_index].containerPaddingLeft+(x_index%options[t_index].columns)*(x_width+options[t_index].itemMarginRight),
                            marginLeft: (1===options[t_index].columns?0:x_width/2),
                            marginTop: x_height/2
                        });
                    }
                    t_items_categorized[i].item.animate({
                        opacity: 1,
                        width: x_width,
                        height: x_height,
                        marginLeft: 0,
                        marginTop: 0
                    },{duration:settings.time,queue:false,easing:'linear'});
                    x_index++;
                }else{
                    if(-1!==t_items_categorized[i].categories.indexOf(t_category_previous)||t_category_previous===t_category_all){
                        t_items_categorized[i].item.stop().animate({
                            opacity: 0,
                            width: (1===options[t_index].columns?x_width:0),
                            height: 0,
                            marginLeft: (1===options[t_index].columns?0:x_width/2),
                            marginTop: x_height/2
                        },{duration:settings.time,queue:false,easing:'linear'});
                    }
                }
            }
            t_container.stop().animate({height:options[t_index].containerPaddingTop+options[t_index].containerPaddingBottom+(x_index?(Math.ceil(x_index/options[t_index].columns)-1)*(x_height+options[t_index].itemMarginBottom)+x_height:0)},{duration:settings.time,queue:false,easing:'linear'});
        };
        var x_arrangeItemsResponsive = function(){
            t_container.width(options[t_index].resolution);
            var x_width = Math.floor((options[t_index].resolution-options[t_index].containerPaddingLeft-options[t_index].containerPaddingRight-(options[t_index].columns-1)*options[t_index].itemMarginRight)/options[t_index].columns);
            var x_height = options[t_index].itemHeight;
            var x_index = 0;
            for(var i=0;i<t_items_length;i++){
                if(!(-1===t_items_categorized[i].categories.indexOf(t_category))||t_category===t_category_all){
                    t_items_categorized[i].item.stop().css({
                        top: options[t_index].containerPaddingTop+Math.floor(x_index/options[t_index].columns)*(x_height+options[t_index].itemMarginBottom),
                        left: options[t_index].containerPaddingLeft+(x_index%options[t_index].columns)*(x_width+options[t_index].itemMarginRight),
                        opacity: 1,
                        width: x_width,
                        height: x_height,
                        marginLeft: 0,
                        marginTop: 0
                    });
                    x_index++;
                }else
                    t_items_categorized[i].item.stop().css({
                        top: options[t_index].containerPaddingTop+Math.floor(i/options[t_index].columns)*(x_height+options[t_index].itemMarginBottom),
                        left: options[t_index].containerPaddingLeft+(i%options[t_index].columns)*(x_width+options[t_index].itemMarginRight),
                        opacity: 0,
                        width: 0,
                        height: 0,
                        marginLeft: x_width/2,
                        marginTop: x_height/2
                    });
            }
            t_container.stop().css({height:options[t_index].containerPaddingTop+options[t_index].containerPaddingBottom+(x_index?(Math.ceil(x_index/options[t_index].columns)-1)*(x_height+options[t_index].itemMarginBottom)+x_height:0)});
        };
        t.changeCategory = function(category){
            category = category.toLowerCase();
            if(category!==t_category){
                t_category_previous = t_category;
                t_category = category;
                x_arrangeItems();
            }
        };
        var t_window = $(window);
        var x_resize = function(){
            var w_width = t_window.width();
            var t_index_temp = 0;
            while(w_width<options[t_index_temp].resolution&&t_index_temp<options.length-1)
                t_index_temp++;
            if(t_index_temp!==t_index){
                t_index = t_index_temp;
                x_arrangeItemsResponsive();
            }
        };
        t_window.resize(x_resize);
        x_resize();
        t.destroyCategorizedObject = function(){
            t_window.unbind('resize',x_resize);
            delete t.changeCategory;
        };
        return t;
    };
})( jQuery );
