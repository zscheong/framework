(function($) {

var methods = {
    StripPX: function(dim) {
        var ret = {};
        $.each(dim, function(k,v) {
            ret[k] = parseInt(v.replace('px', ''));
        });
        return ret;
    },
    AddDim: function(dim, newDim) {
        var ret = {};
        var iDim = methods.StripPX(dim);
        if(newDim.left) {  iDim.left += newDim.left;  }
        if(newDim.top)  {  iDim.top += newDim.top;    }
        if(newDim.width) {  iDim.width += newDim.width;  }
        if(newDim.height)  {  iDim.height += newDim.height;    }
        
        $.each(iDim, function(k,v) {
            ret[k] = v + "px";
        });
        return ret;
    },
    AddCSS: function(href) {
        var stack = DataOptions.CSSStack;
        if($.inArray(href, stack) < 0) {
            var cssTag = $("<link rel='stylesheet' type='text/css' href='" + href + "'/>");
            $("head").append(cssTag);
            DataOptions.CSSStack.push(href);
        }
    }, 
    AddJS: function(src) {
        var stack = DataOptions.JSStack;
        if($.inArray(src, stack) < 0) {
            var jsTag = $("<script src='" + src + "'></script>");
            $("head").append(jsTag);
            DataOptions.JSStack.push(src);
        }
    },
    Angular2Table: function($scope, def) {
        var noRowItem = parseInt($scope.options.col);
        var row = 0, colPoint = 0;
        $scope.options.itemsTable = [];
        $.each($scope.options.items, function(i,v) {
            if(!v) { return true; }
            var pan = v["pan"];
            var skipPan = false;
            var curr = colPoint % noRowItem;
            
            var content = {};
            if(def) { content = $.extend({}, def, v); }
            else { content = v; }
            
            if(curr === 0 && colPoint !== 0) {
                 row++;
            }
            if((noRowItem - curr) === 1) {
                skipPan = true;
            }
            if(pan && !skipPan) {
                colPoint += noRowItem - curr;
                content["panCol"] = noRowItem - curr;
            } else {
                colPoint++;
                content["panCol"] = 1;
            }

            if(!$scope.options.itemsTable[row]) { $scope.options.itemsTable[row] = []; }
            $scope.options.itemsTable[row][curr] = content;
            
        });
        var lastLength = colPoint % noRowItem;
        if(lastLength !== 0 ) {
            for(var i = lastLength; i<noRowItem; i++) {
                $scope.options.itemsTable[row][i] = {label: "empty"};
            }
        }
    }
};

var DataOptions = {
    JSStack : [],
    CSSStack: []
};

DataUtils = function(method, options) {    
    if(methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if(typeof DataOptions[method] !== 'undefined') {
        return DataOptions[method];
    } else {
        return 'Error: Not a recognize function!';
    }
};
    
})(jQuery);
