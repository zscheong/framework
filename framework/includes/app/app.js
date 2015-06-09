var app = angular.module('AppModule',[]);

app.factory('ConstService', function() {
    var const_service = {
        app_ver: '1.0',
        app_name: 'client app'
    };
   
   return const_service;
});

app.factory('MathService', function() {
    var methods = {
        interpolate: function(x, x0, x1, y0, y1) {
            if(isNaN(x0) || isNaN(x1) || 
                isNaN(x) || isNaN(y0) || isNaN(y1)) {
                return 0;
            }            
            if(x1 - x0 === 0) { return 0; }
            var ratio = (y1-y0)/(x1-x0);
            return x * ratio + y0;
        }
    };
    
    return methods;
});
