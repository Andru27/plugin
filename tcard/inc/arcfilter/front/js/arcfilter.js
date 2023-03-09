/* 
 Author: Cloanta Alexandru
 Name: Tcard > Arcfilter Wordpress
 Version: 2.9.1
*/

(function ($) {

    'use strict';

    function arcfilter(el, option) {
        var self = this;

        el = $(el);

        var defaults = {
            filterNav: el.closest(".arcfilter-group").find(".arc-nav-item"),
            type: "hidden",
            displayItems: 12,
            animations: ['animated zoomIn'],
            random: false,
            delayAnimation: 100,
            speed: 400,
            chooseLoad: "button",
            loadButton: el.closest(".arcfilter-group").find(".arc-loadmore"),
            noData: "No more data",
            loading: false,
            loadingText: "Loading...",
            loadItems: 6,
            counter: "onhover",
            tcard_set: null,
            cat_page: null,
            page: null,
            walker_menu: false,
            use_param: [],
            callBack: function () {}
        };

        self.option = $.extend({}, defaults, option);

        var count_img = 0;

        self.resizeContainer(el, option, "statikHeight");

        $(document).on("ready",function(){
            self.init(el, self.option);
        });
    }
    arcfilter.prototype = {
        init: function (el, option) {
            var self = this;

            el.find(".arcfilter-item").css("display","none");

            var stop = 1;

            self.option.filterNav.on("click", function (e) {

                var category = $(this).attr('data-category').toLowerCase();

                if (!$(this).hasClass("arc-filter-cl")) {
                    if (typeof self.option.callBack === 'function') {
                        self.option.callBack.call(self, option);
                    }

                    if(!$(this).hasClass("is_open_menu") && self.is_mobile() || $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                     

                        $(this).filter(".arc-subnav-item:not(.arc-subitem-curr)")
                        .closest(".arc-subnav")
                        .find(".arc-subnav")
                        .slideUp(300)

                        $(this).filter(".arc-subnav-item:not(.arc-subitem-curr)")
                        .closest(".arc-subnav")
                        .find(self.option.filterNav).removeClass("is_open_menu");

                        $(this).filter(".arc-nav-main-item:not(.arc-item-curr)")
                        .closest(".arc-nav-filter")
                        .find(".arc-subnav")
                        .slideUp(300)

                        $(this).filter(".arc-nav-main-item:not(.arc-item-curr)")
                        .closest(".arc-nav-filter")
                        .find(self.option.filterNav)
                        .removeClass("is_open_menu");

                        $(this)
                        .next(".arc-subnav")
                        .find(".arc-subnav")
                        .slideUp(300)

                        $(this)
                        .next(".arc-subnav")
                        .find(self.option.filterNav).removeClass("is_open_menu")
                        
                    }

                    if($(this).hasClass("arc-subnav-item")){

                        self.option.filterNav.removeClass("arc-filter-cl arc-item-curr arc-subitem-curr")
                        $(this).addClass("arc-filter-cl arc-subitem-curr");

                        if(!$(this).closest(".item-list-first").find(".arc-nav-main-item").hasClass("arc-item-curr")){
                            el.find(".arc-nav-main-item").removeClass("arc-filter-cl arc-item-curr");

                            if(self.is_mobile() || $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                               el.find(".arc-nav-main-item").removeClass("is_open_menu"); 
                            }

                            $(this).closest(".item-list-first").find(".arc-nav-main-item").addClass("arc-item-curr")

                            if(self.is_mobile() || $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                               $(this).closest(".item-list-first").find(".arc-nav-main-item").addClass("is_open_menu")
                            }
                        }
   
                        if(self.option.walker_menu == true){
                           var parentCat = $(this).attr("data-parent");
                        
                            self.option.filterNav.each(function(){
                                var parents = $(this).attr("data-parent");
                                var pattern = new RegExp("(^|\\W)" + parents + "($|\\W)");
                                if(parentCat.match(pattern)){
                                    $(this).addClass("arc-subitem-curr")
                                    .closest(".item-list-first")
                                    .addClass("item-list-first-active");
                                    if(self.is_mobile() || $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                                        $(this).closest(".arc-subnav.arc-nav-lvl0")
                                        .slideDown(0)
                                        $(this).filter(":not(.arc-filter-cl)").addClass("is_open_menu")
                                        .next(".arc-subnav")
                                        .slideDown(0);
                                    }
                                }
                            });
                        }
                        
                    }else{
                        self.option.filterNav.removeClass("arc-filter-cl arc-item-curr arc-subitem-curr")
                        .parent().removeClass("item-list-first-active");
                        $(this).addClass("arc-filter-cl arc-item-curr")
                        .parent().addClass("item-list-first-active");
                    }
                    self.filterCategory(el, option, category,stop);
                    if(!$(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                        self.nav($(this),el, option);
                    }
                }

                if(self.is_mobile() || $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){

                    $(this).toggleClass("is_open_menu")
                    .next(".arc-subnav").slideToggle(300);

                }else{
                    self.option.filterNav.removeClass("is_open_menu")
                }    

                stop = 0;
            });

            var arc_subnavIn = self.option.filterNav.next(".arc-subnav.arc-nav-lvl0").attr("data-animationin"),
                arc_subnavOut = self.option.filterNav.next(".arc-subnav.arc-nav-lvl0").attr("data-animationout")

            self.option.filterNav.on("mouseenter",function(){
                if($(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")) return;
                if(self.is_mobile()){
                    self.option.filterNav.next(".arc-subnav").removeClass(arc_subnavOut,arc_subnavIn)
                }else{
                    $(this).next(".arc-subnav")
                    .fadeIn(0)
                    .removeClass(arc_subnavOut)
                    .addClass(arc_subnavIn)
                }
            }).closest(".arc-nav-item-list").on("mouseleave",function(){
                if(self.is_mobile() || $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")) return;
                $(this).find(".arc-subnav")
                .fadeOut()
                .removeClass(arc_subnavIn)
                .addClass(arc_subnavOut)
            });
            

            el.closest(".arcfilter-group").find(".arc_mobile_open_menu").on("click",function(){
                
                if($(this).hasClass("arc_sidebar-btn")){

                    var dirr = $(this).closest(".arcfilter-menu").attr("data-dirr");

                    if($(this).closest(".arcfilter-menu").hasClass("slide")){
                        $(this).closest(".arcfilter-menu").removeClass("slideIn" + dirr).addClass("slideOut" + dirr).fadeOut(600);
                    }else if($(this).closest(".arcfilter-menu").hasClass("fadeIn")){
                        $(this).closest(".arcfilter-menu").removeClass("fadeIn").addClass("fadeOut").fadeOut(600);
                    }
                }else{
                    $(this).closest(".arcfilter-group").find(".arcfilter-menu.arc-top-menu").slideToggle(300); 
                }

            });

            el.closest(".arcfilter-group").find(".arc_open_wc_sidebar_btn").on("click",function(){
            
                if($(this).closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar").hasClass("slide")){

                    var dirr = $(this).closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar").attr("data-dirr");

                    $(this).closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar")
                    .removeClass("slideOut" + dirr).addClass("slideIn" + dirr).fadeIn(0);
                }else if($(this).parent().next(".arcfilter-menu.arc-nav-sidebar").hasClass("fadeIn")){
                    $(this).closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar")
                    .removeClass("fadeOut").addClass("fadeIn").fadeIn(0);
                }
                
            });
            
            $(window).on("resize",function(){

                self.nav(self.option.filterNav.filter(".arc-filter-cl"),el, option);

                if($(window).width() > 991 && el.closest(".arcfilter-group").find(".arcfilter-menu").hasClass("arc-top-menu")){
                    el.closest(".arcfilter-group").find(".arcfilter-menu.arc-top-menu .arc-nav-filter").find(".arc-subnav").removeAttr("style");
                    el.closest(".arcfilter-group").find(".arcfilter-menu.arc-top-menu").removeAttr("style");
                }else if($(window).width() > 991 && el.closest(".arcfilter-group").find(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                    el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar").removeAttr("style");
                }
            });

            var clickAll = self.option.filterNav.filter('[data-category= "'+self.option.cat_page+'"]');
            clickAll.trigger('click');

            if(self.option.chooseLoad == "pagination"){
                if(self.option.displayItems == "all"){
                    var url = window.location.pathname;
                    history.replaceState(null, null, url);
                }
                self.pagination(el,option,'pageLink',stop);
                if(el.closest(".arcfilter-group").find(".arc-wc-price").length){

                   self.filter_price(el, option);  

                }
                if(el.closest(".arcfilter-group").find(".arc-wc-tags").length){
                   self.filter_tags(el, option); 
                }

                if(el.closest(".arcfilter-group").find(".arc-wc-attributes").length){
                   self.filter_attributes(el, option); 
                }
                
            }else{
                var url = window.location.pathname;
                history.replaceState(null, null, url);
                self.loadmore(el,option);
            }
           
        },
        nav: function(navItem,el, option){
            var self = this;

            if(navItem.closest(".arc-top-menu .arc-nav-filter").hasClass("style_1")){
                var magic = navItem.closest(".arc-nav-filter").find(".arc-nav-line"),pos,
                newNavItem = navItem.closest(".item-list-first");

                if(self.is_mobile()){
                    pos = navItem.closest(".item-list-first").position().top;
                    magic.css({
                        top: pos,
                        left: 0,
                        width: newNavItem.outerWidth(),
                        height: navItem.outerHeight()
                    });
                }else{
                   
                    pos = navItem.closest(".item-list-first").position().left;
                    magic.css({
                        left: pos,
                        top:0,
                        width: newNavItem.outerWidth(),
                        height: newNavItem.outerHeight()
                    });
                    
                }
                setTimeout(function(){
                    magic.addClass("after");
                },100)
            }
        },
        filter_price: function(el, option){
            var self = this,
                price = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-price");

            if(price.hasClass("slider")){
                var slider_price = price.find( "#arc-slider-range" );
                slider_price.slider({
                    range: true,
                    min: parseInt(slider_price.attr("data-min")),
                    max: parseInt(slider_price.attr("data-max")),
                    values: [ parseInt(slider_price.attr("data-start")), parseInt(slider_price.attr("data-stop")) ],
                    slide: function( event, ui ) {
                        
                        $(this).parent(".arc-wc-price").find(".arc_min_price").text(ui.values[ 0 ]);
                        $(this).parent(".arc-wc-price").find(".arc_max_price").text(ui.values[ 1 ]);

                    },
                    stop: function( event, ui ) {
                        var min = parseInt(slider_price.attr("data-start")),
                            max = parseInt(slider_price.attr("data-stop")),newParams;
                        if(min !== ui.values[0]){
                            newParams = ['min_price'];
                        }

                        if(max !== ui.values[1]){
                            newParams = ['max_price'];
                        }
                    
                        if(min !== ui.values[0] || max !== ui.values[1]){

                            slider_price.attr("data-start",ui.values[0]);
                            slider_price.attr("data-stop",ui.values[1]);

                            self.get_items("price",null,1,el,option);

                            history.pushState(null, null, self.params(el,option,newParams,null)); 
                        }
                    }
                });
            }else{
                var normal_price = price.find( ".arc_price_values" ),
                btn_price = price.find( ".arc_btn_filter_items" );

                normal_price.find( 'input' ).on("input",function(){
                    if($(this).parent().hasClass("arc_min_value")){
                        normal_price.find( '.arc_min_price' ).text($(this).val())
                    }else{
                        normal_price.find( '.arc_max_price' ).text($(this).val())
                    }
                })

                btn_price.on("click",function(){
                    var min = parseInt(normal_price.attr("data-start")),
                        max = parseInt(normal_price.attr("data-stop")),newParams,
                        val_min = parseInt(normal_price.find( '.arc_min_value input' ).val()),
                        val_max = parseInt(normal_price.find( '.arc_max_value input' ).val()),
                        input_min = val_min,
                        input_max = val_max;

                    if(val_min == ""){
                        val_min = 0
                        input_min = parseInt(normal_price.attr("data-min"))
                    }

                    if(val_max == "" || val_max > parseInt(normal_price.attr("data-max"))){
                        val_max = parseInt(normal_price.attr("data-max"))
                        input_max = parseInt(normal_price.attr("data-max"))
                    }

                    if(val_min > parseInt(normal_price.attr("data-max")) || val_max < val_min){
                        return false;
                    }
     
                    if(min !== val_min){
                        newParams = ['min_price'];
                    }

                    if(max !== val_max){
                        newParams = ['max_price'];
                    }

                    if(min !== val_min || max !== val_max){

                        normal_price.attr("data-start",val_min);
                        normal_price.attr("data-stop",val_max);

                        normal_price.find( '.arc_min_value input' ).val(input_min)
                        normal_price.find( '.arc_max_value input' ).val(input_max)

                        normal_price.find( '.arc_min_price' ).text(input_min)
                        normal_price.find( '.arc_max_price' ).text(input_max)


                        self.get_items("price",null,1,el,option);

                        history.pushState(null, null, self.params(el,option,newParams,null)); 
                    }
                });
            }
        },
        filter_tags: function(el,option){

            var self = this,
                tags = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-tags"),checked_tag = [];

            tags.find(".arc-wc-tag").filter(".checked_tag").each(function(){
                checked_tag.push($(this).attr("data-tag"));
                
            });

            tags.find(".arc_btn_filter_items").attr("data-tags",JSON.stringify(checked_tag));

            tags.find(".arc-wc-tag").on("click",function(){
                $(this).toggleClass("checked_tag");
                if($(this).hasClass("checked_tag")){
                    checked_tag.push($(this).attr("data-tag"))
                }else{
                   checked_tag.splice(checked_tag.indexOf($(this).attr("data-tag")),1);
                }
            });

            tags.find(".arc_btn_filter_items").on("click",function(){

                var data_tags = JSON.parse($(this).attr("data-tags"));

                if(!self.compare(checked_tag,data_tags)){

                    self.get_items("tags",null,1,el,option);

                    history.pushState(null, null, self.params(el,option,['tags'],null)); 
                }

            });
        },
        filter_attributes: function(el,option){
            var self = this,
                attributes = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-attributes"),
                parent = [],
                checked = [];


                
            attributes.find(".arc-wc-attr").filter(".arc_check_attr").each(function(){
                checked.push($(this).attr("data-attr"));
            });

            attributes.attr("data-attr-checked",JSON.stringify(checked)); 
            attributes.find(".arc_btn_filter_items").attr("data-attributes",JSON.stringify(checked));
            

            attributes.find(".arc-wc-attr").on("click",function(){

                attributes.removeClass("active").addClass("not_active");

                $(this).closest(attributes).removeClass("not_active").addClass("active");

                $(this).toggleClass("arc_check_attr");

                var parent = $(this).closest(attributes).attr("data-wc-attr");

                checked = self.attributes("get",parent,el,option);

                $(this).closest(attributes).attr("data-attr-checked",JSON.stringify(checked))
            });

            attributes.find(".arc_btn_filter_items").on("click",function(){

                var data_attributes = JSON.parse($(this).attr("data-attributes")),
                    parent_attributes = JSON.parse($(this).closest(attributes).attr("data-attr-checked"));  

                if(!self.compare(parent_attributes,data_attributes)){

                    self.get_items("attributes",$(this).closest(attributes).attr("data-wc-attr"),1,el,option);

                    history.pushState(null, null, self.params(el,option,[$(this).closest(attributes).attr("data-wc-attr")],null)); 
                }
                
            });

        },
        is_mobile: function(){
            var mobile;
            if($(window).width() < 992){
                mobile = true;
            }else{
                mobile = false;
            }
            $(window).on("resize",function(){
                if($(window).width() < 992){
                    mobile = true;
                }else{
                    mobile = false;
                }
            });
            return mobile;
        },
        loadmore: function (el,option) {
            var self = this,
                    scrolling = false,
                    stop = 1;

            self.option.filterNav.on("click", function () {
                stop = 1;
            });

            function more() {

                var speed = self.option.delayAnimation * self.option.loadItems;

                if(self.option.type == "hidden"){

                    var hiddenItem = el.find(".arc-item-shown:not(:visible)" + ':lt(' + self.option.loadItems + ')');

                    animate_items(hiddenItem,stop);
        
                    if(self.option.loading = true && self.option.chooseLoad == "button"){
                        setTimeout(function(){
                            backtext("oldText");
                        },speed - self.option.delayAnimation);
                    }
                }
                else if(self.option.type == "ajax"){

                    if(self.option.filterNav.filter(".arc-filter-cl").attr("data-items") > el.find(".arc-item-shown").length){

                        var allvisible = [];
                        el.find(".arcfilter-item").each(function(){
                            allvisible.push($(this).attr("data-number"));
                        });

                        if(scrolling == false){
                            var data = {
                                action: 'arcfilter_load_items',
                                security: arcfilter_ajax.arcfilter_load_items,
                                category: self.option.filterNav.filter(".arc-filter-cl").attr("data-category"),
                                all_items: allvisible,
                                group_id: el.closest(".arcfilter-group").attr("data-group-id")
                            };
                            
                            $.ajax({
                                url: arcfilter_ajax.ajaxurl,
                                type: 'POST',
                                data: data,
                                success:function(data){
                                    $(data).appendTo(el.find(".row")).addClass("arc-item-shown").fadeOut(0);

                                    var hiddenItem = el.find(".arc-item-shown:not(:visible)" + ':lt(' + self.option.loadItems + ')');
                                    var count_img = 0;
                                    if(hiddenItem.find("img[src !='']").length){
                                        hiddenItem.find("img[src !='']").on("load",function(){
                                            count_img++;
                                            if(count_img == hiddenItem.find("img[src !='']").length){
                                                animate_items(hiddenItem);
                                                if(self.option.chooseLoad == "button"){
                                                  backtext("oldText");  
                                                }
                                            }
                                        });
                                    }else{
                                        animate_items(hiddenItem);
                                        if(self.option.chooseLoad == "button"){
                                          backtext("oldText");  
                                        }   
                                    }
                                   
                                },
                                error: function(error){
                                    console.log("Items can not be loaded!!")
                                }
                            })
                                                   
                        }
                    }
                }

                function animate_items(hiddenItem){
       
                    self.animateItems(el,option,'load',hiddenItem,stop);

                    if(!el.hasClass("loaded_items")){
                        el.addClass('loaded_items');
                    }

                    var all = self.option.filterNav.filter('[data-category ~= "all"]').attr("data-loaded");
        
                    self.option.filterNav.each(function(){
                        var thisMenu = $(this);
                        if(self.option.type == "ajax"){
                            var category = thisMenu.attr('data-category').toLowerCase();
                            var countSize;
                            
                            if (category == 'all') {
                                el.find(".arcfilter-item").each(function () {
                                    $(this).attr("all", '');
                                });
                                countSize = el.find(".arcfilter-item").filter("[all='']").length;
                            } else {
                                countSize = el.find(".arcfilter-item").filter('[data-categories ~= "' + category + '"]').length;
                            }
                            thisMenu.attr('data-loaded',countSize);
              
                        }else{
                            var categoryAttr = thisMenu.attr("data-category").toLowerCase(),loadedItems;

                            el.find(".arc-item-shown:visible").each(function(){
                                if($(this).attr('data-categories').toLowerCase().indexOf(categoryAttr) !== -1){
                                    if(!$(this).hasClass("is_loaded")){

                                        loadedItems = el.find(".arc-item-shown:visible").filter(':visible[data-categories ~= "' + categoryAttr + '"]');

                                        thisMenu.filter('[data-category ~= "' + categoryAttr + '"]').attr("data-loaded",loadedItems.length);

                                        if(categoryAttr == "all" && !self.option.filterNav.filter('[data-category ~= "all"]').hasClass("arc-filter-cl")){
                                            var allSizeL = (parseInt(all) + hiddenItem.length);
                                            self.option.filterNav.filter('[data-category = "all"]').attr("data-loaded",allSizeL)
                                        }
                                    
                                        setTimeout(function(){
                                            el.find(".arc-item-shown:visible").addClass("is_loaded");
                                             loadedItems = el.find(".arc-item-shown.is_loaded").filter('[data-categories ~= "' + categoryAttr + '"]');

                                            var allItems = el.find(".arcfilter-item.is_loaded").filter('[data-categories ~= "' + categoryAttr + '"]');

                                            var all_items_load = Math.abs(loadedItems.length - allItems.length);
                      
                                            thisMenu.filter('[data-category ~= "' + categoryAttr + '"]').attr("data-loaded",loadedItems.length + all_items_load);
                                        },100)

                                    }
                                }
                            });
                        }
                    });

                    setTimeout(function () {
                        scrolling = false;
                    }, speed - self.option.delayAnimation);
                }

                if(self.option.loading = true && self.option.chooseLoad == "button"){
                    backtext("loadText");
                }

                scrolling = true;
            }

            function stopMore() { 
                var allSize,visibleSize;
                if(self.option.type == "hidden"){
                    allSize = el.find(".arc-item-shown").length
                    visibleSize = el.find(".arc-item-shown:visible").length;
                    if (visibleSize >= allSize) {
                        stop = 0;
                    } 
                }else{
                    allSize = el.find(".arc-item-shown:visible").length
                    visibleSize = self.option.filterNav.filter(".arc-filter-cl").attr("data-items");
                    if (allSize >= visibleSize) {
                        stop = 0;
                    } 
                }
            }
        
            function stopScrollUp() {
                el.on('DOMMouseScroll mousewheel touchmove', function () {
                    var loadLast = el.find(".arc-item-shown:visible").last(),
                        windowHeight = $(window).height();

                        if(loadLast.length){
                            var elements = loadLast.offset().top + loadLast.height() / 2;
                        }

                        var wh = $(window).height(),
                            wtp = $(window).scrollTop(),
                            wbp = (wtp + wh);   
                   
                    if (elements < wbp) {
                        stop = 1;
                    } else {
                        stop = 0;
                    }
                });
            }

            if (self.option.chooseLoad === "button") {
                var oldT = self.option.loadButton.find("span.arc-load-text").text();
                self.option.filterNav.on("click", function () {

                    if (!self.option.loadButton.has(":contains(" + self.option.noData + ")").length) {
                        backtext("newText");
                    }

                    if (self.option.loadButton.has(":contains(" + self.option.noData + ")").length) {
                        if(el.find(".arcfilter-item:visible").length < $(this).attr('data-items')){
                            if(self.option.loading == true && self.option.chooseLoad == "button"){
                                backtext("oldText");
                            }
                        }
                    }
       
                    if($(this).attr("data-loaded") == 0){
                    
                        if(self.option.loading == true && self.option.chooseLoad == "button"){
                            backtext("newText");
                        }
                        stopMore();
                        if (stop === 1) {
                            if (scrolling)
                                return false;
                            more();
                        }
                    }
                });

                self.option.loadButton.on("click", function () {
                    if(self.option.loading == true && self.option.chooseLoad == "button"){
                        backtext("newText");
                    }
                    stopMore();
                    if (stop === 1) {
                        if (scrolling)
                            return false;
                        more();
                    }
                   
                });
            } else if (self.option.chooseLoad === "scroll") {

                el.on('DOMMouseScroll mousewheel', function (e) {
                    stopMore();
                    if (stop === 1) {
                        if (e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0) {
                            if (scrolling)
                                return false;
                            stopScrollUp();
                            more();
                        }
                    }
                });

                el.on('touchmove', function (e) {
                    stopMore();
                    if (stop === 1) {
                        stopScrollUp();
                        more();
                    }
                });
                $(window).resize(stopScrollUp);
            }

            function backtext(action) {
                var allSize,visibleSize;
                if(self.option.type == "hidden"){
                    allSize = el.find(".arc-item-shown").length
                    visibleSize = el.find(".arc-item-shown:visible").length;
                    if (visibleSize >= allSize) {
                        stop = 0;
                    } 
                }else{
                    allSize = el.find(".arc-item-shown:visible").length
                    visibleSize = self.option.filterNav.filter(".arc-filter-cl").attr("data-items");
                    if (allSize >= visibleSize) {
                        stop = 0;
                    } 
                }

                if(action == "oldText"){
                    self.option.loadButton.find("span.arc-load-text").animate({opacity: 0}, 150)
                    .queue(function () {
                        $(this).text(oldT);
                        $(this).dequeue();
                    })
                    .animate({opacity: 1}, 150);
                }
                else if(action == "loadText"){
                     if (self.option.loading === true) {
                        if (stop == 1) {
                            if (scrolling)
                                return false;
                            self.option.loadButton.find("span.arc-load-text").animate({opacity: 0}, 150)
                            .queue(function () {
                                $(this).text(self.option.loadingText);
                                $(this).dequeue();
                            })
                            .animate({opacity: 1}, 150);
                        }
                    } else {
                        return false;
                    }
                }else if(action == "newText"){
                    if (allSize == visibleSize) {
                        if (stop == 0) {
                            self.option.loadButton.find("span.arc-load-text").animate({opacity: 0}, 150)
                                .queue(function () {
                                    $(this).text(self.option.noData);
                                    $(this).dequeue();
                                })
                                .animate({opacity: 1}, 150);
                        }
                    }
                }

            }
        },
        filterCategory: function(el, option, category,stop){
            var self = this;

            el.find(".arcfilter-item").each(function () {
                var categories = $(this).attr('data-categories').toLowerCase();

                if (category === 'all' || categories.indexOf(category) !== -1) {

                    $(this).removeClass('arc-item-hidden')
                            .fadeOut().finish().promise().done(function () {
                        $(this).addClass("arc-item-shown");
                    });

                } else {
                    $(this).addClass('arc-item-hidden')
                            .fadeOut().finish().promise().done(function () {
                        $(this).removeClass("arc-item-shown");
                    });
                }
                 
            });

            if(self.option.chooseLoad == "pagination"){
                if(stop == 1){
                    self.pagination(el,option,'set_height',stop);
                }else{
                    if(self.option.displayItems !== "all"){
                        var newParams = ["tcardArc_category","tcardArc_page"]
                        history.pushState(null, null, self.params(el,option,newParams,1));
                    }
                    self.pagination(el,option,'menuLink',stop);
                }
                
            }else{
               self.animateCategory(el,option,category,stop);
               if(self.option.type == "hidden"){
                    el.find(".arc-item-shown:visible").addClass("is_loaded");
               }
            }
    
            if(stop == 1){
                self.option.filterNav.each(function(){
                    var categoryAttr = $(this).attr("data-category").toLowerCase(),loadedItems;
                    loadedItems = el.find(".arc-item-shown:visible").filter('[data-categories ~= "' + categoryAttr + '"]');
                    if(loadedItems.length){
                        $(this).filter('[data-category ~= "' + categoryAttr + '"]').attr("data-loaded",loadedItems.length);
                    }else{
                        $(this).filter('[data-category ~= "' + categoryAttr + '"]').attr("data-loaded",0);
                    }
                });
            }
        },
        pagination: function(el,option,action,stop){
            var self = this,
                page = el.closest(".arcfilter-group").find(".arc-page"),
                categoryActive = self.option.filterNav.filter(".arc-filter-cl").attr('data-category'),
                allItems = Math.ceil(parseInt(self.option.filterNav.filter(".arc-filter-cl").attr('data-items')) / self.option.displayItems),
                count = 0,
                newParams = ["tcardArc_category","tcardArc_page"];

            if(action == "set_height"){
                self.animateItems(el,option,'pagination',el.find(".arc-item-shown"),stop);
                var pageIndex;

                if(self.option.displayItems == "all"){
                    pageIndex = 1;
                }else{
                    pageIndex = self.option.page;
                }

                self.count_pages(pageIndex,el,option);
            }
            else if(action == "menuLink"){
                self.get_items(null,null,1,el,option); 
            }
            else if(action == "pageLink"){
                var stopPage = false;
                    
                page.on("click",function(){
                    if(!$(this).hasClass("active-page")){
                        page.removeClass("active-page");
                        $(this).addClass("active-page");
                        categoryActive = self.option.filterNav.filter(".arc-filter-cl").attr('data-category');
                        if(self.option.displayItems !== "all"){

                            history.pushState(null, null, self.params(el,option,newParams,null));
                        }
                        self.get_items(null,null,$(this).attr('data-page'),el,option); 
                        count = $(this).index();  
                    }
                });

                count = page.filter('[data-page='+(self.option.page)+']').index();

                $(".arc-arrow_pagination").on("click",function(){
                    
                    if(stopPage) return;

                    count = parseInt(page.filter(".active-page").attr('data-page')) - 1;

                    if($(this).hasClass('arc-arrow-prev')){
                        if(count > 0){
                            count--;
                            pages(count);
                        }
                    }else{

                        if(count < page.filter(":visible").length - 1){
                            count++;
                            pages(count);
                        }
                    }  
                });

                function pages(count){
                    page.eq(count).each(function(){
                        if(!$(this).hasClass("active-page")){
                            page.removeClass("active-page");
                            $(this).addClass("active-page");
                            categoryActive = self.option.filterNav.filter(".arc-filter-cl").attr('data-category');
                            if(self.option.displayItems !== "all"){
                                history.pushState(null, null, self.params(el,option,newParams,null));
                            }
                            self.get_items(null,null,$(this).attr('data-page'),el,option);  
                        }
                    });
                }
            }
        },
        get_items: function(type,parent,page,el,option){

            var self = this,            
                allvisible = [],
                page = parseInt(page) - 1,data;
                

            if(type == null){
                el.find(".arcfilter-item:visible").each(function(){
                    allvisible.push($(this).attr("data-number"));
                });
            } 

            var sidebar = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar"),checked;

            if(sidebar.length){
                var min = self.price(el,option)["min"],
                    max = self.price(el,option)['max'],
                    tags = self.tags("get",el,option),
                    attrs = self.attributes("send",parent,el,option);
                    data = {
                        action: 'arcfilter_load_items',
                        security: arcfilter_ajax.arcfilter_load_items,
                        tcardArc_category: self.option.filterNav.filter(".arc-filter-cl").attr("data-category"),
                        start_page: page,
                        min_price: min,
                        max_price: max,
                        tags: tags,
                        attributes: attrs,
                        pageurl: arcfilter_ajax.pageurl,
                        all_items: allvisible,
                        group_id: el.closest(".arcfilter-group").attr("data-group-id")
                    };
            }else{

                data = {
                    action: 'arcfilter_load_items',
                    security: arcfilter_ajax.arcfilter_load_items,
                    tcardArc_category: self.option.filterNav.filter(".arc-filter-cl").attr("data-category"),
                    start_page: page,
                    pageurl: arcfilter_ajax.pageurl,
                    all_items: allvisible,
                    group_id: el.closest(".arcfilter-group").attr("data-group-id")
                };
            }

            el.find(".arcfilter-item").remove();
            el.closest(".arcfilter-group").find(".arcfilter_loader").css("visibility",'visible');

            $.ajax({
                url: arcfilter_ajax.ajaxurl,
                type: 'POST',
                data: data,
                success:function(data){

                    el.find(".row").html($(data).css("display",'none').addClass("arc-item-shown"));
                    var count_img = 0;
                    
                    if(el.find(".arc-item-shown").find("img[src !='']").length){
                        el.find(".arc-item-shown").find("img[src !='']").on("load",function(){
                            count_img++;
                            if(count_img == el.find(".arc-item-shown").find("img[src !='']").length){
                                self.animateItems(el,option,'pagination',el.find(".arc-item-shown"),stop);
                            }  
                        });
                    }else{
                        self.animateItems(el,option,'pagination',el.find(".arc-item-shown"),stop);   
                    }

                    self.count_pages((page + 1),el,option);

                    if(sidebar.length){
                        checked = JSON.stringify(self.attributes("get",parent,el,option));

                        sidebar.find(".arc-wc-attributes").filter("[data-wc-attr="+parent+"]")
                        .find(".arc_btn_filter_items").attr("data-attributes",checked);

                        checked = JSON.stringify(self.tags("get",el,option));

                        sidebar.find(".arc-wc-tags .arc_btn_filter_items").attr("data-tags",checked);

                        if(sidebar.find(".arc-wc-price").hasClass("slider")){
                            sidebar.find(".arc-wc-price #arc-slider-range").slider( "option", "values", [ min, max ] );  
                        }else{
                            sidebar.find(".arc_price_values").attr("data-start",min)
                            sidebar.find(".arc_price_values").attr("data-stop",max)
                        }
                    }

                    el.closest(".arcfilter-group").find(".arcfilter_loader").css("visibility",'hidden');
                },
                error: function(error){
                    console.log("Items can not be loaded!!")
                }
            });
        },
        count_pages: function(page,el,option){
            var self = this,
                activePage = el.closest(".arcfilter-group").find(".arc-page"),
                categoryActive = self.option.filterNav.filter(".arc-filter-cl").attr('data-category'),allItems,
                data_count = parseInt(el.find(".arcfilter-item").eq(0).attr('data-count')),
                data_items = parseInt(self.option.filterNav.filter(".arc-filter-cl").attr('data-items'));

            if(el.hasClass("arc_woocommerce")){
                allItems = Math.ceil(data_count / self.option.displayItems);

                if(data_count > data_items){
                    allItems = Math.ceil(data_items / self.option.displayItems);
                }
                
            }else{
                allItems = Math.ceil(data_items / self.option.displayItems);
            }
          
            activePage.removeClass("active-page");
            activePage.filter('[data-page='+page+']').addClass('active-page');

            if(allItems == 0){
                allItems = 1;
            }
          
            if(allItems > 0){
                if(allItems < activePage.filter(":visible").length){
                    activePage.eq(allItems - 1).nextAll().fadeOut(100);  
                }else{
                    if(categoryActive == "all"){
                        if(allItems == activePage.length){
                            activePage.fadeIn(100);
                        }else{
                            activePage.eq(allItems - 1).nextAll().fadeOut(100);
                        }
                    }else{
                        for (var i = 0; i < allItems; i++) {
                            activePage.eq(i).fadeIn(100);
                        }
                    }
                }
            }
        },
        params: function(el,option,newParams,live){

            var self = this;

            function getQueryVariable(param) {
                var query = window.location.search.substring(1);
                var vars = query.split("&"),all_params = {};
               
                for (var i=0;i<vars.length;i++) {
                    var pair = vars[i].split("=");
               
                    if(pair[0] == param){
                        all_params[pair[0]] = pair[1];
                    }
                }
                return all_params;
            }

            var params = {},get_variable = [],
            categoryActive = self.option.filterNav.filter(".arc-filter-cl").attr('data-category'),
            paramsUrl = [],activePage;

            for (var i = 0; i < self.option.use_param.length; i++) {
                paramsUrl.push(self.option.use_param[i]);
            }
      
            var attributes = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-attributes");

            if(live == 1){
                activePage = live;
            }else{
                activePage = el.closest(".arcfilter-group").find(".arc-page.active-page").attr("data-page");
            }

            for (var i = 0; i < paramsUrl.length; i++) {
                get_variable[i] = getQueryVariable(paramsUrl[i]);
                if(get_variable[i][paramsUrl[i]] !== undefined){
                    switchParam(Object.keys(get_variable[i])[0]);

                }
                else{
                    for (var j = 0; j < newParams.length; j++) {
                        if(newParams[j] == paramsUrl[i]){
                           switchParam(newParams[j]);
                        }
                    }
                }
            }

            function switchParam(param){
                switch(param) {
                    case "tcardArc_category":

                        params[param] = categoryActive;  
                        break;

                    case "tcardArc_page":

                        params[param] = activePage; 
                        break;

                    case "min_price":

                        if(self.price(el,option)['min'] > 0){
                           params[param] = self.price(el,option)['min'];   
                        }
                        break;

                    case "max_price":

                        if(self.price(el,option)['max'] > 0){
                          params[param] = self.price(el,option)['max'];  
                        }
                        break;

                    case "tags":

                        if(self.tags(null,el,option).length){
                          params[param] = self.tags(null,el,option);    
                        }
                        break;
                     case param:

                        if(self.attributes(null,param,el,option).length){
                          params[param] = self.attributes(null,param,el,option);    
                        }

                        break;
                }
            }
   
            var urlSearch = "?" + jQuery.param( params );
            return urlSearch;
        },
        compare: function(arr_checked,data_arr){
            if (JSON.stringify(arr_checked.sort()) === JSON.stringify(data_arr.sort())) {
                return true;
            }else{
                return false;
            }
        },
        price: function(el,option){

            var self = this;

            var price = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-price"),price_type,min,max;
            if(price.length){

                if(price.hasClass("slider")){
                    price_type = price.find("#arc-slider-range");
                    min = price_type.attr("data-start")
                    max = price_type.attr("data-stop")
                }else{
                    price_type = price.find(".arc_price_values");
                    min = price_type.attr("data-start");
                    max = price_type.attr("data-stop");
                    price_type.find("input").each(function(){
                        if($(this).parent().hasClass("arc_min_value")){
                            if(min !== $(this).val()){
                                min = $(this).val();
                            }
                        }else{
                            if(max !== $(this).val()){
                                max = $(this).val();
                            }
                        }
                    });
                }
                min = parseInt(min);
                max = parseInt(max);
            }else{
                min = "";
                max = "";
            }

            return price = {
                min: min,
                max: max
            }
        },
        tags: function(type,el,option){

            var self = this,
                tags = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-tags"),all_tags = [],str_tags;

            tags.find(".arc-wc-tag").filter(".checked_tag").each(function(){
                all_tags.push($(this).attr("data-tag"));
            });

            if(type == "get"){
                return all_tags;
            }else{

                str_tags = all_tags.join(" ");

                return str_tags;
            }

        },
        attributes: function(type,param,el,option){
             var self = this,
                attributes = el.closest(".arcfilter-group").find(".arcfilter-menu.arc-nav-sidebar .arc-wc-attributes"),
                all_attr = {},str_attr,attrs = [];

            if(Array.isArray(parent)){
                parent = parent[0];
            }  

     
            attributes.filter("[data-wc-attr="+param+"]").find(".arc-wc-attr.arc_check_attr").each(function(){
                attrs.push($(this).attr("data-attr"));
                
            });

            if(type == "send"){
                attributes.each(function(){

                    var thisAttr = $(this).attr("data-wc-attr");

                    $(this).find(".arc-wc-attr.arc_check_attr").each(function(){
                        if(!attrs[thisAttr]){
                          attrs[thisAttr] = $(this).attr("data-attr")
                        }else{
                          attrs[thisAttr] +=  "," + $(this).attr("data-attr")
                        }
                    });
                    if(attrs[thisAttr]){
                        all_attr[thisAttr] = attrs[thisAttr].split(",")  
                    }
                });
            }

            if(type == "get"){
                return attrs;
            }
            else if(type == "send"){
                return JSON.stringify(all_attr);
            }
            else{
                str_attr = attrs.join(" ");
                return str_attr;
            }
        },
        animateItems: function(el,option,action,hiddenItem,stop){
            var self = this,
                randomizer,
                animations = self.option.animations.length - 0.5;

            if (self.option.random === false) {
                randomizer = 0;
            } else if (self.option.random === true) {
                randomizer = Math.round(Math.random() * animations);
            }

            if(Array.isArray(self.option.animations)){
                var set_animation = self.option.animations[randomizer];
                if (self.option.random === false || self.option.random === true) {
                    for (var i = 0; i < self.option.animations.length; i++) {
                        el.find(".arc-item-hidden").removeClass(self.option.animations[i]);
                        hiddenItem.removeClass(self.option.animations[i]);
                    }
                }
            }else{
                set_animation = self.option.animations;
                el.find(".arc-item-hidden").removeClass(set_animation);
                hiddenItem.removeClass(set_animation);
            }

            if(action == "load"){
                if(self.option.type == "hidden"){
                    var allItemsL = parseInt(self.option.filterNav.filter("[data-category ~='all']").attr('data-loaded'));
                    hiddenItem.each(function(i){
                        el.find(".arcfilter-item:eq(" +$(this).index()+ ")").insertBefore(el.find(".arcfilter-item:eq(" +(allItemsL + i)+ ")"));
                    })
                }
            }

            hiddenItem.css("display",'block');

            if(hiddenItem.find(".tcard").length && self.option.type == "ajax"){
                var activeCat = self.option.filterNav.filter(".arc-filter-cl").attr("data-tcard");

                var newSkins = hiddenItem.find(".tcard").filter("."+activeCat);
                var allCat = [];
                self.option.filterNav.each(function(){
                    var data_tcard = $(this).attr("data-tcard");
                    if(data_tcard !== "all"){
                        allCat.push(data_tcard);
                    }

                });

                function get_all_cat(category) {
                  function removeDuplicate(value, index, self) { 
                    return self.indexOf(value)===index;
                  }

                  var uniqueCat = category.filter(removeDuplicate);
                  return uniqueCat;
                }
                
                for (var i = 0; i < get_all_cat(allCat).length; i++) {
                  hiddenItem.find("."+get_all_cat(allCat)[i]).tcard(self.option.tcard_set[get_all_cat(allCat)[i]]);
                }
            }else if(hiddenItem.find(".tcard").length && self.option.type == "hidden" && self.option.chooseLoad == "button" || self.option.chooseLoad == "scroll"){
                hiddenItem.find(".tcard .tcard-slider").each(function(){
                    var slider = $(this),
                    container = slider.find(".tcs-inner"),
                    paddingSlider = slider.outerHeight() - slider.height(),
                    item = slider.find(".tcs-item"),
                    itemActive = item.filter(".active").index(),
                    numberItem = 1;

                    slider.css({
                        height: item.eq(itemActive).outerHeight() + paddingSlider
                    });

                    item.css("width", slider.outerWidth() / numberItem);
                    containerWidth = (item.length + 1) * slider.outerWidth();
                    
                    container.css("width", containerWidth);
                });                
            }
    
            if(action == "load"){
                self.resizeContainer(el, option, "oldHeight");
            }else{
                if(stop == 0){
                    self.resizeContainer(el, option, "oldHeight");
                }else{
                    self.resizeContainer(el, option, "statikHeight");
                }
            }

            hiddenItem.each(function (i) {
                if (self.option.random === false || self.option.random === true) {
                    $(this).addClass(set_animation)
                    .css('animation-delay', (self.option.delayAnimation * i) + 'ms');
                }
            });
        },
        animateCategory: function(el,option,category,stop){
            var self = this,
                randomizer,
                animations = self.option.animations.length - 0.5;

            if (self.option.random === false) {
                randomizer = 0;
            } else if (self.option.random === true) {
                randomizer = Math.round(Math.random() * animations);
            }

            var displayItems;

            if (self.option.displayItems == "all") {
                displayItems = el.find(".arc-item-shown");
            } 
            else if(self.option.filterNav.filter(".arc-filter-cl").attr("data-loaded") !== undefined){
                displayItems = el.find(".arc-item-shown" + ':lt(' + self.option.filterNav.filter(".arc-filter-cl").attr("data-loaded") + ')');
            }
            else {
                displayItems = el.find(".arc-item-shown" + ':lt(' + self.option.displayItems + ')');
            }

            if(Array.isArray(self.option.animations)){
                var set_animation = self.option.animations[randomizer];
                if (self.option.random === false || self.option.random === true) {
                    for (var i = 0; i < self.option.animations.length; i++) {
                        el.find(".arc-item-hidden").removeClass(self.option.animations[i]);
                        displayItems.removeClass(self.option.animations[i]);
                    }
                }
            }else{
                set_animation = self.option.animations;
                el.find(".arc-item-hidden").removeClass(set_animation);
                displayItems.removeClass(set_animation);
            }
       
            displayItems.css("display",'block');

            if(displayItems.find(".tcard .tcard-slider").length){
                displayItems.find(".tcard .tcard-slider").each(function(){
                    var slider = $(this),
                    container = slider.find(".tcs-inner"),
                    paddingSlider = slider.outerHeight() - slider.height(),
                    item = slider.find(".tcs-item"),
                    itemActive = item.filter(".active").index(),
                    numberItem = 1;

                    slider.css({
                        height: item.eq(itemActive).outerHeight() + paddingSlider
                    });

                    item.css("width", slider.outerWidth() / numberItem);
                    containerWidth = (item.length + 1) * slider.outerWidth();
                    
                    container.css("width", containerWidth);
                });
            }
            
            if (stop === 1) {
                self.resizeContainer(el, option, "statikHeight");
            } else {
                self.resizeContainer(el, option, "oldHeight");
            }

            displayItems.each(function (i) {
                if (self.option.random === false || self.option.random === true) {
                    $(this).addClass(set_animation)
                    .css('animation-delay', (self.option.delayAnimation * i) + 'ms');
                }
            });
        },
        resizeContainer: function(el,option,action){
            var self = this,
                displaySize,lastItem,padding,diff;
                padding = el.innerWidth() - el.width();

            self.orderItems(el,option,el.find(".arc-item-shown:visible"),"new");

            var containerHeight = itemsHeight();    

            function statikHeight() {
                el.css("height", containerHeight);
            }

            function newHeight() {
                el.stop().animate({
                    height: containerHeight
                }, self.option.speed);
            }

            var resizeTimer;

            $(window).on('resize',function(){
                var item = el.find(".arc-item-shown:visible");
                self.orderItems(el,option,item,"resize");
                containerHeight = itemsHeight(); 

                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    var item = el.find(".arc-item-shown:visible");
                    self.orderItems(el,option,item,"resize");
                    containerHeight = itemsHeight();
                    newHeight(); 
                }, 350);
            });

            if (action === "statikHeight") {
                statikHeight();
                $(window).resize(newHeight);
            }
             else if (action === "newHeight" || action === "oldHeight") {
                newHeight();
                $(window).resize(newHeight);
            }

            function itemsHeight(){

                lastItem = el.find(".arc-item-shown:visible").last();
                 
                if(lastItem.length){
                    displaySize = (lastItem.offset().top - el.offset().top) + lastItem.outerHeight() ;  
                }else{
                    displaySize = 200;
                }
             
                var newHeightVal = [];
         
                el.find(".arc-item-shown:visible").each(function(){
                   newHeightVal.push(Math.round(($(this).offset().top - el.offset().top) + $(this).outerHeight()));  
                });

                newHeightVal.sort(function(a,b){
                    return b - a;
                });

                if(displaySize < newHeightVal[0]){
                    displaySize = Math.round(newHeightVal[0]);
                }

                displaySize = Math.round(displaySize);
                return displaySize;
            }

            if (self.option.counter === "shown") {
                self.countCategory(el,option,"shown");
            } else if (self.option.counter === "onhover") {
                self.countCategory(el,option,"onhover");
            } else if (self.option.counter === false) {
                self.countCategory(el,option,"false");
            }
                        
        },
        orderItems(el,option,item,type){
            var self = this;

            Array.prototype.min = function(){ return Math.min.apply({},this) };

            if(item.length){

                var itemWidth = item.outerWidth();
        
                var colCount = Math.round( el.width() / itemWidth ) ;
         
                var itemsHeight = new Array();
                for (var i=0; i < colCount; i++) {
                    itemsHeight[ i ] =  0 ;
                }

                item.css({
                    "position": "absolute",
                    "display": "block"
                })
                .each(function(){
                    for (var i=colCount-1; i > -1; i-- ) {
                        if ( itemsHeight[ i ] == itemsHeight.min() ) {
                            var thisItem = i;
                        }
                    }
                    if(type == "new"){
                        $(this).css({
                            top: itemsHeight[ thisItem ],
                            left: itemWidth * thisItem
                        });
                    }
                    else if(type == "resize"){
                        $(this).stop().animate({
                            top: itemsHeight[ thisItem ],
                            left: itemWidth * thisItem
                        },350);
                    }
                    itemsHeight[ thisItem ] += $(this).outerHeight(true);
                });
           
            }
        },
        countCategory: function(el,option,action){
            var self = this;

            function initCount(nav) {
                nav.each(function () {
                    var category = $(this).attr('data-category').toLowerCase();
                    var countSize;
   
                    if(self.option.type == "ajax"){
                        countSize = $(this).attr('data-items');
                    }else{
                        if (category == 'all') {
                            el.find(".arcfilter-item").each(function () {
                                $(this).attr("all", '');
                            });
                            countSize = el.find("[all='']").length;
                        } else {
                            countSize = el.find(".arcfilter-item").filter('[data-categories ~= "' + category + '"]').length;
                        }
                    }
                    
                    if (self.option.counter === "shown") {
                        $(this).find(".arc-filter-counter").html('(' + countSize + ')');
                    } else if (self.option.counter === "onhover") {
                        if($(window).width() > 991 && !$(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                            if(!$(this).find(".sub-items-counter").length){
                                $(this).find(".arc-filter-counter").html(countSize);
                            }
                        }else if($(window).width() > 991 && $(this).closest(".arcfilter-menu").hasClass("arc-nav-sidebar")){
                            $(this).find(".arc-filter-counter").html('(' + countSize + ')');  
                        }
                        else{
                            $(this).find(".arc-filter-counter").html('(' + countSize + ')');  
                        }
                    }
                });
            }

            self.option.filterNav.find(".sub-items-counter").each(function(){
                
                var category = $(this).parent().attr('data-category').toLowerCase();
                var countSize;

                if(self.option.type == "ajax"){
                    countSize = $(this).parent().attr('data-items');
                }else{
                    if (category == 'all') {
                        el.find(".arcfilter-item").each(function () {
                            $(this).attr("all", '');
                        });
                        countSize = el.find("[all='']").length;
                    } else {
                        countSize = el.find(".arcfilter-item").filter('[data-categories ~= "' + category + '"]').length;
                    }
                }

                $(this).html('(' + countSize + ')');
                               
            });

            if (action === "shown") {
                self.option.filterNav.each(function () {
                    var nav = $(this);
                    initCount(nav);
                })
            } else if (action === "onhover") {
                if($(window).width() > 991){
                    self.option.filterNav.on({
                        mouseenter: function () {
                            var nav = $(this);
                            initCount(nav);
                            $(this).addClass("arc-counter-active");
                        }, mouseleave: function () {
                            self.option.filterNav.removeClass("arc-counter-active");
                        }
                    });
                }
                else{
                    self.option.filterNav.each(function () {
                        var nav = $(this);
                        initCount(nav);
                    })
                }
            } else if (action === "false") {
                self.option.filterNav.on({
                    mouseenter: function () {
                        self.option.filterNav.removeClass("arc-counter-active");
                    }
                });
            }
        }
    };

    $.fn.arcfilter = function (option) {
        var instance = $.data(this, 'arcfilter');
        if (instance === undefined) {
            option = option || {};
            $.data(this, 'arcfilter', new arcfilter(this, option));
            return this;
        }

        if ($.isFunction(arcfilter.prototype[option])) {
            var args = Array.prototype.slice.call(arguments);
            args.shift();
            return arcfilter.prototype[option].apply(instance, args);
        } else if (option) {
            $.error('Method ' + option + ' does not exist on arcfilter');
        }
        return this;
    };

})(jQuery);