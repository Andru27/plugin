/* 
 Author: Cloanta Alexandru
 Name: Tcard Wordpress
 Version: 2.9.1
*/

(function( $ ) {
	'use strict';

	$(document).on("ready",function(){

		$(".bootstrap-info-btn").on("click",function(){
			var thisBtn = $(this);
			thisBtn.next(".bootstrap-info").slideToggle(300);
		});

		var stopClick = false;

		$(document).on("click",".tcard-row-bar",function(e){

		  	if (e.target != this)
					return;
			var tcardArrow = $(this).find("input.tcard_check");
			$(this).next(".tcard-skin").slideToggle(); 

			(tcardArrow.prop("checked")) ? tcardArrow.prop("checked",false) : tcardArrow.prop("checked",true);
		});

		$(".tcard-container-skins").sortable({
			handle: ".tcard-row-bar",
			opacity: 0.8,
			cursor: "move",
			delay:100,
			placeholder: "tcard-highlight",
			start: function(event, ui) {

				for(var i = 0; i < $(".tcard-row").length;i++){
					$(".tcard-row").eq(i).attr("data-index",i)
				}

				$(".tcard-highlight").height(ui.item.height())

				
		    },
			update: function(event, ui) {

			 	Tcard.reorder(".tcard-row");

			 	$(".tcard-textarea").each(function(){
			 		wp.editor.remove($(this).attr('id'));
					Tcard.add_wp_editor($(this));
			 	});
			}
		});

		$(".modal-post-content,.tcard-modal-sortable").sortable({
			opacity: 0.8,
			cursor: "move",
			delay:100,
		});		

		$('.post-open_set').on("click",function(){

			var thisBtn = $(this);

			thisBtn.toggleClass("post-is-open");
			$(".select-category-post").slideToggle(300);

			if(thisBtn.hasClass("post-is-open")){
				thisBtn.closest(".tcard-sidebar-item.elements").animate({
					height: "+=" + 196
				},300)
			}else{
				thisBtn.closest(".tcard-sidebar-item.elements").animate({
					height: "-=" + 196
				},300)
			}

		});

		$(document).on("click",".tc-post-element",function(){
			var thisBtn = $(this),
			container = thisBtn.parent(".modal-post-header").next(".modal-post-content"),classElem,skin,side,elemNumber,max_words,element;
			classElem = thisBtn.text().replace(" ","_");
	
			if(classElem == 'button'){
				classElem = "post_button";
			}else if(classElem == 'comment count'){
				classElem = "comment_count";
			}
			else if(classElem == 'featured image'){
				classElem = "featured_image";
			}
			else if(classElem == 'show category'){
				classElem = "show_category";
			}
			
			
			skin = thisBtn.closest(".tcard-row").index();
			side = thisBtn.closest(".tcard-main-elem").attr("data-side");
			elemNumber = thisBtn.attr("data-itemnum");

			if(container.hasClass("arcfilter_item_post")){
				if(thisBtn.text() == "title" || thisBtn.text() == "content"){
					if(thisBtn.text() == "content"){
						max_words = 17;
					}else{
						max_words = '';
					}
					element = 
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="cat_items'+ elemNumber +'[post_item][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
						'<span>Max words</span>'+
						'<input class="tcard-input" type="number" placeholder="'+max_words+'" name="cat_items'+ elemNumber +'[set_item]['+ thisBtn.text() +']" value="">'+
					'</div>';
				}else if(classElem == "post_button"){
					element =
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="cat_items'+ elemNumber +'[post_item][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
						'<span>Button Text</span>'+
						'<input class="tcard-input"  type="text" placeholder="Read More" name="cat_items'+ elemNumber +'[set_item]['+ classElem +']" value="">'+
					'</div>';
				}else if(classElem == "comment_count" || classElem == "date" || classElem == "author" || classElem == "show_category"){
					element =
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="cat_items'+ elemNumber +'[post_item][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
						'<span>Type</span>'+
						'<select class="post_select_type tcard-input" name="cat_items'+ elemNumber +'[set_item]['+ classElem +']">'+
							'<option></option>'+
							'<option value="'+classElem+'_post_icon">Icon</option>'+
							'<option value="'+classElem+'_post_text">Text</option>'+
						'</select>'+
						'<input class="tcard-input input-type-text" type="text" name="cat_items'+ elemNumber +'[set_item]['+ classElem +'_text]" value="">'+
					'</div>';
				}else{
					element = 
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="cat_items'+ elemNumber +'[post_item][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
					'</div>';
				}
			}else{

				if(thisBtn.text() == "title" || thisBtn.text() == "content"){
					if(thisBtn.text() == "content"){
						max_words = 17;
					}else{
						max_words = '';
					}
					element = 
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="content'+ skin +'_'+ side +'[tcard_post'+ elemNumber +'][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
						'<span>Max words</span>'+
						'<input class="tcard-input" type="number" placeholder="'+max_words+'" name="content'+ skin +'_'+ side +'[tcard_post_'+ thisBtn.text() +'][]" value="">'+
					'</div>';
				}else if(classElem == "post_button"){
					element =
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="content'+ skin +'_'+ side +'[tcard_post'+ elemNumber +'][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
						'<span>Button Text</span>'+
						'<input class="tcard-input"  type="text" placeholder="Read More" name="content'+ skin +'_'+ side +'[tcard_post_'+ classElem +'][]" value="">'+
					'</div>';
				}else if(classElem == "comment_count" || classElem == "date" || classElem == "author" || classElem == "show_category"){
					element =
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="content'+ skin +'_'+ side +'[tcard_post'+ elemNumber +'][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
						'<span>Type</span>'+
						'<select class="post_select_type tcard-input" name="content'+ skin +'_'+ side +'[tcard_post_'+ classElem +'][]">'+
							'<option></option>'+
							'<option value="'+classElem+'_post_icon">Icon</option>'+
							'<option value="'+classElem+'_post_text">Text</option>'+
						'</select>'+
						'<input class="tcard-input input-type-text" type="text" name="content'+ skin +'_'+ side +'[tcard_post_'+ classElem +'_text][]" value="">'+
					'</div>';
				}else{
					element = 
					'<div class="tc_post_item '+ classElem +'">'+
						'<input type="hidden" name="content'+ skin +'_'+ side +'[tcard_post'+ elemNumber +'][]" value="'+ classElem +'">'+
						'<div class="remove-post-item"></div>'+
						'<h4>'+ thisBtn.text() +'</h4>'+
					'</div>';
				}
			}
			
			container.append(element);

		});

		$(document).on('click','.post_select_type',function(){

			if($(this).val() == 'author_post_text' || $(this).val() == 'comment_count_post_text' 
				|| $(this).val() == 'date_post_text' || $(this).val() == 'show_category_post_text' || $(this).val() == 'tags_post_text'){
				$(this).next('.input-type-text').fadeIn(0);
			}else{
				$(this).next('.input-type-text').fadeOut(0).val('');
			}

		});

		$(document).on("click",".remove-post-item",function(){
			$(this).parent().remove();
		});

		var number = 0;
		$(".tc-add-new-skin").on("click",function(e){
			if(!$(".select-tcard-group select").val()){

				alert("Please create a group");
				$(this).find("input").val('')
				return;
			}
			else if(!$("#select-skin").val()){

				alert("Please select type of skin");
				$(this).find("input").val('')
				return;
			}
			else{

				if(stopClick) return;
				if($(this).find("input").val() > 0){
					number = $(this).find("input").val();
				}

				number++;

				$(".tcard-count-skin").find("span").text(number)
				$(this).find("input").val(number);

				TcardAjax.add_skin('new-skin',$("#select-skin").val(),number,'');
			}
			
		});

		$(document).on("click",".tcard-delete-skin",function(){

			var skin_index = $(this).closest(".tcard-row").index();

			$(".tcard-row").each(function(){
				$(this).attr("data-index",$(this).index())
			});

			$(this).closest(".tcard-row").remove();

			$(".tcard-count-skin").find("span").text($(".tcard-row").length)
			$(".tc-add-new-skin").find("input").val($(".tcard-row").length);

			for (var i = 0; i < $(".tcard-row").length; i++) {
				$(".tcard-skin-order").eq(i).text(i + 1)
			}

			TcardAjax.delete_skin(skin_index,$(".tcard-row").length);
			Tcard.reorder(".tcard-row");
			
		});

		$("#select-skin").on('change',function(){

			if($(".select-tcard-group select").val()){

				TcardAjax.select_skin($(this).val());
			}
			else{

				alert("Please create a group.");
				$(this).val('') 
				return;
			}
		});	

		$(".delete-tcard-group").on("click",function(){
			var group_title;
			
			if($(".tcard-group-title").val()){
				group_title = $(".tcard-group-title").val();
			}else{
				group_title = $(".select-tcard-group select option[selected]").text();
			}

			return confirm('Are you sure you want to remove '+ group_title +' group ?');
		});

		$(document).on("click",".tcard-settings",function(){
			$(this).next(".tcard-modal").fadeIn().addClass("is-open");
			$(".tcard-container-skins").sortable("disable");
		});

		$(document).on("click",".tcard-element-bar",function(){
			$(".customSkin .tcard-item-elements").sortable("disable");
			Tcard.modal($(this).next(".tcard-modal"));
		});

		$(document).on("click",".tcard-modal,.tcard-close-modal",function(e){

			if (e.target != this)
					return;
			$(this).closest(".tcard-modal").fadeOut().removeClass("is-open");

			setTimeout(function(){
				$(".customSkin .tcard-item-elements").sortable("enable"); 
				$(".tcard-container-skins").sortable("enable");
			},200);
		});

		$('#tcard-save').on("click",function(e){
			window.onbeforeunload = null;
			$(".spinner").css("visibility","visible");

		});
		
        $('.copy-shortcode').on('click', function () {
            Tcard.copy_shortcode(document.getElementById('tcard-code'))
        });
 
        $('.tcard-shortcode').on('click', function () {
           Tcard.copy_shortcode(this)
        });

		$(".elements-menu h4").on("click",function(e){

			if(!$(this).hasClass("tc-current-side")){
				if(stopClick) return;

				var thisMenuAttr = $(this).attr("data-tcard-menu");
				$(".elements-menu h4").removeClass("tc-current-side");
				$(this).addClass("tc-current-side");

				Tcard.fade_content(thisMenuAttr,".tcard-item-inner","data-tcard-box",".tcard-sidebar-item.elements",10);
			}

		});

		$(document).on("click",'.tcard-clone-skin',function(){
			var thisBtn = $(this),
				number = $(".tc-add-new-skin").find("input").val();

			var elements = [];
			$(".tcard-row").find(".new-element_maybe").each(function(){
				var parent = $(this).closest(".tcard-item").attr("data-item").replace("tcard-",'');
				var elementName = $(this).attr("data-element").replace(parent + "_",'');
				elements.push(elementName);
			});	

			if(elements.length){
				alert("Elements " + elements + " are not saved");
			}else{

				number++;
				$(".tcard-count-skin").find("span").text(number);
				$(".tc-add-new-skin").find("input").val(number);
		
				var skinCloned = thisBtn.closest(".tcard-row").index();

				TcardAjax.add_skin('clone-skin',$("#select-skin").val(),number,skinCloned);	
			}
		});

		$(document).on("click",".tcard-delete-element",function(){
			Tcard.removeContent('element',$(this));
		});

		$(document).on("click",".tcard-delete-item",function(){
			Tcard.removeContent('item',$(this))
		});

		$(document).on("click",".increase-size",function(){

			Tcard.setWidth("increase",$(this));
		});

		$(document).on("click",".decreases-size",function(){
			Tcard.setWidth("decrease",$(this));
		});

		$(document).on("click",".tcard-add-item",function(){
			Tcard.add_item_list($(this),$(this).text());
		});

		$(".tcard-input").on("input",function(e){
			window.onbeforeunload = function() { return true };
		});

		$(document).on("click",".tcard-remove-item",function(){
			$(this).closest(".tcard-modal-item").remove();
		})

		$(document).on("click",".settings-btn",function(){
			var tcard = $(this).closest(".tcard-modal-body.settings-skin")

			tcard.find(".menu-sides-item").removeClass("tc-current-side").first().addClass("tc-current-side");
			tcard.find(".card-admin").removeClass('flipped rotate-in rotate-out');
			if(!$(this).hasClass("tc-current-side")){
				if(stopClick) return;

				var thisMenuAttr = $(this).attr("data-menu-container");
				$(".tcard-modal.is-open .settings-btn").removeClass("tc-current-side");
				$(this).addClass("tc-current-side");
				var modalContainer = $(this).closest(".tcard-modal").find(".tcard-modal-container"),
					modalContent = $(this).closest(".tcard-modal").find(".tcard-modal-content");
				Tcard.fade_content(thisMenuAttr,modalContainer,"data-modal-container",modalContent,20);
			}
		});
		var stop = false;
		var Tcard = {
			settings: function(modal){
				var self = this,
				stopClick = false;
				modal.find(".menu-sides-item").on("click",function(){
					if(stopClick) return;
					if(!$(this).hasClass("tc-current-side")){
						var thisMenuAttr = $(this).attr("data-menu-side"),
						modalContainer = $(this).closest(".tcard-modal-container").find(".tcard-modal-side");

						$(".menu-sides-item").removeClass("tc-current-side");
						$(this).addClass("tc-current-side");

						modalContainer.removeClass("active_side");
						modalContainer.filter("[data-modal-side="+thisMenuAttr+"]").addClass("active_side");

						var tcard = $(this).closest(".tcard-modal-container").find(".card-admin");

						if(thisMenuAttr == "tcard-front"){
							addMainClassesRemove('showface');
						}else if(thisMenuAttr == "tcard-back"){
							addMainClassesRemove('showback');
						}

						function addMainClassesRemove(action) {
							if(stopClick) return;
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
			                stopClick = true;
			                setTimeout(function(){
			                	stopClick = false
			                },500);

			            }
			            self.fade_content(thisMenuAttr,modalContainer,"data-modal-side","",20);
		            }
				});

				modal.find(".menu_sides_box").on("click",function(){
					if(stopClick) return;
					var thisMenuAttr = $(this).attr("data-menu-side_box"),
					modalContainer = $(this).closest(".tcard-modal-side").find(".tcard-modal-side_box");

					$(this).parent().find(".menu_sides_box").removeClass("active");
					$(this).addClass("active");
					self.fade_content(thisMenuAttr,modalContainer,"data-modal-side_box","",20);
				});

				modal.find(".set_box_title").on("click", function() {
				 	 $(this).next(".set_box_inner").slideToggle(300);
				});
		
				modal.find(".select_type_set").on("change", function() {
				  	var thisVal = $(this).val(),
				    	sides_box = $(this).closest(".set_box_inner").find(".sides_box");
				  	sides_box.fadeOut(0);

				  	if(thisVal.length){
				  		sides_box.filter("*[data-active-box=" + thisVal + "]").fadeIn(200);
				  	}
				  	
				  	var card = get_box($(this));
				  	sides_box.find(".wp-color-result").css("background-color",'');
				  	if($(this).hasClass("select_shadow")){
				  		card.css({
					      '-webkit-box-shadow': 'none',
					      '-moz-box-shadow': 'none',
					      'box-shadow': 'none'
					    });
				  	}else if($(this).hasClass("select_border_radius")){
				  		card.css('border-radius',"");
				  	}else if($(this).hasClass("select_border")){
				  		card.css('border',"");
				  	}

				  	sides_box.find('.tcard-input').val("")
				});

	
				modal.find(".mini_boxs_ul").find(".tcard-input").on("input change", function() {
				  var thisValue = $(this);
				  set(thisValue,"all");
				});

				modal.find(".box_shadow_none.with_margin").find("select.tcard-input").on("change", function() {
				  var thisValue = $(this);
				  set(thisValue,"all");
				});

				var bg_color_opt = {
				    change: function(event, ui,option){
				   		var thisValue = $(this);
						set(thisValue,"color");
				    }
				};
				$('.tcard-color-picker').wpColorPicker(bg_color_opt);
				
				modal.find(".display_frostedglass").on("click",function(){
					var thisInput = $(this),set_box,
					card = get_box(thisInput),glass;
					if(card.hasClass("tcard-front") || card.hasClass("tcard-back")){
	        			glass = ".glass";
	        		}else{
	        			glass = ".glass-box";
	        		}
					card.find(glass).toggleClass("is_active");
					if(!thisInput.prop("checked")){
						card.find(glass).css({
					      '-webkit-box-shadow': '',
					      '-moz-box-shadow': '',
					      'box-shadow': ''
					    });
					    set_box = $(this).closest(".set_box");
					    set_box.find(".frostedglass_bg_color,.frostedglass_bg_colorg,.frostedglass_blur,.frostedglass_opacity").val("");
					    set_box.find(".wp-color-result").css("background-color",'');
					    var img_glass = set_box.find(".frostedglass_image_set");
					    if(img_glass.prop("checked") == true){
					    	img_glass.prop("checked",false);
					    }
					}
				});
				
				modal.find(".frostedglass_image_set").on("click",function(){
					var thisInput = $(this),
					card = get_box(thisInput),glass;
					if(card.hasClass("tcard-front") || card.hasClass("tcard-back")){
	        			glass = ".glass";
	        		}else{
	        			glass = ".glass-box";
	        		}
					if(thisInput.prop("checked")){
						card.find(glass).css("background",'inherit');
					}else{
						card.find(glass).css("background",'');
					}
				});
				function set(thisValue,action){

					var card,
					box_shadow_value = thisValue.closest(".set_box").find(".box_shadow_value");

					card = get_box(thisValue);
			
					var classes = ['frostedglass_blur','border-width', 'border-style', 'border-color', 'border-top-width', 'border-top-style', 
					  'border-top-color', 'border-right-width', 'border-right-style', 'border-right-color', 'border-bottom-width', 
					  'border-bottom-style', 'border-bottom-color', 'border-left-width', 'border-left-style', 'border-left-color', 
					  'border-radius', 'border-top-right-radius', 'border-top-left-radius', 'border-bottom-right-radius', 
					  'border-bottom-left-radius','background-color','background-position','background-size','background-repeat','background-attachment',
					  'padding-top','padding-right','padding-bottom','padding-left','margin-top','margin-right','margin-bottom','margin-left','frostedglass_bg_colorg'];

					var classesc = ['background-color','border-color','border-top-color','border-right-color','border-bottom-color','border-left-color','frostedglass_bg_colorg'];

				  	if (box_shadow_value.length) {
				    	var h = box_shadow_value.find(".shadow-h").val(),
				      		v = box_shadow_value.find(".shadow-v").val(),
				      		b = box_shadow_value.find(".shadow-b").val(),
				      		s = box_shadow_value.find(".shadow-s").val(),
				      		c = box_shadow_value.find(".shadow-c").val(),
				      		o = box_shadow_value.find(".shadow-o").val();
				      	if(!h.length){
				      		h = 0;
				      	}
				      	if(!v.length){
				      		v = 0;
				      	}
				      	if(!b.length){
				      		b = 0;
				      	}	
				      	if(!s.length){
				      		s = 0;
				      	}	
					    card.css({
					      '-webkit-box-shadow': h + "px " + v + "px " + b + "px " + s + "px " + 'rgba(' + rgba(c, o) + ')',
					      '-moz-box-shadow': h + "px " + v + "px " + b + "px " + s + "px " + 'rgba(' + rgba(c, o) + ')',
					      'box-shadow': h + "px " + v + "px " + b + "px " + s + "px " + 'rgba(' + rgba(c, o) + ')'
					    });
					    box_shadow_value.find(".tcard-color-shadow").val(rgba(c, o));
				  	} else {
		  				if(action == "color"){
				    		for (var i = 0; i <= classesc.length; i++) {
							    if (thisValue.hasClass(classesc[i])) {
							        card.css(classesc[i], thisValue.val())
							        if(thisValue.hasClass("frostedglass_bg_colorg")){
							        	var frostedglass_bg_color = thisValue.closest(".tcard-modal-side_box").find(".frostedglass_bg_color"),
							        		frostedglass_opacity = thisValue.closest(".tcard-modal-side_box").find(".frostedglass_opacity");
							        	frostedglass_bg_color.each(function(){
							        		$(this).val(rgba(thisValue.val(), frostedglass_opacity.val()))
							        	});
							        	var glass;
							        	frostedglass_opacity.on('input',function(){
							        		frostedglass_bg_color.val(rgba(thisValue.val(), $(this).val()))
							        		if(card.hasClass("tcard-front") || card.hasClass("tcard-back")){
							        			glass = ".glass";
							        		}else{
							        			glass = ".glass-box";
							        		}
								        	card.find(glass).css({
										      '-webkit-box-shadow': 'inset 0 0 0 1000px rgba(' + rgba(thisValue.val(), frostedglass_opacity.val()) + ')',
										      '-moz-box-shadow': 'inset 0 0 0 1000px rgba(' + rgba(thisValue.val(), frostedglass_opacity.val()) + ')',
										      'box-shadow': 'inset 0 0 0 1000px rgba(' + rgba(thisValue.val(), frostedglass_opacity.val()) + ')'
										    });
							        	});
							        	if(card.hasClass("tcard-front") || card.hasClass("tcard-back")){
						        			glass = ".glass";
						        		}else{
						        			glass = ".glass-box";
						        		}
							        	card.find(glass).css({
									      '-webkit-box-shadow': 'inset 0 0 0 1000px rgba(' + rgba(thisValue.val(), frostedglass_opacity.val()) + ')',
									      '-moz-box-shadow': 'inset 0 0 0 1000px rgba(' + rgba(thisValue.val(), frostedglass_opacity.val()) + ')',
									      'box-shadow': 'inset 0 0 0 1000px rgba(' + rgba(thisValue.val(), frostedglass_opacity.val()) + ')'
									    });
							        }
							    }
						    }	
				    	}else{
						    for (var i = 0; i <= classes.length; i++) {
							    if (thisValue.hasClass(classes[i])) {
							        if (classes[i] == "border-width" || classes[i] == "border-top-width" 
							        	|| classes[i] == "border-right-width" || classes[i] == "border-bottom-width" 
							        	|| classes[i] == "border-left-width" || classes[i] == "padding-top" || classes[i] == "padding-right" || 
							        	classes[i] == "padding-bottom" || classes[i] == "padding-left" || classes[i] == "margin-top" ||
							        	classes[i] == "margin-right" || classes[i] == "margin-bottom" || classes[i] == "margin-left") {
							          	card.css(classes[i], thisValue.val() + "px");
							        } else if(classes[i] == "frostedglass_blur") {
							          	if(card.hasClass("tcard-front") || card.hasClass("tcard-back")){
						        			glass = ".glass";
						        		}else{
						        			glass = ".glass-box";
						        		}
							        	card.find(glass).css({
									      '-webkit-filter': 'blur('+thisValue.val()+'px)',
									      'filter': 'blur('+thisValue.val()+'px)'
									    });
							        }else{
							        	card.css(classes[i], thisValue.val())
							        }
							    }
						    }
				    	}
				 	}
				}

				var frame = wp.media({
					title : 'Tcard Images Upload',
					multiple : false,
					library : { type : 'image' },
					button : { text : 'Insert' },
				});
	    		var thisBtn,card;
	    		modal.find(".set_upload_bg").on("click",function(e){
				    frame.open();
				    thisBtn = $(this);

					card = get_box(thisBtn);

					return false;
				});

				frame.on( 'select', function() {
					var attachment = frame.state().get('selection').toJSON();

					if(attachment.length){
						thisBtn.prev(".tcard-image-input").val(attachment[0].url);
						card.css("background-image",'url('+attachment[0].url+')');
					}
					return false;
				});	

				modal.find(".tcard-remove-image").on("click",function(e){
					var removeImg = $(this);
					var card = get_box(removeImg);
					card.css("background-image","");
					$(this).next(".tcard-image-input").val("");
				});

				function get_box(thisValue){

					var thisParent = thisValue.closest(".tcard-modal-container"),card,
					side = thisParent.find(".menu-sides-item.tc-current-side").attr('data-menu-side'),
					sideBox = thisParent.find(".tcard-modal-side.active_side .menu_sides_box.active").attr('data-menu-side_box');

					if(side == "tcard-front"){
				    	if(sideBox == "tcard-front"){
				    		card = thisParent.find("." + sideBox)
				    	}else{
				    		card = thisParent.find("." + side + " ." +sideBox);
				    	}
				    }else if(side == "tcard-back"){
				    	if(sideBox == "tcard-back"){
				    		card = thisParent.find("." + sideBox)
				    	}else{
				    		card = thisParent.find("." + side + " ." +sideBox)
				    	}
				    }

				    return card;
				}

				function rgba(hex, o) {
					if (hex.charAt(0) === '#') {
            			hex = hex.substr(1);
			        }
			        if ((hex.length < 2) || (hex.length > 6)) {
			            return false;
			        }
			        var r,g,b;
			        if (hex.length === 3) {
			            r = parseInt(hex[0].toString() + hex[0].toString(), 16);
			            g = parseInt(hex[1].toString() + hex[1].toString(), 16);
			            b = parseInt(hex[2].toString() + hex[2].toString(), 16);
			        } else if (hex.length === 6) {
			            r = parseInt(hex[0].toString() + hex[1].toString(), 16);
			            g = parseInt(hex[2].toString() + hex[3].toString(), 16);
			            b = parseInt(hex[4].toString() + hex[5].toString(), 16);
			        } else {
			            return false;
			        }
			        return [r, g, b, o];
				}	
			},
			fade_content: function(thisMenuAttr,item,attr,parent,padding){
				stopClick = true;

				$(item).each(function(){
					var thisBox = $(this).attr(attr);
					var thisItem = $(this);
				
					if(thisBox.indexOf(thisMenuAttr) !== -1){
						$(this).fadeIn(500);
						if(parent.length){
							$(this).parent(parent).animate({
								height: thisItem.height() + padding
							},200);
						}
					}
					else{
						$(this).fadeOut(0);
					}

				});
				
				setTimeout(function(){
					stopClick = false;
				},400);		
			},
			mainElements :function (){
				var self = this;
				$('.new-box').draggable({
		            helper: "clone",
		            zIndex: 999
		        });
			
		        var thisItem,helperItem,helperSide;
				$(".tcard-row").droppable({
					accept: ".new-box",
					helper: "clone",
					over: function(event, ui){
						thisItem = $(this).find('*[data-item='+ui.helper.attr('data-item')+']');
						helperItem = ui.helper.attr("data-item");
						helperSide = ui.helper.attr("data-side");

						if(ui.helper.hasClass(helperItem)){
							if(thisItem.length){
								ui.helper.addClass("not-accepted");
							}
						}
						else{
							thisItem.each(function(){
								if($(this).attr("data-item").indexOf(helperItem) !== -1 && $(this).find("."+helperSide+"-side").length){
									ui.helper.addClass("not-accepted");
								}
							});
						}
					},
					drop: function(event, ui){
						if(ui.helper.hasClass(helperItem)){
	
							if(!thisItem.length){

								if(ui.draggable.hasClass("tcard-header")){
									ui.draggable.clone().prependTo($(this).find(".tcard-skin"));
								}
								else if(ui.draggable.hasClass("tcard-content")){
									if(!$(this).find(".tcard-skin .tcard-footer").length){
										$(this).find(".tcard-skin .tcard-gallery").before(ui.draggable.clone().appendTo($(this).find(".tcard-skin")));
									}else if($(this).find(".tcard-skin .tcard-footer").length){
										$(this).find(".tcard-skin .tcard-footer").before(ui.draggable.clone().appendTo($(this).find(".tcard-skin")));
									}else{
										ui.draggable.clone().appendTo($(this).find(".tcard-skin"));
									}
								}
								else if(ui.draggable.hasClass("tcard-footer")){
									if($(this).find(".tcard-gallery").length){
										$(this).find(".tcard-gallery").before(ui.draggable.clone().appendTo($(this).find(".tcard-skin")));
									}
									else{
										ui.draggable.clone().appendTo($(this).find(".tcard-skin"));
									}
								}

							}
							
							$(this).removeClass("extra-height");
							self.sortable();
						}
						else{
							thisItem.each(function(){
								if($(this).attr("data-item").indexOf(helperItem) !== -1 && !thisItem.find("."+helperSide+"-side").length){
									if(helperSide == "front"){
										$(this).find(".tcard-item-title").closest('.tcard-item-bar').after(ui.draggable.clone().appendTo($(this)));
									}else{
										ui.draggable.clone().appendTo($(this));	
									}
									self.sortable();
								}
							});
						}
					}
				});
			},
			sortable: function(){
				var self = this;
				$('.new-element').draggable({
		            connectToSortable: '.tcard-item-elements',
		            helper: "clone",
		            zIndex: 999,
		            connectWith: ".tcard-item-elements",
		            start: function(event, ui){
		            	ui.helper.attr("element-parent",$(this).closest(".tcard-item-inner").attr("data-tcard-box"))
		            	ui.helper.attr("element-file",$(this).closest(".tcard-item-inner").attr("data-file"))
		            }
			    });
		        $(".customSkin .tcard-item-elements").sortable({
					accept: ".tcard-bar-element",
					delay: 100,
					over: function(event, ui){
						if(ui.item.hasClass("new-element")){

							if(!ui.item.hasClass("tcard-social")){
								if(ui.item.hasClass("login") && ui.item.attr("data-element",'login') && ui.item.closest(".tcard-main-elem").hasClass("back-side") ||
									!$(this).closest(".tcard-item").hasClass(ui.item.attr("element-parent"))){
									ui.helper.addClass("not-accepted");
								}else{
									ui.helper.removeClass("not-accepted");
								}
							}
						}
					},
					stop: function(event, ui){
						if(ui.item.hasClass("new-element")){

							var nextElem = ui.item.next(".tcard-element");
							ui.item.remove();

							var skinIndex = $(this).closest(".tcard-row").index(),side;

					
							side = $(this).closest(".tcard-main-elem").attr('data-side');

							if($(this).closest(".tcard-item").hasClass(ui.item.attr("element-parent"))){

								if(!ui.item.hasClass("login") && ui.item.attr("data-element") !== 'login' && side == "back"){
									TcardAjax.add_element(ui.item.attr("element-file"),ui.item.attr("data-element"),side,skinIndex,$(this),nextElem);
								}else if(side == "front"){
									TcardAjax.add_element(ui.item.attr("element-file"),ui.item.attr("data-element"),side,skinIndex,$(this),nextElem);
								}
								
							}else if(ui.item.attr("data-element") == "twitter_feed" || ui.item.attr("data-element") == "twitter_profile"){
								var parentFile;
								if($(this).closest(".tcard-item").hasClass("tcard-header")){
									parentFile = "TcardHeaderElements";
								}else if($(this).closest(".tcard-item").hasClass("tcard-content")){
									parentFile = "TcardContentElements";
								}else if($(this).closest(".tcard-item").hasClass("tcard-footer")){
									parentFile = "TcardFooterElements";
								}

								TcardAjax.add_element(parentFile,ui.item.attr("data-element"),side,skinIndex,$(this),nextElem);
							}	
						}

						if($(this).find(".tcard-textarea").length){
							wp.editor.remove($(this).find(".tcard-textarea").attr('id'));
							self.add_wp_editor(ui.item.find(".tcard-textarea"));
						}
					}
				});
			},
			setWidth: function(action,item){
				var classes = ['tc-1', 'tc-2', 'tc-3', 'tc-4'];
				var step = -1;

				classes.forEach(function(val, key) {
					if (item.closest(".tcard-element").hasClass(classes[key])) {
						step = key;
					}
				});

				item.closest(".tcard-element").each(function(){

					if (action == "increase") {
						if (step < classes.length - 1) {
							step++;
							$(this).removeClass(classes[step - 1]).addClass(classes[step]);
						}
					} 
					else if (action == "decrease") {
						if (step > 0) {
							step--;
							$(this).removeClass(classes[step + 1]).addClass(classes[step]);

						}
					}

					$(this).one("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function() {
						var calcWidth = Math.round(($(this).width() + 6) / $(this).parent().width() * 100) + "%";
						$(this).find(".elem-width").val(calcWidth);
					});
				});
				
				window.onbeforeunload = function() { return true };
			},
			removeContent: function(action,thisBtn){
				var tcardRow = thisBtn.closest(".tcard-row"),
				tcardItem = thisBtn.closest(".tcard-item"),
				mainElem = thisBtn.closest(".tcard-main-elem");

				if(action == "element"){
					thisBtn.parent().remove();			
					if(!mainElem.find(".tcard-element").length){
						mainElem.remove();
						if(!tcardItem.find(".tcard-main-elem").length){
							tcardItem.remove();
							if(!tcardRow.find(".tcard-item").length){
								tcardRow.addClass("extra-height")
							}
						}
					}

				}
				else if(action == "item"){
					tcardItem.remove();	
					if(!tcardRow.find(".tcard-item").length){
						tcardRow.addClass("extra-height")
					}			
				}

				window.onbeforeunload = function() { return true };
			},
			modal: function(modal){
				modal.fadeIn().addClass("is-open");

				modal.find(".tc-input-title").off().on("input",function(){
					var title;
					if($(this).val().length > 12){
						title = strip($(this).val()).substr(0, 12) + '...'
					}else{
						title = strip($(this).val());
					}

					$(this).closest(".tcard-element").find(".tcard-element-bar span").text(title);

					function strip(html){
						var tmp = document.createElement("DIV");
						tmp.innerHTML = html;
						return tmp.textContent || tmp.innerText;
					}
				});

				modal.find(".clear_after_login").off().on("click",function(){
					$(this).next("select").each(function(){
						$(this).find("option").removeAttr('selected');
					});
				});

				modal.find(".select-social").off().on("change",function(){
					$(this).closest(".tcard-element").find(".tcard-element-bar span").text($(this).val());
				});

				if(modal.find(".tc-show-input").length){
					modal.find("select.tc-show-input").off().on("change",function(){

						if($(this).closest(".tc_button").length || $(this).closest(".image_button").length){

							if($(this).closest(".tc_button").length){
								var fbutton = ".tc_button";
							}else{
								fbutton = ".image_button";
							}

							if($(this).val() == "text" || $(this).val() == "link"){
								$(this).closest(fbutton).find(".tchp_text_btn").css("display","block");
							}else{
								$(this).closest(fbutton).find(".tchp_text_btn").css("display","none").val('');
							}
						}else{
							if($(this).val() == "text" || $(this).val() == "link"){
								$(this).next(".tchp_text_btn").css("display","block");
							}else{
								$(this).next(".tchp_text_btn").css("display","none").val('');
							}
						}
					});
				}
			},
			reorder: function(item){

				var setOrder = [];
				$(".tcard_skin_id").each(function(){
					setOrder.push($(this).val());
				});

				setOrder.sort(function(a, b){
				  return a - b;
				});

				for (var i = 0; i < $(".tcard_skin_id").length; i++) {
					$(".tcard_skin_id").eq(i).val(setOrder[i]);
				}
	
				$(item).each(function(){

					
					var oldOrder = parseInt($(this).attr("data-index"));
					var newOrder = $(this).index();
	
					$(this).find(".tcard-skin-order").text(newOrder + 1);
					$(this).find(".tcard_check").attr("name","tcard_check_order"+newOrder+"");
					
					$(this).find(".tcard-input").each(function(){
						var setOrder = $(this).attr("name").replace(oldOrder,newOrder);
	        			$(this).attr("name",setOrder);
					});

					$(this).find(".assigns-tcard-gallery select,.tcg-box input").each(function(){
						var setOrder = $(this).attr("name").replace(oldOrder,newOrder);
	        			$(this).attr("name",setOrder);
					});

					window.onbeforeunload = function() { return true };	
				});
			},
			add_wp_editor: function(textarea){
				$(textarea).each(function(){
					var thisID = $(this).attr("id");
 					wp.editor.initialize(
					  thisID,
					  	{ 
						    mediaButtons: true,
						    tinymce: { 
						      	wpautop:true,
						      	toolbar1: 'formatselect bold italic | bullist numlist | blockquote | alignleft aligncenter alignright | wp_more',
						     	min_height: "150",
						     	plugins: "colorpicker lists compat3x directionality link image charmap hr image fullscreen media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wpview wptextpattern",
                                wpautop: false, 
						     	init_instance_callback: function (editor) {
								    editor.on('keyup', function (e) {
								    	$("#" + editor.id).each(function(){
								    		if($(this).closest(".tcard-modal-item").hasClass('tc-textarea-title')){
									    		var title,
									    		val = tinyMCE.activeEditor.getContent({ format: 'text' });
												if(val.length > 12){
													title = val.substr(0, 12) + '...'
												}else{
													title = val;
												}
												$(this).closest(".tcard-element").find(".tcard-element-bar span").text(title);
												window.onbeforeunload = function() { return true }
								    		}
										});
								    });
							  	}
						    }, 
						    quicktags: {
						        buttons: "strong,em,link,img,block,ul,ol,li,code,ins,more"
						    }
					  	}
					);	
		 		});
			},
			add_item_list: function (thisBtn,name){

				var skin = thisBtn.closest(".tcard-row").index(),
				tcardside = thisBtn.closest(".tcard-main-elem"), side;
					if(tcardside.hasClass("front-side")) side = "front";
						else side = "back";

				var lastIten = thisBtn.closest(".tcard-modal-body").find(".tcard-modal-item"),
					modalContent = thisBtn.closest(".tcard-modal-body").find(".tcard-modal-content"),thisElement;

					if(thisBtn.attr("data-itemnum")){
						thisElement = thisBtn.attr("data-itemnum");
					}else{
						thisElement = "";
					}

				var listItem = 
				'<div class="tcard-modal-item tcard_con_reg">' +
					'<div class="tcard-modal-item-inner">' +
						'<h4 class="tcard-with-em">Item Title: <br><span class="tcard-em">Require</span></h4>' + 
						'<input class="tcard-input" type="text" name="footer'+skin+'_'+side+'[info_list_title'+thisElement+'][]" value="">' +
						'<h4 class="tcard-remove-item"></h4>' +
					'</div>' +
					'<div class="tcard-modal-item-inner">' +
						'<h4>Item Text: </h4>' + 
						'<input class="tcard-input" type="text" name="footer'+skin+'_'+side+'[info_list_text'+thisElement+'][]" value="">' +
					'</div>' +
					'<div class="tcard-animation">' +
						'<h4>Delay:</h4>' +
						'<input class="tcard-input" type="number" name="footer'+skin+'_'+side+'[delay][]" value="">' +
					'</div>' +
				'</div>';

				var title,order,item,parent,icon,placeholder;
				if(modalContent.hasClass('contact')){
					title = '<h4 class="tcard-with-em">Label name: <br> <em class="tcard-em">Default : '+name+' </em></h4>';
					item = 'contact_item';
					parent = 'content';
					order = 'contact';
					placeholder = name;
				}else if(modalContent.hasClass('register')){
					title = '<h4 class="tcard-with-em">Label name: <br> <em class="tcard-em">Default : '+name+' </em></h4>';
					item = 'register_item';
					parent = 'content';
					order = 'register';
					placeholder = name;
				}else{
					if(name == "google+"){
						icon = "google-plus-square";
					}else if(name == "instagram" || name == "linkedin" || name == "flickr"){
						icon = name;
					}else{
						icon = name + "-square";
					}
					title = '<h4><i class="fab fa-'+icon+'"></i> </h4>';
					order = 'social_list_order'+ thisElement;
					item = 'social_list' + thisElement;
					parent = 'footer';
					placeholder = name + " username";
				}

				var socialItem =
				'<div class="tcard-modal-item">' +
					'<div class="tcard-modal-item-inner tcard_con_reg">' +
						'<input class="tcard-input" type="hidden" name="'+parent+''+skin+'_'+side+'['+order+'][]" value="'+name+'">' +
						title +
						'<input class="tcard-input" placeholder="'+placeholder+'" type="text" name="'+parent+''+skin+'_'+side+'['+item+'][]" value="">' +
						'<h4 class="tcard-remove-item"></h4>' +
						'<div class="tcard-animation">' +
							'<h4>Delay:</h4>' +
							'<input class="tcard-input" type="number" name="'+parent+''+skin+'_'+side+'[delay][]" value="">' +
						'</div>' +
					'</div>' +
				'</div>';

				var skillItem = 
				'<div class="tcard-modal-item tc-skill-item">'+
					'<div class="tc-skill-name">'+
						'<h4>Skill name: </h4>'+ 
						'<input class="tcard-input" type="text" name="content'+skin+'_'+side+'[skills_skill'+thisElement+'][]" value="">'+
						'<h4 class="tcard-remove-item"></h4>'+
					'</div>'+
					'<div class="tc-skill-percent">'+
						'<h4>Skill percent: </h4>'+
						'<input class="tcard-input" type="number" name="content'+skin+'_'+side+'[skills_percent'+thisElement+'][]" value="">'+
					'</div>'+
					'<div class="tcard-animation">'+
						'<h4>Delay:</h4>'+
					    '<input class="tcard-input" type="number" name="content'+skin+'_'+side+'[delay][]" value="">' +
					'</div>'+
				'</div>';

				var list = 
				'<div class="tcard-modal-item tcard_con_reg">' +
					'<div class="tcard-modal-item-inner">' +
						'<h4>Text: </h4>' +
						'<input class="tcard-input" type="text" name="content'+skin+'_'+side+'[list'+thisElement+'][]" value="">' +
						'<h4 class="tcard-remove-item"></h4>' +
					'</div>' +
					'<div class="tcard-animation">'+
						'<h4>Delay:</h4>'+
					    '<input class="tcard-input" type="number" name="content'+skin+'_'+side+'[delay][]" value="">' +
					'</div>'+
				'</div>';

				var socialButton =
				'<div class="tcard-modal-item">' +
					'<div class="tcard-modal-item-inner tcard_con_reg">' +
						'<input class="tcard-input" type="hidden" name="header'+skin+'_'+side+'[social_button_order'+thisElement+'][]" value="'+name+'">' +
						title+
						'<input class="tcard-input" type="text" placeholder="'+name+' username" name="header'+skin+'_'+side+'[social_button'+thisElement+'][]" value="">' +
						'<h4 class="tcard-remove-item"></h4>' +
					'</div>' +
				'</div>';

				function animations_in(){
					var html, animations_in = ['shake','headShake','swing','tada','wobble','jello','bounceIn','bounceInDown','bounceInLeft','bounceInRight',
						'bounceInUp','fadeIn','fadeInDown','fadeInDownBig','fadeInLeft','fadeInLeftBig','fadeInRight','fadeInRightBig','fadeInUp','fadeInUpBig',
						'flipInX','flipInY','lightSpeedIn','rotateIn','rotateInDownLeft','rotateInDownRight','rotateInUpLeft','rotateInUpRight','hinge',
						'jackInTheBox','rollIn','zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp','slideInDown','slideInLeft','slideInRight','slideInUp'
					];

					html = '<option></option>';
					for (var i = 0; i < animations_in.length; i++) {
						html += '<option value='+animations_in[i]+'>'+animations_in[i]+'</option>';

					}

					return html;
				}

				function animations_out(){
					var html, animations_out = ['shake','headShake','swing','tada','wobble','jello','bounceOut','bounceOutDown','bounceOutLeft','bounceOutRight',
						'bounceOutUp','fadeOut','fadeOutDown','fadeOutDownBig','fadeOutLeft','fadeOutLeftBig','fadeOutRight','fadeOutRightBig','fadeOutUp','fadeOutUpBig',
						'flipOutX','flipOutY','lightSpeedOut','rotateOut','rotateOutDownLeft','rotateOutDownRight','rotateOutUpLeft','rotateOutUpRight','hinge',
						'jackInTheBox','rollOut','zoomOut','zoomOutDown','zoomOutLeft','zoomOutRight','zoomOutUp','slideOutDown','slideOutLeft','slideOutRight','slideOutUp'
					];

					html = '<option></option>';
					for (var i = 0; i < animations_out.length; i++) {
						html += '<option value='+animations_out[i]+'>'+animations_out[i]+'</option>';

					}
					return html;
				}

				if(modalContent.hasClass('info_list')){
					$(listItem).appendTo(modalContent.find(".tcard-modal-sortable"));
				}
				else if(modalContent.hasClass('social_list') || modalContent.hasClass('contact') || modalContent.hasClass('register')){
					$(socialItem).appendTo(modalContent.find(".tcard-modal-sortable"));
				}
				else if(modalContent.hasClass('skills')){
					lastIten.last().before($(skillItem).appendTo(modalContent));
				}
				else if(modalContent.hasClass('list')){
					$(list).appendTo(modalContent.find(".tcard-modal-sortable"));
				}
				else if(modalContent.hasClass('social_button')){
					$(socialButton).appendTo(modalContent.find(".tcard-modal-sortable"));
				}

				window.onbeforeunload = function() { return true };
				
			},
			copy_shortcode: function(elm) {
				var range;
	            var selection;

	            if (window.getSelection) {
	                selection = window.getSelection();
	                range = document.createRange();
	                range.selectNodeContents(elm);
	                selection.removeAllRanges();
	                selection.addRange(range);
	            } else if (document.body.createTextRange) {
	                range = document.body.createTextRange();
	                range.moveToElementText(elm);
	                range.select();
	            }

				document.execCommand("Copy");
			},
			upload_image:function(){
	    		var frame = wp.media({
					title : 'Tcard Images Upload',
					multiple : false,
					library : { type : 'image' },
					button : { text : 'Insert' },
				});

	    		var thisBtn;
	    		$(document).on("click",".tcard-up-image",function(e){

				    frame.open();
				    thisBtn = $(this);
					return false;
				});

				frame.on( 'select', function() {
					var attachment = frame.state().get('selection').toJSON();
					if(attachment.length){
						if(thisBtn.parent(".right").length){
							thisBtn.parent().prev(".tcard-image-input").val(attachment[0].url);
						}else{
							thisBtn.prev(".tcard-image-input").val(attachment[0].url);
						}
					
						if(thisBtn.closest(".tcard-sidebar-item.image_loader").find(".arc_loader").length){
							thisBtn.closest(".tcard-sidebar-item.image_loader").find(".arc_loader").attr("src",attachment[0].url);
						}

						if(thisBtn.closest(".tcard-modal-content").hasClass("image_button")){

							thisBtn.closest(".tcard-element.image_button").find(".tcard-avatar-src").attr("src",attachment[0].url);
						}
						else{

							thisBtn.closest(".tcard-modal-content").find(".tcard-profile-image").css("display","block")
							thisBtn.closest(".tcard-modal-content").find(".tcard-profile-image img").attr("src",attachment[0].url)
						}
						
					}
					return false;
				});	

				$(".tcard-image-input").on("change",function(){
					$(this).closest(".tcard-modal-content").find(".tcard-profile-image").css("display","block")
					$(this).closest(".tcard-modal-content").find(".tcard-profile-image img").attr("src",$(this).val());
	    		});
			},
			gallery: function(){

				var frame = wp.media({
					title : 'Tcard Multiple Images Upload',
					multiple : true,
					library : { type : 'image' },
					button : { text : 'Insert into gallery' },
				});

				var thisBtn;
				$(document).on("click",".tc-multiple-images",function(){

					frame.open();
					thisBtn = $(this);
					return false;
				});

				frame.on( 'select', function() {
					var attachment = frame.state().get('selection').toJSON();
					if(attachment.length){
						for (var i = 0; i < attachment.length; i++) {
							var boxImg = 
							'<div class="tcg-box" style="background-image: url('+attachment[i].url+')">'+
								'<input type="hidden" name="tcg_gallery'+ thisBtn.closest(".tcard-row").index() +'[image][]" value='+attachment[i].url+'>'+
								'<div class="remove-tcg-img"></div>' +
							'</div>';
							thisBtn.closest(".tcard-gallery").find(".gallery").append(boxImg);
						}
					}
					return false;
				});

				var oldUser;
				$(document).on("focusin",".assigns-tcard-gallery select",function(){
					oldUser = this.value
				});

				$(document).on("change",".assigns-tcard-gallery select",function(){
					if($(this).val() !== oldUser){
						$(this).closest(".tcard-gallery").find(".gallery").remove();
						if($(this).val().length || !$(this).val().length){
							$(this).closest(".tcard-gallery").append('<div class="gallery"></div>');
							sort_gallery();							
						} 
					}

					if($(this).val()){
						$(this).closest(".tcard-gallery").find(".tc-multiple-images").remove();
					}else{
						var gallery_btn = '<span class="tc-multiple-images"><i class="fas fa-cloud-upload-alt"></i></i></span>';
						$(this).closest(".tcard-gallery").find(".tcard-gallery-bar").append(gallery_btn)
					}
					window.onbeforeunload = function() { return true };
				});

				$(document).on("click",".remove-tcg-img",function(){
					$(this).closest(".tcg-box").remove();
				});

				$(document).on("change",".thumbnail-name select",function(){
					var skin = $(this).closest(".tcard-row").index(),
					thumb_name = '<input class="thumbnail_title" type="text" name="tcg_gallery'+skin+'[thumbnail_title]" value="">';

					if($(this).val() == "thumbnail_title"){
						$(this).parent().append(thumb_name);
					}else{
						$(this).parent().find(".thumbnail_title").remove();
					}
					window.onbeforeunload = function() { return true };
				});

				function sort_gallery(){
					$(".tcard-gallery .gallery").sortable({
						opacity: 0.8,
						cursor: "move",
						delay:100,
						placeholder: "tcg-highlight",
						start: function(event, ui) {
							$(".tcg-highlight").height(ui.item.outerHeight())
					    }
					});
				}
				sort_gallery();
			},
			tcardSlider: function(){
				var count = -1;
				$(document).on("click",".tcard-add-slide",function(){
					var thisBtn = $(this),
					modalContent = thisBtn.closest('.tcard-modal-body').find(".tcard-modal-content.slider"),skin,side,elemNumber;

					if(modalContent.find(".slider_container").length){
						count = modalContent.find(".slider_container").length - 1;
						count++;
					}else if(!modalContent.find(".slider_container").length){
						count = 0;
					}
					else{
						count++;
					}
					
					elemNumber = thisBtn.attr('data-itemnum');
					skin = thisBtn.closest(".tcard-row").index();

					var tcardside = thisBtn.closest(".tcard-main-elem");

					if(tcardside.hasClass("front-side")) side = "front";
						else side = "back";

					var menu = '<div class="tcard-modal-item slider-menu-modal"></div>';

					var manuItem = '<div class="settings-btn" data-menu-container="slide_'+count+'">Slide'+ (count + 1) +'</div>';

					if(!modalContent.find(".slider-menu-modal").length){
						modalContent.append(menu);
					}
					modalContent.find(".slider-menu-modal").append(manuItem);
					var firstBtn = modalContent.find(".slider-menu-modal").find(".settings-btn").first();
					if(!firstBtn.hasClass("curr")){
						firstBtn.addClass("curr");
						firstBtn.addClass("tc-current-side");
					}
			
					var slide = 
					'<div class="tcard-modal-container slider_container" data-modal-container="slide_'+count+'">'+
						'<input type="hidden" name="content'+ skin + "_" + side +'[slider_items_order'+elemNumber+'][]" value="slide_'+count+'">'+
						'<div class="tcard-remove-slide" data-remove-slide="slide_'+count+'">Remove Slide</div>'+
						'<div class="tcard-modal-item">'+
							'<h4>Title:</h4>'+ 
							'<input class="tcard-input" type="text" name="content' + skin + "_" + side +'[slider_item_title'+elemNumber+'][]" value="">'+
						'</div>'+

						'<div class="tcard-modal-item">'+
							'<h4 class="tc-modal-editor-title">Description:</h4>'+ 
							'<textarea id="tc-content-editor-'+side+ "slider" + skin + elemNumber + count +'" class="tcard-textarea tc-new-editor tcard-input" type="text" name="content' + skin + "_" + side +'[slider'+elemNumber+'][]"></textarea>'+
						'</div>'+

						'<div class="tcard-modal-item">'+
							'<div class="tcard-modal-item-inner">'+
								'<h4>Button Text: </h4>'+ 
								'<input class="tcard-input" type="text" name="content' + skin + "_" + side +'[slider_btntext'+elemNumber+'][]" value="">'+
							'</div>'+
							'<div class="tcard-modal-item-inner">'+
								'<h4>Button Link:</h4>'+
								'<input class="tcard-input" type="text" name="content' + skin + "_" + side +'[slider_btnlink'+elemNumber+'][]" value="">'+
							'</div>'+
						'</div>'+				
					'</div>';

					modalContent.append(slide);
					var slider_container = modalContent.find(".slider_container").first();

					if(!slider_container.hasClass("curr")){
						slider_container.addClass("curr")
						slider_container.css("display",'block');
					}

					modalContent.find(".tcard-textarea").each(function(){
						if($(this).hasClass("tc-new-editor")){
							wp.editor.remove($(this).attr('id'));
							Tcard.add_wp_editor(".tcard-textarea.tc-new-editor");
							$(this).removeClass("tc-new-editor")
						}
					});					
				});

				$(document).on("click",".tcard-remove-slide",function(){
					var thisBtn = $(this),
						menuItem = thisBtn.closest('.tcard-modal-body').find(".settings-btn.tc-current-side");

					if(menuItem.next().length){
						menuItem.next().addClass("tc-current-side");
					}else{
						menuItem.prev().addClass("tc-current-side");
					}
					
					menuItem.remove();
					
					if(thisBtn.parent(".slider_container").next().length){
						thisBtn.parent(".slider_container").next().fadeIn();
					}else{
						thisBtn.parent(".slider_container").prev().fadeIn();
					}	
					thisBtn.parent(".slider_container").remove();

					var modal = $('.tcard-modal.is-open');
					for (var i = 0; i < modal.find(".slider_container").length; i++) {
						modal.find(".settings-btn").eq(i).attr('data-menu-container','slide_' + i).text("Slide" + (i + 1));
						modal.find(".slider_container").eq(i).attr('data-modal-container','slide_' + i);
						modal.find(".slider_container").eq(i).find('.tcard-remove-slide').attr('data-remove-slide','slide_' + i);
					}
				});
			}
		}

		Tcard.settings($(".tcard-modal-body.settings-skin"));
 		Tcard.sortable();
 		Tcard.add_wp_editor(".tcard-textarea");
		Tcard.mainElements();
 		Tcard.upload_image();
 		Tcard.gallery();
 		Tcard.tcardSlider();

		var TcardAjax = {
			add_skin: function(type_action,nameSkin,numberSkin,skinCloned){
				stopClick = true;

				var data = {
			      action: 'tcard_add_skin',
			      security: tcard.add_skin,
			      group_id: tcard.group_id,
			      type_action: type_action,
			      nameSkin: nameSkin,
			      startCount: numberSkin - 1,
			      stopCount: numberSkin,
			      skinCloned: skinCloned
			    };

			    $(".spinner").css("visibility","visible");

				$.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success:function(data){
			 
			            if(type_action == "clone-skin"){
			            	$(data).appendTo(".tcard-container-skins").addClass("cloned-settings").find(".skin-cloned-after")
			            	.html('<i class="fas fa-clone"></i> ' + nameSkin + "." + (skinCloned + 1));
			            }else{
			            	$(data).appendTo(".tcard-container-skins").addClass("cloned-settings");
			            }
			      
		            	$(".spinner").css("visibility","hidden");
	            		Tcard.mainElements();
	            		Tcard.add_wp_editor($(data).find(".tcard-textarea"));

						Tcard.settings($(".cloned-settings .tcard-modal-body.settings-skin"));
						$(".tcard-row").removeClass("cloned-settings");
	            		if($(".tcard-container-skins").hasClass("customSkin")){
	            			Tcard.sortable();
		            		$(".modal-post-content").sortable({
								opacity: 0.8,
								cursor: "move",
								delay:100,
							});	
	            		}
						stopClick = false;
					
		            },
		            error: function(error){
		            	alert("Skin could not load");

		            	if(!$(".tcard-row").eq(number).length){
							number = number - 1;
						}else{
							number = numberSkin - 1;
						}

		            	$(".tcard-count-skin").find("span").text(number)
						$(".tc-add-new-skin").find("input").val(number);
						TcardAjax.delete_skin(number,$(".tcard-row").length);
		            }
		        });
			},
			delete_skin: function(thisSkin,skins_number){

				var data = {
			      action: 'tcard_delete_skin',
			      security: tcard.delete_skin,
			      group_id: tcard.group_id,
			      skin_key: thisSkin,
			      skins_number: skins_number
			    };

				$.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success:function(success){
						window.onbeforeunload = function() { return true };
		            },
		            error: function(){
		            	alert("No skin-"+ thisSkin +" found")
		            }
		        });
			},
			select_skin: function(skin_type){
				var data = {
			      action: 'tcard_select_skin',
			      security: tcard.select_skin,
			      group_id: tcard.group_id,
			      group_name: $('.tcard-group-title').val(),
			      skin_type: skin_type
			    };

			    $.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success:function(){
		            	window.onbeforeunload = null;
			            location.reload();
		            },
		            error: function(){
		     			 alert("File missing!")
		            }
		        });
			},
			add_element: function(parent,element,side,skinIndex,thisBox,nextElem){
				var data = {
			      action: 'tcard_add_element',
			      security: tcard.add_element,
			      tc_parent: parent,
			      tc_element: element,
			      skin_side: side,
			      skin_index: skinIndex,
			      group_id: tcard.group_id,
			      elemNumber: thisBox.find(".tcard-element." + element).length
			    };

			    $(".spinner").css("visibility","visible");

			    $.ajax({
		            url: ajaxurl,
		            type: 'GET',
		            data: data,
		            success:function(data){ 
		            
	            		if(nextElem.length){
	            			nextElem.before($(data).appendTo(thisBox));
		            	}else{
		            		$(data).appendTo(thisBox).addClass("new-element_maybe");

		            	}
		            	$(".spinner").css("visibility","hidden");

		            	Tcard.add_wp_editor($(data).find(".tcard-textarea"));
		            	$(".modal-post-content,.tcard-modal-sortable").sortable({
							opacity: 0.8,
							cursor: "move",
							delay:100,
						});	

		            	window.onbeforeunload = function() { return true };
		            },
		            error: function(){
		     			alert("The element can not be loaded!")
		            }
		        });
			}
		}
	});
})( jQuery );