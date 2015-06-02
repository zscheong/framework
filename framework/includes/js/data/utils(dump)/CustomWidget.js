//Static Menu Definition
(function(window, document, $, undefined){
    var methods = (function() {
        //private method
        var c = {
            ulClass: 'sm-Container',
            inactiveClass: 'sm-Inactive',
            activeClass: 'sm-Active'
        };
        applyHandler = function($el) {
            $el.click(function() {
                var $this = $(this);
                var sib = $this.siblings();
                sib.removeClass(c.inactiveClass + " " + c.activeClass)
                    .addClass(c.inactiveClass);
                $this.removeClass(c.inactiveClass + " " + c.activeClass)
                    .addClass(c.activeClass);
                onclick.call(this);
            });
        };
        return {
          //public method
          init: function(op) {
              var $this = $(this);
              $this.addClass(c.ulClass);
              var $child = $this.find("li");
              var active = op.name || '';
              onclick = op.onclick || $.noop;
              
              $child.each(function(i, v){
                 var $el = $(v);
                 var content = $el.text();
                 
                 if(active === content) {
                     $el.addClass(c.activeClass);
                 } else {
                    if(active === "" && i === 0) {
                        $el.addClass(c.activeClass);
                    } else {
                        $el.addClass(c.inactiveClass);
                    }
                 }
                 applyHandler($el);
              });
              return this;
          }
        };
    })();
    
    var selector;
    var onclick;
    $.fn.StaticMenu = function(method, opts) {
        selector = this.selector || '';
        if(methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            return $.error('Method ' + method + ' does not exist!');
        }
    };
})(window, document, jQuery);

//Modal Window Definition
(function(window, document, $, undefined){
    var methods = function() {
        //private methods
        var tpl = {
          container: '<div class="mw-Container"></div>',
          content: '<div class="mw-Content"></div>'
        };
        createTemplate = function(el) {
            $('body').append(tpl.container);
            $('.mw-Container').append(tpl.content);
            
            var option = el.data('mw-options');
            var contDiv = $('.mw-Content');
            contDiv.css('width', option.width);
            contDiv.css('height', option.height);
            el.appendTo(contDiv);
            var content = option.content || '';
            if(content !== '') {
                contDiv.append(content);
            }
            el.show();
        };
        applyHandlers = function(el) {
            el.find('form').ajaxForm({
                success: function(response, status, xhr, $form ) {
                    alert('status: ' + status + '\n\responseText: ' + response);
                    el.ModalWin('close');
                }
            });
            $('.mw-Container').click(function() {
               el.ModalWin('close'); 
            });
            $('.mw-Content').click(function(event) {
               event.stopPropagation(); 
            });
        };
        return {
            show: function() {
              var $this = $(selector);
              var op = $this.data('mw-options');
              var contDiv = $this.closest('.mw-Content');
              contDiv.stop(true, true).animate(op.animation, op.speed, function() {
              });
              return $this;
            },
            close: function() {
                var $this = $(selector);
                $this.appendTo('body');
                $('.mw-Content').remove();
                $('.mw-Container').remove();
                $this.find('form').resetForm();
                $this.hide();
                $this.removeData('mw-options');
            },
            //public methods
            init: function(options) {
                var $this = $(this);
                if($this.data('mw-options')) {
                    return false;
                }
                var op = $.extend({}, $.fn.ModalWin.defaults, options);
                $this.data('mw-options', op);
                $this.css('height', 'auto');
                
                createTemplate($this);
                applyHandlers($this);
                $this.ModalWin('show');
                return $this;
            }
        };
    }();
    
    var selector;
    $.fn.ModalWin = function(method, args) {
        selector = this.selector || '';
        if(methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || !method) {
            return methods.init.apply(this, arguments);
        } else {
            return $.error("Method " + method + " does not exist!");
        }
    };
    $.fn.ModalWin.defaults = {
        width: '600px',
        height: '480px',
        animation: {opacity: 1.0},
        speed: 1000,
        content: ''
    };
})(window, document, jQuery);

//NavBar
(function(window, document, $, undefined) {
    var methods = function() {
        return {
            init: function(op) {
                
            }
        };
    }();
    $.fn.NavBar = function(method, options) {
        if(methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if(typeof(method) === "object" || !method) {
            return methods.init.apply(this, arguments);
        } else {
            return $.error("Methods " + method + "does not available!");
        }
    };
    $.fn.NavBar.defaults = {
      orientation: "horizontal",
      speed: 1000        
    };
})(window, document, jQuery);