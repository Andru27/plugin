/* 
 Author: Cloanta Alexandru
 Name: Tcard > Arcfilter Wordpress
 Version: 2.9.1
*/

(function( $ ) {
	'use strict';

	$(document).on("ready",function(){

		var stopClick = false;

		var number = 0;

		$(".group-settings .select_category_type").on("change",function(){
			ArcfilterAjax.select_category($(this).val());
		})

		$(".add-arcfilter-cat").on("click",function(e){
			if(!$(".select-tcard-group select").val()){

				alert("Please create a group");
				$(this).find("input").val('')
				return;
			}
			else{

				if(stopClick) return;
				if($(this).find("input").val() > 0){
					number = $(this).find("input").val();
				}
				number++;
				$(".arcfilter-count-cat").find("span").text(number)
				$(this).find("input").val(number);

				var category = $(".category_box").length;

				ArcfilterAjax.add_category(number);
			}
			
		});

		$(".add_attr_wc").on("click",function(){
			var name = $(this).next(".tcard-input").val();
			var label = $(this).next(".tcard-input").find("option:selected").attr('data-label');

			var attr = '<div class="wc_get_attribute">'+
			 		'<input type="hidden" class="tcard-input" name="group_set[wc_sidebar_attribute][name][]" value="'+name+'">'+
			 		'<input type="hidden" class="tcard-input" name="group_set[wc_sidebar_attribute][label][]" value="'+label+'">'+
			 		'<span class="remove_attr_wc"></span>'+
	 			'<h4>'+label+'</h4>'+
	 		'</div>';

	 		$(".wc_get_attributes").append(attr);
		});

		$(document).on("click",".remove_attr_wc",function(){
			$(this).closest(".wc_get_attribute").remove();
		});

		$(".wc_get_attributes").sortable({
			opacity: 0.8,
			cursor: "move",
			delay:100,
			placeholder: "tcard-highlight",
			start: function(event, ui) {
				$(".tcard-highlight").height(ui.item.outerHeight())
				.width(ui.item.outerWidth())
		    }
		}).disableSelection();

		$(".tcard-up-default").on("click",function(){
			var parent = $(this).closest(".tcard-sidebar-item.image_loader");
			parent.find(".tcard-image-input").val("")
			parent.find(".arc_loader").attr("src",parent.find('.arc-default-loader').val())
		});

		$(document).on("change",".price_type",function(){
			if($(this).val() == "normal"){
				$(this).closest(".filter-options").find(".group_price").slideDown(300);
			}else{
				$(this).closest(".filter-options").find(".group_price").slideUp(300);
			}
		});

		$(".arc_bar_cat").on("click",function(e){

				if (e.target != this)
					return;
			var tcardArrow = $(this).find("input.tcard_check");
			$(this).next(".arc_container").slideToggle(); 

			(tcardArrow.prop("checked")) ? tcardArrow.prop("checked",false) : tcardArrow.prop("checked",true);
		})

		var lst, oldIndex;
		$(".arcfilter-categories .arc_container").sortable({
			opacity: 0.8,
			cursor: "move",
			delay:100,
			placeholder: "tcard-highlight",
			start: function(event, ui) {
				$(".tcard-highlight").height(ui.item.outerHeight())
				.width(ui.item.outerWidth())

				for (var i = 0; i <  $(".category_box").length; i++) {
					$(".category_box").eq(i).attr("data-index",i)
				}

				oldIndex = ui.item.index();
		    },
		    update: function(event, ui){
				$(".category_box").each(function(){
					var oldOrder = parseInt($(this).attr("data-index"));
					var newOrder = $(this).index();
					$(this).find(".tcard-input").each(function(){
						var setOrder = $(this).attr("name").replace(oldOrder,newOrder)
        				$(this).attr("name",setOrder);
					});
				});

		    	lst = $(this).closest(".arcfilter-container_main").attr('id');
		    	$('#arcfilter-items div.arcfilter-row').each(function(i){
	        		$(this).attr('data-index',i)
				});
		        var newIndex = ui.item.index();
		        if (newIndex > oldIndex) {
		            $('#arcfilter-items div.arcfilter-row:eq(' +oldIndex+ ')').insertAfter('#arcfilter-items div.arcfilter-row:eq(' +newIndex+ ')');
		        }else{
		            $('#arcfilter-items div.arcfilter-row:eq(' +oldIndex+ ')').insertBefore('#arcfilter-items div.arcfilter-row:eq(' +newIndex+ ')');
		        }
	        	$('#arcfilter-items div.arcfilter-row').each(function(i){
					var oldOrder = parseInt($(this).attr("data-index"));
					var newOrder = $(this).index();
					$(this).find(".tcard-input").each(function(){
						var setOrder = $(this).attr("name").replace(oldOrder,newOrder)
        				$(this).attr("name",setOrder);
					});
				});
		    }
		}).disableSelection();

		$(document).on("click",".arc-open-modal",function(){
			var thisBtn = $(this);
			$(this).next(".tcard-modal").fadeIn().addClass("is-open");
		});

		$(".clear-random").on("click",function(){
			$(".animations-random").val("");
		});

		$(".tcard-input.type_of_display").each(function(){
			if($(this).val() == "button"){
				$(".tcard-sidebar-item.group-settings.more_items").addClass("active");
			}
		})

		$(".type_of_display").on('change',function(){
			if($(this).val() !== ""){
				$(".tcard-sidebar-item.group-settings.first_items").slideDown(200);
			}else{
				$(".tcard-sidebar-item.group-settings.first_items").slideUp(200);
				$(".tcard-sidebar-item.group-settings.first_items .tcard-input").val("");
			}
			if($(this).val() == "button" || $(this).val() == "scroll"){
				$(".tcard-sidebar-item.group-settings.more_items").slideDown(200);
			}else{
				$(".tcard-sidebar-item.group-settings.more_items").slideUp(200);
				$(".tcard-sidebar-item.group-settings.more_items .tcard-input").val("");
			}

			if($(this).val() == "pagination"){
				$(".display_items_hidden").find("option.remove_op").remove();
				$(".no_page").slideDown(200);
				$(".all_cat").slideDown(200);
				$(".arrow_pagination").slideDown(200);
			}else{
				$(".display_items_hidden").append('<option class="remove_op" value="hidden">Hidden</option>');
				$(".no_page").slideUp(200);
				$(".all_cat").slideUp(200);
				$(".arrow_pagination").slideUp(200);
				$(".arrow_pagination").find(".tcard-input[type=text]").val("")
				$(".all_cat,.no_page").find(".tcard-input[type=checkbox]").each(function(){
					$(this).prop("checked",false);
				});
			}

		});

		$(".select_wc_method").on("click",function(){
			var method = $(this).attr('data-method'),
			title = $(this).text(),
			catIndex = $(this).attr("data-itemnum");

			if(method == "name" || method == "short_description"){

				if(method == "short_description"){
					var max_words = 17;
				}else{
					max_words = '';
				}

				var html = 
				'<div class="tc_post_item '+method+'">'+
					'<input class="tcard-input" type="hidden" name="cat_items'+catIndex+'[post_item][]" value="'+method+'">'+
					'<div class="remove-post-item"></div>'+
					'<h4>'+title+'</h4>'+
					'<span>Max words</span>'+ 
			    	'<input class="tcard-input" type="number" placeholder="'+max_words+'" name="cat_items'+catIndex+'[set_item]['+method+']" value="">'+
			    '</div>';

			}else if(method == "image"){

				html = 
				'<div class="tc_post_item '+method+'">'+
					'<input class="tcard-input" type="hidden" name="cat_items'+catIndex+'[post_item][]" value="'+method+'">'+
					'<div class="remove-post-item"></div>'+
					'<h4>'+title+'</h4>'+
					'<span>Change image on hover</span>'+ 	
					'<div class="tc-check-settings hover_image">'+
					  '<input id="hover_image'+catIndex+'" type="checkbox" name="cat_items'+catIndex+'[set_item]['+method+']" value="1">'+
					  '<label for="hover_image'+catIndex+'"></label>'+
					'</div>'+
			    '</div>';

			}else if(method == "group"){

				html = 
				'<div class="tc_post_item '+method+'">'+
					'<input class="tcard-input" type="hidden" name="cat_items'+catIndex+'[post_item][]" value="'+method+'">'+
					'<div class="remove-post-item"></div>'+
					'<h4>'+title+'</h4>'+
					'<span>Change image on hover'+ 
						'<div class="tc-check-settings hover_image">'+
						  '<input id="group_hover_image'+catIndex+'" type="checkbox" name="cat_items'+catIndex+'[set_item]['+method+']" value="1">'+
						  '<label for="group_hover_image'+catIndex+'"></label>'+
						'</div>'+
						'Badges: <span class="group_badges">'+
						    'Sale, Out of stock, Featured'+
						'</span>'+
					'</span>'+
				'</div>';

			}else if(method !== "is_on_sale" && method !== "featured" && method !== "out_of_stock" && 
				method !== "price" && method !== "add_to_cart" && method !== "rating"){
				html = 
				'<div class="tc_post_item '+method+'">'+
					'<input class="tcard-input" type="hidden" name="cat_items'+catIndex+'[post_item][]" value="'+method+'">'+
					'<div class="remove-post-item"></div>'+
					'<h4>'+title+'</h4>'+
					'<span>Text</span>'+
			    	'<input class="tcard-input" type="text" placeholder="'+title+'" name="cat_items'+catIndex+'[set_item]['+method+']" value="">'+
			    '</div>';
			}else{
				html = 
				'<div class="tc_post_item '+method+'">'+
					'<input class="tcard-input" type="hidden" name="cat_items'+catIndex+'[post_item][]" value="'+method+'">'+
					'<div class="remove-post-item"></div>'+
					'<h4>'+title+'</h4>'+
			    '</div>';
			}
			$(html).appendTo($(this).closest(".tcard-modal-content").find(".modal-post-content.arcfilter_item_post"));
		});

		$(document).on("click",".arc-delete-category",function(){

			for (var i = 0; i < $(".category_box").length; i++) {
				$(".category_box").eq(i).attr("data-index",$(".category_box").eq(i).index());
			}

			$(".arcfilter-items .arcfilter-row").eq($(this).closest(".category_box").index()).remove();
			$(this).closest(".category_box").remove();
			
			$(".category_box").each(function(){
				var oldOrder = parseInt($(this).attr("data-index"));
				var newOrder = $(this).index();
				$(this).find(".tcard-input").each(function(){
					var setOrder = $(this).attr("name").replace(oldOrder,newOrder)
    				$(this).attr("name",setOrder);
				});
			});	

			$(".arcfilter-count-cat span").text($(".category_box").length);
			$(".add-arcfilter-cat input").val($(".category_box").length);
		});

		$(".select_style_items.tcard-input").on("change",function(){
			$("#tcard-save").trigger("click");
		});

		$(".open-wc-advanced-filter").on("click",function(){
			$(this).toggleClass("active");
			$(".wc-advanced-filter").toggleClass("active");
		});

		$(".advanced-filter-type .filter-head").on("click",function(){
			$(this).next(".filter-options").slideToggle(300);
		})

		var ArcfilterAjax = {
			select_category: function(category_type){
				var data = {
			      action: 'arcfilter_select_category',
			      security: arcfilter.select_category,
			      group_id: arcfilter.group_id,
			      category_type: category_type
			    };
			    
			    $(".spinner").css("visibility","visible");

			    $.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success:function(data){
		          		$(".spinner").css("visibility","hidden");
		          		location.reload();
		            },
		            error: function(error){
		            	alert("Category type could not be saved");
		            }
		        });
			},
			add_category:function(number){
				
				stopClick = true;

				var data = {
			      action: 'arcfilter_add_category',
			      security: arcfilter.add_category,
			      group_id: arcfilter.group_id,
			      number: number - 1,
			      category_id: $(".group-settings .category_type").val(),
			      category_type: $(".group-settings .select_category_type").val(),
			      category_slug: $(".group-settings .category_type option:selected").attr("data-slug"),
			      category_name: $(".group-settings .category_type option:selected").attr("data-title"),
			      category_items: $(".group-settings .category_type option:selected").attr("data-items"),
			    };

			    $.ajax({
		            url: ajaxurl,
		            type: 'POST',
		            data: data,
		            success:function(data){
		  
		            	var html = JSON.parse(data);

			            $(".spinner").css("visibility","visible");
			            $(".arcfilter-categories .arc_container").append(html['category']);
			            $(".arcfilter-items").append(html['items']);
			            $.when(data).promise().done(function(){
			            	$(".spinner").css("visibility","hidden");
			            	
							stopClick = false;
							window.onbeforeunload = function() { return true };
						});
		            },
		            error: function(error){
		            	alert("Category could not load");

		            	if(!$(".category_box").eq(number).length){
							number = number - 1;
						}else{
							number = numberSkin - 1;
						}

		            	$(".arcfilter-count-cat").find("span").text(number)
						$(".add-arcfilter-cat").find("input").val(number);
			
		            }
		        });

			}
		}

	});
})( jQuery );