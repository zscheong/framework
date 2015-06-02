(function($) {
  
    Popup = function(args) {
        return new _Popup(args);
    };
    
    //Constructor function
    var _Popup = function(args) {
        this.default = {
            content: "",
            title: "Popup"
        };
        
        this.options = $.extend({}, this.default, args); 
        return this;
    };
            
    //definition        
    _Popup.prototype = {
        templateOverlay: '<div id="pop-overlay" style="width:100%;height:100%;background: rgb(0,0,0);opacity:0.6;z-index:99;position:absolute;top:0px;"></div>',
        templateContent: '<div id="pop-content" style="margin:auto;background: white;z-index:100;position:absolute;padding:10px;"></div>',
        template: '<div id="template" style="margin:auto;width:300px;top:30px;background: rgb(255, 255, 255);z-index:100;position:absolute"></div>',
        run: function() {
            $('body').append(this.templateOverlay);
            $('body').append(this.templateContent);
            $('body').append(this.template);
            
            var elem = $('body').find('#pop-content');
            elem.append(this.options.content);
            
            var dim = elem.DomUtils('getDimension');
            $.extend(dim, {left: '0px', top: '0px', right: '0px', bottom: '0px'});
            elem.css(dim);
            
//            var position = elem.position();
//            var dimension = {width: elem.outerWidth(), height: elem.outerHeight()};
            
//            var template = $('body').find('#template');
//            template.append('<span>Left: ' + dim.left + ', Top: ' + dim.top + '</span>');
//            template.append('<span>Width: ' + dim.width + ', Height: ' + dim.height + '</span>');
            
            //alert("title: " + this.options.title + ", contents: " + this.options.content);
        }
    };
    
    
})(jQuery);
