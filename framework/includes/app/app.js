var app = angular.module('AppModule',[]);

app.factory('ConstService', function() {
    var const_service = {
        app_ver: '1.0',
        app_name: 'client app'
    };
   
   return const_service;
});

app.factory('MathService', function() {
    var methods = mathUtils();
    
    return methods;
});
