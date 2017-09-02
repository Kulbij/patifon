function initial_tiny() {
tinyMCE.init({    
        
       language : "ru",
        // General options
        mode : "specific_textareas",
        theme : "simple",
        //theme : "advanced",
        //elements: "address_text",
        editor_selector: "address_text",
        file_browser_callback : "tinyBrowser",
        force_br_newlines : true,
        forced_root_block : '',
        entity_encoding : "raw",
        plugins : "spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,jaretypograph",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage,jaretypograph",
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
}

initial_tiny();

function add_Revard() {
    tinyMCE.execCommand("mceAddControl", false, 'optovick_ru');
    tinyMCE.execCommand("mceAddControl", false, 'optovick_en');
    tinyMCE.execCommand("mceAddControl", false, 'cool_ool');
}