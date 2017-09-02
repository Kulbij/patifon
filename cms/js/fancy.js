$(document).ready(function() {
    $("a[rel=images]").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over'/*
            'showCloseButton' : true,
            'padding': 0,
            "centerOnScroll" : true,
            'autoScale' : false*/
 });
 
 $("a[rel=dialog]").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over',
            'showNavArrows': false,
            'onClosed': function() {
                
                clearInterval(intID);
                
                $('.imgareaselect-selection').parent().remove();
        
                $('.imgareaselect-border1').remove();
                $('.imgareaselect-border2').remove();
                $('.imgareaselect-border3').remove();
                $('.imgareaselect-border4').remove();
                $('.imgareaselect-handle').remove();
                $('.imgareaselect-outer').remove();
                
            }
            /*
            'showCloseButton' : true,
            'padding': 0,
            "centerOnScroll" : true,
            'autoScale' : false*/
 });
 
 $("a[rel=main_img]").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over',
            'showNavArrows': false,
            'onClosed': function() {
                
                clearInterval(intID);
                
                $('.imgareaselect-selection').parent().remove();
        
                $('.imgareaselect-border1').remove();
                $('.imgareaselect-border2').remove();
                $('.imgareaselect-border3').remove();
                $('.imgareaselect-border4').remove();
                $('.imgareaselect-handle').remove();
                $('.imgareaselect-outer').remove();
                
            }
            /*
            'showCloseButton' : true,
            'padding': 0,
            "centerOnScroll" : true,
            'autoScale' : false*/
 });
 
});