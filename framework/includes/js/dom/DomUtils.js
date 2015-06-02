(function($) {

var methods = {
    getDimension: function() {
        var $this = $(this);
        var offset = $this.offset();
        return {left: offset.left + "px", top: offset.top + "px", width: $this.outerWidth() + "px", height: $this.outerHeight() + "px"};
    },
    appearIn: function() {
        var $this = $(this);
        $this.css('display', 'block');
        
        var dim = $this.data('oriDim');
        var width = (dim)? dim.width : 'auto';
        
        $this.animate({width: width, opacity:1}, 1000, function(){});
    },
    appearOut: function() {
        var $this = $(this);
        var dimen = methods.getDimension.apply(this);
        $this.data('oriDim', dimen);
        $this.animate({width: 0, opacity:0}, 1000, function(){ 
            $this.css('display', 'none');
        });
    },
    scrollIn: function() {
        var $this = $(this);
        var dim = $this.data('oriDim');
        
        if(!dim) {
            var elem = $this.clone().css({height:"auto", width:"auto"}).appendTo("body");
            dim = methods.getDimension.apply(elem);
            elem.remove();
            $this.data('oriDim', dim);
        }
        $this.css('display', 'block');
        $this.css('height', '0px');
        $this.animate({height: dim.height}, 1000, function(){});
    },
    scrollOut: function() {
        var $this = $(this);
        var dimen = methods.getDimension.apply(this);
        $this.data('oriDim', dimen);
        $this.animate({height: 0, opacity:0}, 1000, function(){ 
            $this.css('display', 'none');
        });
    }
};

$.fn.DomUtils = function(method, options) {
    if(methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if(!method) {
        return methods;
    } else {
        return 'Error: Not a recognize function!';
    }
};
    
})(jQuery);
