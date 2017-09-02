tinyMCE.init({    
        
       language : "ru",
        // General options
        mode : "exact",
        //theme : "simple",
        theme : "advanced",
        elements: "text_form, text_form_, text_form__, text_form___",
        file_browser_callback : "tinyBrowser",
        force_br_newlines : true, 
        forced_root_block : '',
        entity_encoding : "raw",
        plugins : "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,jaretypograph",

        // Theme options

        theme_advanced_buttons1 : "save,newdocument,|,paste,pastetext,pasteword,|,undo,redo,|,bold,italic,underline,strikethrough,|,sub,sup,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,backcolor,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "tablecontrols,|,link,unlink,anchor,image,media,charmap,nonbreaking,|,styleprops,attribs,|,jaretypograph,removeformat,cleanup,spellchecker,|,visualaid,fullscreen,code",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "default",
        skin_variant : "silver",
        
        relative_urls: false,
        remove_script_host: false,
        convert_urls: false

});