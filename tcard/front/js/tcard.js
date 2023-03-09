/* 
 Author: Cloanta Alexandru
 Name: Tcard Wordpress
 Version: 2.9.1
*/

(function ($) {

    'use strict';

    function tcard(el, option) {
        var self = this;
        el = $(el);
        var defaults = {
            tcardFlip: false,
            tcardOn: "button",
            animationFront: "ready",
            animationOneTime: false,
            randomColor: false,
            durationCount: 900,
            individualGallery: false,
            autocomplete: "off",
            frontButton: $(".tcard-button.front"),
            backButton: $(".tcard-button.back"),
            tcardFront: $(".tcard-front"),
            tcardBack: $(".tcard-back"),
            tcardInner: $(".tcard-inner"),
            tcg: $(".tcg"),
            tcgItem: $(".tcg-item"),
            callBack: function () {
            },
            onBack: function () {

            },
            onFront: function () {

            }
        };
        
        self.option = $.extend(true, defaults, option);

        self.init(el, option);

        if (typeof self.option.callBack === 'function') {
            self.option.callBack.call(self,self.option);
        }
    }

    tcard.prototype = {
        init: function (el, option) {
            var self = this;

            set_height();

            $(document).ready(function(){
                set_height()
            });

            function set_height(){
                el.each(function(){
                    var tcardFront = $(this).find(self.option.tcardFront);
                    var tcardBack = $(this).find(self.option.tcardBack);

                    if(tcardFront.outerHeight() > tcardBack.outerHeight()){
                        tcardFront.css("position","relative");
                        tcardBack.css("position","absolute");
                    }else if(tcardFront.outerHeight() < tcardBack.outerHeight()){
                        tcardBack.css("position","relative");
                        tcardFront.css("position","absolute");
                    }
                });
            }

            var widget_group = el.closest(".tcard-widget-group"),
                widget_skin = el.closest(".tcard-widget-skin");
            if(widget_group.length){
                widget_group.find("[class *= 'col-']").each(function(){
                    $(this).removeClass($(this)[0].className).addClass("widget_container")
                });
            }else if(widget_skin.length){
               widget_skin.find("[class *= 'col-']").each(function(){
                    $(this).removeClass($(this)[0].className).addClass("widget_container")
                }); 
            }

            el.find($("*[data-animationIn]")).css("opacity", "0");
            if (el.filter("*[data-view-in]").length) {
                self.checkTcardView(el, option);
            } else {
                setAnimationMode(self.option.tcardOn, self.option.animationFront, el.find(self.option.tcardFront));
            }

            if (self.option.tcardOn == "button") {
                if (self.option.tcardFlip == false) {

                    self.option.frontButton.on("click touchstart", function (e) {
                        el.filter(".flipped,.rotate-in").find(self.option.tcardBack).each(function(){
                            e.preventDefault();
                            e.stopPropagation();
                            if($(this).hasClass("z-up")){
                                self.animateElem($(this), "front", el, option);
                            }
                        });

                        self.animateElem($(this), "back", el, option);
                    });
                }
                self.option.backButton.on("click touchstart", function (e) {
                    self.animateElem($(this), "front", el, option);
                });
            } else if (self.option.tcardOn == "hover") {
                if (self.option.tcardFlip == false) {
                    el.find(self.option.tcardFront).on("mouseenter touchmove", function (e) {
                        el.filter(".flipped,.rotate-in").find(self.option.tcardBack).each(function(){
                            if($(this).hasClass("z-up")){
                                self.animateElem($(this), "front", el, option);
                            }
                        });
                        
                        if(!$(this).closest(el).find(self.option.tcardBack).hasClass("z-up")){
                           self.animateElem($(this), "back", el, option);
                        }
                        
                    });
                }
                el.find(self.option.tcardBack).on("mouseleave touchmove", function (e) {
                    if($(this).hasClass("z-up")){
                       self.animateElem($(this), "front", el, option);
                    }
                });
            }

            el.find(self.option.tcardFront).each(function () {
                self.tcardProgress($(this), "initProgress", el, option);
            });

            self.tcardSlider(el, option);
            self.tcardGallery(el, option);
            self.tcardEllipsis(el);
            self.tcardForm(el, option);
            self.tcardColor(el, option);
        },
        checkTcardView: function (el, option) {
            var self = this;
            setAnimationMode(self.option.tcardOn, self.option.animationFront, el.find(self.option.tcardFront));

            // Find tcard who has attr "data-view-in" and all 
            // item inside of tcard with "data-animationIn" and set opacity to 0
            el.filter("*[data-view-in]").each(function () {
                $(this).css({
                    "opacity": "0"
                }).find($("*[data-animationIn]")).css({
                    "opacity": "0"
                });
            });

            $(window).on('scroll resize', function () {
                var wh = $(window).height(),
                        wtp = $(window).scrollTop(),
                        wbp = (wtp + wh);    
                //  Filter tcard who has attr "data-view-in"  
                el.filter("*[data-view-in]").each(function () {

                    $(this).closest(".tcard-group").css("overflow","hidden");   

                    var animationEvent = animation(),
                            elh = $(this).outerHeight(),
                            eltp = $(this).parent().offset().top,
                            elbp = (eltp + elh),
                            setOffsetView = parseInt($(this).attr("data-offsetview"));
                    if ((elbp - setOffsetView >= wtp) && (eltp + setOffsetView <= wbp)) {
                        if (!$(this).hasClass($(this).attr("data-view-in"))) {
                            $(this).removeClass("animated" + " " + "" + $(this).attr("data-view-out") + "")
                                    .addClass("animated" + " " + "" + $(this).attr("data-view-in") + "")
                                    .css({
                                        "opacity": "1"
                                    })
                                    .one(animationEvent, function (event) {
                                        setAnimationMode(self.option.tcardOn, self.option.animationFront, el.find(self.option.tcardFront));
                                    });
                        }
                    } else {
                        if ($(this).hasClass($(this).attr("data-view-in")) && $(this).filter("*[data-view-out]").length) {
                            $(this).removeClass("animated" + " " + "" + $(this).attr("data-view-in") + "")
                                    .addClass("animated" + " " + "" + $(this).attr("data-view-out") + "");
                        }
                    }
                });
            });
        },
        //Animate what element has attr data-animationIn and data-animationOut
        animateElem: function (tcardBtn, action, el, option) {
            var self = this;
            var tcard = tcardBtn.closest(el),
                    animationEvent = animation(),
                    transitionEvent = transition(),
                    //  Find animation in/out for front and back 
                    currFrontIn = tcard.find(self.option.tcardFront).find($("*[data-animationIn]")),
                    currFrontOut = tcard.find(self.option.tcardFront).find($("*[data-animationOut]")),
                    currBackIn = tcard.find(self.option.tcardBack).find($("*[data-animationIn]")),
                    currBackOut = tcard.find(self.option.tcardBack).find($("*[data-animationOut]"));

            //  Set what action will be started when user click on tcard-button   
            //  or mouseover over tcard-front or tcard-back
            if (action === "back") {
                showBackFace();
            } else if (action === "front") {
                if (!tcard.find(".tcard-button-gallery").hasClass("is-clicked")) {
                    showFrontFace();
                }
            }

            function showBackFace() {
                if (!currFrontIn.length || !currFrontOut.length) {
                    addMainClassesRemove("showback");
                    if (self.option.animationOneTime == false) {
                        self.tcardProgress(tcard.find(self.option.tcardFront), "resetProgress", el, option);
                        addAnimationBack();
                    } else {
                        if (!currBackIn.hasClass(currBackIn.attr("data-animationIn"))) {
                            addAnimationBack();
                        }
                    }
                } else if (currFrontIn.length > 0 || currFrontOut.length > 0) {
                    if (self.option.animationOneTime == false) {
                        self.tcardProgress(tcard.find(self.option.tcardFront), "resetProgress", el, option);
                        animationOut(currFrontOut);
                        currFrontOut.last().one(animationEvent, function (event) {
                            addMainClassesRemove("showback");
                            addAnimationBack();
                        });
                    } else {
                        addMainClassesRemove("showback");
                        if (!currBackIn.hasClass(currBackIn.attr("data-animationIn"))) {
                            addAnimationBack();
                        }
                    }
                }

                function addAnimationBack() {
                    if (tcard.hasClass("flip-x") || tcard.hasClass("flip-y")) {
                        tcard.find(self.option.tcardInner).one(transitionEvent, function (event) {
                            if (typeof self.option.onBack === 'function') {
                                self.option.onBack.call();
                            }
                            animationIn(currBackIn);
                            self.tcardProgress(tcard.find(self.option.tcardBack), "initProgress", el, option);
                        });
                    } else if (tcard.hasClass("rotate-x") || tcard.hasClass("rotate-y")) {
                        tcard.find(self.option.tcardInner).one(animationEvent, function (event) {
                            if (self.option.animationOneTime == false) {
                                if (currFrontIn.length > 0 || currFrontOut.length > 0) {
                                    $(this).one(animationEvent, function (event) {
                                        if (typeof self.option.onBack === 'function') {
                                            self.option.onBack.call();
                                        }
                                        animationIn(currBackIn);
                                        self.tcardProgress(tcard.find(self.option.tcardBack), "initProgress", el, option);
                                    });
                                } else {
                                    if (typeof self.option.onBack === 'function') {
                                        self.option.onBack.call();
                                    }
                                    animationIn(currBackIn);
                                    self.tcardProgress(tcard.find(self.option.tcardBack), "initProgress", el, option);
                                }
                            } else {
                                if (typeof self.option.onBack === 'function') {
                                    self.option.onBack.call();
                                }
                                animationIn(currBackIn);
                                self.tcardProgress(tcard.find(self.option.tcardBack), "initProgress", el, option);
                            }
                        });
                    }
                }
            }

            function showFrontFace() {
                if (!currBackIn.length || !currBackOut.length) {
                    addMainClassesRemove("showface");
                    if (self.option.animationOneTime == false) {
                        self.tcardProgress(tcard.find(self.option.tcardBack), "resetProgress", el, option);
                        addAnimationFront();
                    }
                } else if (currBackIn.length > 0 || currBackOut.length > 0) {
                    if (self.option.animationOneTime == false) {
                        self.tcardProgress(tcard.find(self.option.tcardBack), "resetProgress", el, option);
                        animationOut(currBackOut);
                        currBackOut.last().one(animationEvent, function (event) {
                            addMainClassesRemove("showface");
                            addAnimationFront();
                        });
                    } else {
                        addMainClassesRemove("showface");
                    }
                }
                function addAnimationFront() {
                    if (tcard.hasClass("flip-x") || tcard.hasClass("flip-y")) {
                        tcard.find(self.option.tcardInner).one(transitionEvent, function (event) {
                            if (typeof self.option.onFront === 'function') {
                                self.option.onFront.call();
                            }
                            animationIn(currFrontIn);
                            self.tcardProgress(tcard.find(self.option.tcardFront), "initProgress", el, option);
                        });
                    } else if (tcard.hasClass("rotate-x") || tcard.hasClass("rotate-y")) {
                        tcard.find(self.option.tcardInner).one(animationEvent, function (event) {
                            if (currBackIn.length > 0 || currBackOut.length > 0) {
                                $(this).one(animationEvent, function (event) {
                                    if (typeof self.option.onFront === 'function') {
                                        self.option.onFront.call();
                                    }
                                    animationIn(currFrontIn);
                                    self.tcardProgress(tcard.find(self.option.tcardFront), "initProgress", el, option);
                                });
                            } else {
                                if (typeof self.option.onFront === 'function') {
                                    self.option.onFront.call();
                                }
                                animationIn(currFrontIn);
                                self.tcardProgress(tcard.find(self.option.tcardFront), "initProgress", el, option);
                            }
                        });
                    }
                }
            }

            //Add/Remove main animation for tcard-inner
            function addMainClassesRemove(action) {
                var mainClassIn;
                var mainClassOut;

                if (tcard.hasClass('flip-x') || tcard.hasClass('flip-y')) {
                    mainClassIn = "flipped";
                    mainClassOut = " ";
                } else if (tcard.hasClass('rotate-x') || tcard.hasClass('rotate-y')) {
                    mainClassIn = "rotate-in";
                    mainClassOut = "rotate-out";
                }

                if (action === "showback") {
                    tcard.removeClass(mainClassOut)
                            .addClass(mainClassIn)
                            .find(".tcard-back").addClass('z-up');
                } else if (action === "showface") {
                    tcard.removeClass(mainClassIn)
                            .addClass(mainClassOut)
                            .find(".tcard-back").removeClass('z-up');
                }
            }
        },
        tcardProgress: function (tcardBtn, action, el, option) {
            var self = this;
            var animationEvent = animation();
            var progress = tcardBtn.find(".tcard-skill-point");
            if (action === "initProgress") {
                initProgress();
            } else if (action === "resetProgress") {
                resetProgress();
            }

            function initProgress() {
                progress.each(function () {

                    //set properties if .tcard-skills has class bar
                    if ($(this).closest(".tcard-skills").hasClass("bar")) {
                        $(this).each(function (i) {
                            var thisItem = $(this);
                            var val = thisItem.attr("data-number");
                            if (val < 0) {
                                val = 0;
                            }
                            var widthVal = [];
                            widthVal[i] = val;
                            if(thisItem.closest(el).hasClass("skin_1")){
                                widthVal[i] = widthVal[i] / 10;
                            }
                            if(thisItem.closest(".skill-item").hasClass("animated")){
                                thisItem.closest(".skill-item").one(animationEvent, function (event) {
                                    thisItem.find(".tcard-bar").css({
                                        'width': widthVal[i] + '%'
                                    });
                                    countNum(thisItem, val);
                                });
                            }else{
                                thisItem.find(".tcard-bar").css({
                                    'width': widthVal[i] + '%'
                                });
                                countNum(thisItem, val);
                            }
                        });

                        //set properties if .tcard-skills has class circle
                    } else if ($(this).closest(".tcard-skills").hasClass("circle")) {
                        $(this).each(function () {
                            var thisItem = $(this);
                            var val = thisItem.attr("data-number");
                            thisItem.find($(".circle-progress")).each(function () {
                                var circle = $(this);
                                var r = circle.attr("r"),
                                        c = Math.PI * (r * 2);
                                if (val < 0) {
                                    val = 0;
                                }

                                //animate strokeDashoffset for circle-progress
                                //depending on the value
                                if(thisItem.closest(".skill-item").hasClass("animated")){
                                    thisItem.closest(".skill-item").one(animationEvent, function (event) {
                                        circle.css({
                                            strokeDashoffset: ((100 - val) / 100) * c
                                        });
                                    });
                                }else{
                                    circle.css({
                                        strokeDashoffset: ((100 - val) / 100) * c
                                    });
                                }
                            });
                            if(thisItem.closest(".skill-item").hasClass("animated")){
                                thisItem.closest(".skill-item").one(animationEvent, function (event) {
                                      countNum(thisItem, val);
                                });
                            }else{
                                countNum(thisItem, val);
                            }
                        });
                    } else {

                        //Normal count
                        $(this).each(function () {
                            var val = $(this).attr("data-number");
                            var text_value = $(this).find(".count").text();
                            if (!text_value || text_value == 0) {
                                countNum($(this), val);
                            }
                        });
                    }
                });
            }

            //When front side is shown, reset progress and countNum functions
            function resetProgress() {
                progress.each(function () {
                    $(this).find(".tcard-bar").css({
                        'width': 0
                    });
                    $(this).find($(".circle-progress")).each(function () {
                        var r = $(this).attr("r"),
                                c = Math.round(Math.PI * (r * 2) - 1);
                        $(this).css({
                            strokeDashoffset: c
                        });
                    });
                    countNum($(this), 0);
                });
            }

            function countNum($this, val) {

                var props;

                $this.find(".count").each(function (i, el) {
                    props = {
                        "count": val
                    };
                    $(this).animate(props, {
                        duration: self.option.durationCount,
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });

                });
            }
        },
        tcardGallery: function (el, option) {
            var self = this;

            $(".tcg-toggle-sidebar").on("click", function () {
                $(this).toggleClass("is-open");

                var thumbnailBar =  $(this).closest(".tcg-group").find(".tcg-sidebar")

                thumbnailBar.toggleClass("is-open"); 
            });
            
            el.find(".tcard-button-gallery").on("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass("is-clicked");
                var tcgGroupLink = $(this).attr("data-tcg");
                var userList = $("*[data-tcg='" + tcgGroupLink + "']").closest(el).find("*[data-user-thumbnail]");

                var tcgChildLink = $(this).attr("data-open-tcg");
                var group = $("*[data-tcg-group='" + tcgGroupLink + "']");

                group.fadeIn(0).addClass("is-open");

                if (self.option.individualGallery == false) {

                    var thumUser = group.find(".tcg-user");
                    thumUser.filter("*[data-tcg-user='" + tcgChildLink + "']").addClass("user-activ");
                    thumUser.on("click", function () {
                        var userLink = $(this).attr("data-tcg-user");
                        var currGallery = group.find("*[data-tcg-open='" + userLink + "']");
                        if (!$(this).hasClass("user-activ")) {
                            thumUser.removeClass("user-activ");
                            $(this).addClass("user-activ");

                            group.find(self.option.tcg).removeClass("is-open").fadeOut()
                                    .find(self.option.tcgItem).removeClass("current previous").fadeOut();

                            var curPage = 0;

                            var headerBtn = 
                            '<div class="tcg-header-btn bar"><p class="tcg-upload-images">Upload Images</p></div>' +
                            '<div class="tcg-header-btn"><p class="tcg-delete-image">Delete Image</p></div>';

                            if(!currGallery.attr('data-user-log')){
                                group.find(".tcg-header-btn").remove();
                            }else{
                                if(!group.find(".tcg-header-btn").length){
                                    group.find(".tcg-header").append(headerBtn);
                                }
                            }

                            tcgSlider(currGallery, curPage); 
                            
                            currGallery.fadeIn(0).addClass("is-open");
                            currGallery.find(self.option.tcgItem).first().fadeIn(0).addClass("current");
                            group.find(".tcg-counter-all").html(currGallery.find(".tcg-item").length);
                        }

                        return false;
                    });
                }

                var tcgChild = group.find("*[data-tcg-open='" + tcgChildLink + "']");
                var curPage = 0;

                var headerBtn = 
                '<div class="tcg-header-btn bar"><p class="tcg-upload-images">Upload Images</p></div>' +
                '<div class="tcg-header-btn"><p class="tcg-delete-image">Delete Image</p></div>';

                if(!tcgChild.attr('data-user-log')){
                    group.find(".tcg-header-btn").remove();
                }else{
                    if(!group.find(".tcg-header-btn").length){
                        group.find(".tcg-header").append(headerBtn);
                    }
                }

                tcgSlider(tcgChild, curPage); 

                tcgChild.fadeIn(0).addClass("is-open")
                        .find(self.option.tcgItem).first().fadeIn(0).addClass("current");

                group.find(".tcg-close").on("click", function () {

                    group.removeClass("is-open").fadeOut()
                    .find(".tcg-sidebar").removeClass("is-open")
                        .find(".tcg-user").removeClass("user-activ");

                    group.find(".tcg-toggle-sidebar").removeClass("is-open")
                        
                    group.find(self.option.tcg).removeClass("is-open").fadeOut()
                            .find(self.option.tcgItem).removeClass("current previous").fadeOut();

                    el.find("*[data-open-tcg]").removeClass("is-clicked");

                });
                    
            });
            
            $(document).on('click','.tcg-upload-images', function( event ) {

                el.closest(".tcard-group").find( $(this) ).each(function(){
                    event.preventDefault();

                    var frame,thisBtn,tcg;
                    thisBtn = el.closest(".tcard-group").find( $(this) );
                    tcg = thisBtn.closest(".tcg-group").find(".tcg.is-open");

                    if ( frame ) {
                      frame.open();
                      return;
                    }
                    
                    // Create a new media frame
                    frame = wp.media({
                        title : 'Upload Images',
                        multiple : true,
                        library : { type : 'image' },
                        button : { text : 'Insert into gallery' }
                    });


                    frame.on( 'select', function() {

                        var attachment = frame.state().get('selection').toJSON(),img,user_images_url = [],newImages = [];

                        for (var i = 0; i < attachment.length; i++) {
                            img = "<img class='tcg-item' src='"+attachment[i].url+"' alt='"+attachment[i].alt+"'>";
                            tcg.find(".tcg-arrow").first().before($(img).appendTo(tcg));
                        }

                        for (var i = 0; i < tcg.find(".tcg-item").length; i++) {
                           user_images_url[i] = tcg.find(".tcg-item").eq(i).attr("src");
                        }

                        if(!tcg.find(".tcg-item").hasClass("current")){
                            tcg.find(".tcg-item").first().addClass("current").fadeIn(0);    
                        }
                        
                        tcg.closest(".tcg-group").find(".tcg-counter-all").html(tcg.find(".tcg-item").length);
                        if(tcg.find(".tcg-item").length){
                            tcg.closest(".tcg-group").find(".tcg-current-counter").html(1);
                        }
                        if(attachment.length){
                            var data = {
                              action: 'tcard_user_images',
                              security: tcard_front.tcard_user_images,
                              skin_id: tcg.attr("data-tcg-skin_id"),
                              tc_user_images: user_images_url,
                              gallery_type: tcg.attr('data-tcg-type'),
                              thumbnail: tcg.attr('data-thumbnail'),
                              thumbnail_title: tcg.attr('data-title')
                            };

                            $.ajax({
                                url: tcard_front.ajaxurl,
                                type: 'POST',
                                data: data,
                                success:function(data){
                                    alert("Images saved!");
                                    var tcgUser = tcg.closest(".tcg-group").find(".tcg-sidebar").find(".tcg-user");
                                    tcgUser.each(function(){

                                        var thisUser = $(this);

                                        if(thisUser.attr("data-tcg-user").indexOf(tcg.attr("data-tcg-open")) !== -1){
                                            if(!thisUser.attr("style")) {
                                              thisUser.css("background-image","url("+user_images_url[0]+")"); 
                                            }
                                        }

                                    });
                                },
                                error: function(){
                                    alert("Images have not been saved!");
                                }
                            });
                        }

                        return false;                    
                    });

                    frame.open();
                });
            });
            
            $(document).on('click','.tcg-delete-image', function( event ) {

                el.closest(".tcard-group").find($(this)).each(function(){
                    event.preventDefault();
                    var tcg = $(this).closest(".tcg-group").find(".tcg.is-open"),
                        currIMG = tcg.find(".tcg-item.current"),
                        user_images_url = [];

                    if(currIMG.next(".tcg-item").length){
                        currIMG.next(".tcg-item").addClass("current").fadeIn()  
                    }else if(currIMG.prev(".tcg-item").length){
                        currIMG.prev(".tcg-item").addClass("current").fadeIn()
                    }

                    currIMG.remove();
      
                    $(this).closest(".tcg-group").find(".tcg-counter-all").html(tcg.find(".tcg-item").length);
              
                    lastImg = tcg.find(".tcg-item").last();
                    var currentCounter = $(this).closest(".tcg-group").find(".tcg-current-counter");
                    if(lastImg.hasClass("current")){
                        currentCounter.text(1);
                    }else if(!tcg.find(".tcg-item").length){
                        currentCounter.text(0);
                    }

                    for (var i = 0; i < tcg.find(".tcg-item").length; i++) {
                       user_images_url[i] = tcg.find(".tcg-item").eq(i).attr("src");
                    }

                    var data = {
                      action: 'tcard_user_images',
                      security: tcard_front.tcard_user_images,
                      skin_id: tcg.attr("data-tcg-skin_id"),
                      tc_user_images: user_images_url,
                      gallery_type: tcg.attr('data-tcg-type'),
                      thumbnail: tcg.attr('data-thumbnail'),
                      thumbnail_title: tcg.attr('data-title')
                    };

                    $.ajax({
                        url: tcard_front.ajaxurl,
                        type: 'POST',
                        data: data,
                        success:function(data){
                            console.log("Images saved!");
                            var tcgUser = tcg.closest(".tcg-group").find(".tcg-sidebar").find(".tcg-user");
                            tcgUser.each(function(){

                                var thisUser = $(this);

                                if(thisUser.attr("data-tcg-user").indexOf(tcg.attr("data-tcg-open")) !== -1 && !user_images_url.length){
                                    thisUser.removeAttr("style"); 
                                }

                            });
                        },
                        error: function(){
                            alert("Images have not been saved!");
                        }
                    });
                });
            });

            function tcgSlider($this, curPage) {
                var stop = false,
                    pages = $this.find(".tcg-item"),
                    pagesSize = pages.length,
                    counter = $this.closest(".tcg-group").find(".tcg-current-counter");
 
                //Total items inside of gallery
                $this.closest(".tcg-group").find(".tcg-counter-all").html($this.find(".tcg-item").length);
                if($this.find(".tcg-item").length){
                    counter.html(1);
                }else{
                    counter.html(0);
                }
               

                $this.find(".tcg-right").off();
                //Next item
                $this.find(".tcg-right").on("click", function () {
                    if (stop)
                        return;
      
                    var allImg = $this.find(".tcg-item").length;
                    if(allImg !== pagesSize){
                        pages = $this.find(".tcg-item")
                        pagesSize = pages.length;
                        curPage = pages.filter(".current").index();
                    }

                    if (curPage < pagesSize) {
                        curPage++;
                        if (curPage === pagesSize) {
                            curPage = 0;
                        }
                        pagination(pages,curPage);
                    }

                });

                $this.find(".tcg-left").off();
                //Previous item
                $this.find(".tcg-left").on("click", function () {
                    if (stop)
                        return;

                    var allImg = $this.find(".tcg-item").length;
                    if(allImg !== pagesSize){
                        pages = $this.find(".tcg-item")
                        pagesSize = pages.length;
                        curPage = pages.filter(".current").index();
                    }

                    if (curPage > -1) {
                        curPage--;
                        if (curPage === -1) {
                            curPage = pagesSize - 1;
                        }
                        
                        pagination(pages,curPage);
                    }
                });

                //Change item
                function pagination(pages,page) {
                    stop = true;
                    curPage = page;
                    pages.removeClass("current").fadeOut(200);
                    pages.eq(page).removeClass("previous").addClass("current").fadeIn(400);
                    counter.html(page + 1);
                    if (page > 0) {
                        pages.eq(page - 1).addClass("previous").fadeOut(200);
                        while (--page) {
                            pages.eq(page - 1).addClass("previous").fadeOut(200);
                        }
                    }
                    setTimeout(function () {
                        stop = false;
                        pages;
                    }, 500);
                }
            }
        },
        tcardEllipsis: function (el, option) {

            el.find("*[data-text='ellipsis']").each(function () {
                var thisText = $(this);
         
                thisText.html(thisText.html()).wrapInner("<div class='ellipsis'></div>");
                
                var tcardText = thisText.find(".ellipsis");

                thisText.css("height", "330px");

                var oldText = tcardText.html();
                multiline(thisText, tcardText, oldText);
                $(window).on("resize", function () {
                    multiline(thisText, tcardText, oldText);
                });
            });

            function multiline(thisText, tcardText, oldText) {
                var tch = thisText.height();
                tcardText.html(oldText);
                while (tcardText.outerHeight() > tch) {
                    tcardText.html(function (index, text) {
                        return text.replace(/\W*\s(\S)*$/, '...');
                    });
                }
            }
        },
        tcardForm: function (el, option) {
            var self = this;

            el.find(".tc-form-button.contact").on("click",function(e){
                e.preventDefault();
                var thisBtn = $(this),valid,form;
                var msg = [];

                form = thisBtn.closest(".tcard-form.contact");

                if(form.find(".tcard-full_name").length){
                    if(form.find(".tcard-full_name").val() == ""){
                        msg.push(["Full Name field is required","tcard-full_name"]);
                        valid = false;
                    }else if(form.find(".tcard-full_name").val().length < 4){
                        msg.push(["Full name too short!!","tcard-full_name"]);
                        valid = false;
                    }
                }

                if(form.find(".tcard-subject").length){
                    if(form.find(".tcard-subject").val() == ""){
                        msg.push(["Subject field is required","tcard-subject"]);
                        valid = false;
                    }
                }

                if(form.find(".tcard-first_name").length){
                    if(form.find(".tcard-first_name").val() == ""){
                        msg.push(["First Name field is required","tcard-first_name"]);
                        valid = false;
                    }
                }

                if(form.find(".tcard-last_name").length){
                    if(form.find(".tcard-last_name").val() == ""){
                        msg.push(["Last Name field is required","tcard-last_name"]);
                        valid = false;
                    }
                }

                var check_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                var is_email = check_email.test(form.find(".tcard-email").val());
                if(form.find(".tcard-email").length){
                    if(form.find(".tcard-email").val() == ""){
                        msg.push(["Email field is required","tcard-email"]);
                        valid = false;
                    }else{
                        if(!is_email){
                           msg.push(["The e-mail address entered is invalid.","tcard-email"]);
                           valid = false;  
                        }
                    }
                }

                if(form.find(".tcard-message").length){
                    if(form.find(".tcard-message").val() == ""){
                        msg.push(["Message field is empty. Please say something","tcard-message"]);
                        valid = false;
                    }
                }

                var check_phone = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
                var is_phone = check_phone.test(form.find(".tcard-phone").val())
                if(form.find(".tcard-phone").length){
                    if(form.find(".tcard-phone").val().length && !is_phone){
                        msg.push(["Phone number is invalid.","tcard-phone"]);
                        valid = false; 
                    }
                }

                var check_url = /^(https?:\/\/)?((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|((\d{1,3}\.){3}\d{1,3}))(\:\d+)?(\/[-a-z\d%_.~+]*)*(\?[;&a-z\d%_.~+=-]*)?(\#[-a-z\d_]*)?$/i;
                var is_url = check_url.test(form.find(".tcard-website").val());
                if(form.find(".tcard-website").length){
                    if(form.find(".tcard-website").val().length && !is_url){
                        msg.push(["Website URL is not valid.","tcard-website"]);
                        valid = false;   
                    }
                }

                if(valid == false){
                    error(form,msg);
                    return false;
                }else{

                    var all_fields = [];
                    
                    for (var i =  0; i < form.find(".tcard-form-item input").length; i++) {
                        all_fields[i] = [
                            form.find(".tcard-form-item input").eq(i).attr("data-field"),
                            form.find(".tcard-form-item input").eq(i).val()
                        ];
                    }
                    var skin_index = $(this).closest(".tcard").index(),side;

                    if($(this).closest(".tcard-front").length){
                        side = "front";
                    }else if($(this).closest(".tcard-back").length){
                        side = "back";
                    }

                    var data = {
                      action: 'tcard_contact',
                      security: tcard_front.tcard_contact,
                      fields: all_fields,
                      message: form.find(".tcard-form-item textarea").val(),
                      group_id: form.attr("data-group_id"),
                      skin_key: skin_index,
                      side: side
                    };

                    $.ajax({
                        url: tcard_front.ajaxurl,
                        type: 'POST',
                        data: data,
                        success:function(data){
                            var html_success = 
                            '<div style="background: green" class="tcard-success">'+
                                '<p> '+data+' </p>'+
                            '</div>';
                            
                            form.append(html_success);
                            form.find(".tcard-success").fadeOut(5000,function(){
                                $(this).remove();
                            });
                         
                        },
                        error: function(response){
                            var html_error = 
                            '<div class="tcard-errors msg">'+
                                '<div class="tc-close-errors">X</div>'+
                                '<p> '+response.responseText+' </p>'+
                            '</div>';
                            form.append(html_error);
                            el.find(".tc-close-errors").on("click",function(){
                            $(this).parent(".tcard-errors").fadeOut(400,function(){
                                 $(this).remove();
                            });
                        });
                        }
                    });

                    form.find(".tcard-form-item input, .tcard-form-item textarea").val("");
                    form.find(".tcard-form-item").removeClass("active");
        
                    form.find(".tcard-errors.contact").remove();
                    return false;
                }
                
            });

            el.find(".tc-close-errors").on("click",function(){
                $(this).parent(".tcard-errors").fadeOut(400,function(){
                     $(this).remove();
                });
            });

            function error(form,msg){
                var html_error = 
                '<div class="tcard-errors contact">'+
                    '<div class="tc-close-errors">X</div>'+
                '</div>';
                
                if(!form.find(".tcard-errors.contact").length){
                    form.append(html_error);
                    el.find(".tc-close-errors").on("click",function(){
                        $(this).parent(".tcard-errors").fadeOut(400,function(){
                             $(this).remove();
                        });
                    });
                }

                var tcardErrors = form.find(".tcard-errors.contact");

                var error = '<p> <span class="tc-line-error">-</span> <span class="tcard-error-msg"></span> </p>';
                var classErr = [];
                for (var i = 0; i < msg.length; i++) {
                    if(!tcardErrors.find("." + msg[i][1]).length){
                        tcardErrors.append($(error).addClass(msg[i][1]));
                        tcardErrors.find("." + msg[i][1]).find(".tcard-error-msg").text(msg[i][0]);
                        
                    }else{
                       tcardErrors.find("." + msg[i][1]).find(".tcard-error-msg").text(msg[i][0]); 
                    }
                    classErr.push(msg[i][1]); 
                }
                for (var i = 0; i < tcardErrors.find("p").length; i++) {
                    if(!tcardErrors.find("p").eq(i).hasClass(classErr[i])){
                       tcardErrors.find("p").eq(i).remove(); 
                    }
                }
            }

            el.find("form").attr("autocomplete", self.option.autocomplete)
                    .find("input,textarea").on("keyup", function () {
                if (!$(this).val()) {
                    $(this).parent().removeClass('active');
                } else {
                    $(this).parent().addClass('active');
                }
            });
        },
        tcardColor: function (el, option) {
            var self = this;
            var randomizer,
                    colorSize,
                    allColor = ["air-force-blue", "alizarin", "alizarin-crimson", "amaranth", "amber",
                        "american-rose", "android-green", "awesome", "azure", "beige", "black", "blue", "darkblue", "ball-blue",
                        "bleu-de-france", "blue-green", "blue-purple", "bright-green", "canary-yellow", "carmine", "carolina-blue",
                        "cerulean", "cerulean-blue", "chrome-yellow", "cinnabar", "cool-black", "cornflower-blue", "dark-slate-gray",
                        "dark-gray", "davy-grey", "debian-red", "deep-magenta", "deep-pink", "egyptian-blue", "electric-yellow", "electric-violet",
                        "jungle-green", "lemon", "lemon-lime", "lava", "lavender-blue", "light-sea-green", "light-slate-gray", "majorelle-blue",
                        "medium-persian-blue", "magenta", "navy", "orange", "persian-red", "prussian-blue", "paris-green", "rose-madder", "royal-blue",
                        "saint-blue", "sea-blue", "screamin-green", "shamrock-green", "true-blue", "teal", "yellowgreen"];
            
            if (self.option.randomColor == true) {

                for (var i = 0; i < allColor.length; i++) {
                   el.find(".tcard-front,.tcard-back").removeClass(""+allColor[i]+"")
                }

                for (var i = 0; i < el.length; i++) {
                    colorSize = allColor.length - 0.5;
                    randomizer = Math.round(Math.random() * colorSize);
                    $(el[i]).find(".tcard-front,.tcard-back").addClass(allColor[randomizer]);
                }
            }
        },
        tcardSlider: function(el, option){
            $(document).ready(function(){
                el.find(".tcard-slider").each(function(){
                    var slider = $(this);
                    if(slider.hasClass("scroll")) return

                    var container = slider.find(".tcs-inner"),
                      item = slider.find(".tcs-item"),
                      stop = false,
                      count = 0,
                      time = 400,
                      numberItem = 1,
                      padding = slider.outerHeight() - slider.height();

                    item.css("width", slider.outerWidth() / numberItem);

                    var containerWidth = (item.length + 1) * slider.outerWidth();

                    container.css("width", containerWidth);

                    slider.css('height', item.eq(0).outerHeight() + padding);

                    slider.find(".tc-slider-arrow.left").on("click touchstart", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (stop) return;
                            if (count > 0) {
                                count--;
                                dirr("+", count);
                            }
                    });

                    slider.find(".tc-slider-arrow.right").on("click touchstart", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (stop) return;
                            if (count < item.length - numberItem) {
                                count++;
                                dirr("-", count);
                            }
                    });

                    function dirr(dirr, slide) {
                        stop = true;
                        count = slide;
                        if (!container.hasClass("cubictime")) {
                            container.addClass("cubictime");
                        }

                        slider.stop().animate({
                            height: item.eq(slide).outerHeight() + padding
                        }, 200);

                        if(el.closest(".arcfilter-items").length){

                            var diff = Math.abs(item.eq(slide - 1).outerHeight() - item.eq(slide).outerHeight());

                            var arcfilter;
                            if(dirr == "+"){
                                arcfilter = el.closest(".arcfilter-items").height() - diff;
                            }else{
                                arcfilter = el.closest(".arcfilter-items").height() + diff;
                            }
                            el.closest(".arcfilter-items").stop().animate({
                                height: arcfilter
                            }, 200);
                        }

                        item.removeClass("active");
                        item.eq(slide).addClass("active");

                        container.css('left', dirr + '=' + item.outerWidth());
                        setTimeout(function() {
                            stop = false;
                        }, time);
                    }
     
                    $(window).resize(function() {

                        padding = slider.outerHeight() - slider.height();
                        var itemActive = item.filter(".active").index();

                        slider.stop().animate({
                            height: item.eq(itemActive).outerHeight() + padding
                        }, 100);

                        item.css("width", slider.outerWidth() / numberItem);
                        containerWidth = (item.length + 1) * slider.outerWidth();
                        
                        container.css("width", containerWidth);
                        if(item.filter(".active").length){
                            container.stop().animate({
                                left: -item.filter(".active").position().left
                            }, 0).removeClass('cubictime');
                        }
                    });
                });
            });
        }
    };

    function setAnimationMode(tcardOn, animationFront, tcardFront) {
        if (tcardOn === "button") {
            if (animationFront === "hover") {
                tcardFront.on("mouseenter touchstart", function () {
                    FronteachAnimation($(this));
                });
            } else if (animationFront === "ready") {
                tcardFront.each(function () {
                    animationIn($(this).find($("*[data-animationIn]")));
                });
            }
        } else if (tcardOn === "hover") {
            tcardFront.each(function () {
                FronteachAnimation($(this));
            });
        }

        function FronteachAnimation($this) {
            var $thisanimationIn = $this.find($("*[data-animationIn]"));
            $thisanimationIn.each(function () {
                if (!$(this).hasClass($this.attr("data-animationIn"))) {
                    animationIn($(this));
                }
            });
        }
    }

    function animationIn(curr) {
        curr.each(function () {
            $(this).removeClass("animated" + " " + "" + $(this).attr("data-animationOut") + "")
                    .addClass("animated" + " " + "" + $(this).attr("data-animationIn") + "").css('animation-delay', $(this).attr("data-delay") + 'ms').css("opacity", "1");
        });
    }

    function animationOut(curr) {
        curr.each(function () {
            $(this).removeClass("animated" + " " + "" + $(this).attr("data-animationIn") + "")
                    .addClass("animated" + " " + "" + $(this).attr("data-animationOut") + "").css('animation-delay', $(this).attr("data-delay") + 'ms');
        });
    }

    function animation() {
        var t,
                el = document.createElement("fl");
        var animation = {
            "animation": "animationend",
            "OAnimation": "oAnimationEnd",
            "MozAnimation": "animationend",
            "WebkitAnimation": "webkitAnimationEnd"
        };
        for (t in animation) {
            if (el.style[t] !== undefined) {
                return animation[t];
            }
        }
    }

    function transition() {
        var t,
                el = document.createElement("fl");
        var transitions = {
            "transition": "transitionend",
            "OTransition": "oTransitionEnd",
            "MozTransition": "transitionend",
            "WebkitTransition": "webkitTransitionEnd"
        };
        for (t in transitions) {
            if (el.style[t] !== undefined) {
                return transitions[t];
            }
        }
    }

    $.fn.tcard = function (option) {
        var instance = $.data(this, 'tcard');
        if (instance === undefined) {
            option = option || {};
            $.data(this, 'tcard', new tcard(this, option));
            return this;
        }

        if ($.isFunction(tcard.prototype[option])) {
            var args = Array.prototype.slice.call(arguments);
            args.shift();
            return tcard.prototype[option].apply(instance, args);
        } else if (option) {
            $.error('Method ' + option + ' does not exist on tcard');
        }
        return this;
    };
})( jQuery );