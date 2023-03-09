/* 
 Author: Cloanta Alexandru
 Name: Tcard Wordpress
 Version: 2.8.9
*/

(function( $ ) {
    'use strict';

    $(document).on("ready",function(){

        var el = wp.element.createElement,
            registerBlockType = wp.blocks.registerBlockType;
            

        $.each(tcard_block['groups'],function(type){

            var bgColor,icon;

            if(type == "tcard"){
                bgColor = '#a475eb';
                icon = 'index-card';
            }else{
                bgColor = '#f62688';
                icon = 'image-filter';
            }
  
            var category_block = JSON.parse(tcard_block['groups'][type]),
                blockStyle = { backgroundColor: bgColor , color: '#fff', padding: '10px', textAlign: "center", textTransform: "capitalize" };
        
            $.each(category_block,function(key,group){

                registerBlockType( 'tcard/'+type+'-group-'+group['group_id']+'', {
                    title: group['title'],
                    icon: {
                        background: '#fff',
                        foreground: bgColor,
                        src: icon
                    },
                    category: type,
                    edit: function() {
                        return el( 'p', { style: blockStyle }, ''+type+' - '+group['title']+'' );
                    },
                    save: function() {
                        return el( "", "", '['+type+' group_id="'+group['group_id']+'"]' );
                    },
                });

            });

        })
    });

})( jQuery );