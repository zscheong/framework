//Input Animation
(function ($, w) {
   $.fn.jinput = function() {
       this.each(function() {
          var $parent = $(this).parent();
          var width = $(this).outerWidth();
          $(this).addClass('input-anim');
          $parent.append("<span class='highlight'></span>");
          $parent.append("<span class='bar' style='width:"+width+"px'></span>");
       });
   } 
}) (jQuery, window);

//Ripple Effect
(function ($, w) {
    
    $.fn.jclick = function() {
        this.each(function() {
            var $this = $(this);
            $this.addClass('ripple-container');
            $this.append("<div class='ripple'></div>");
        });
        
        this.click(function(e) {
            var $this = $(this);
            
            var offset = $this.offset();
            var relativeX = e.pageX - offset.left;
            var relativeY = e.pageY - offset.top;
            var width = $this.width();
            
            var $ripple = $this.find('.ripple');
            $ripple.addClass('notransition');
            $ripple.css({left: relativeX, top: relativeY});
            $ripple.removeClass('notransition');
            
            $this.addClass('grow');
            $ripple.css({"width": width * 2, "height": width * 2, "margin-left": -width, "margin-top": -width});
            
            setTimeout(function() {
               $ripple.addClass('notransition'); 
               $ripple.attr("style", "");
               $ripple[0].offsetHeight;
               $this.removeClass('grow');
               $ripple.removeClass('notransition');
            }, 300);
        });
    };
})(jQuery, window);