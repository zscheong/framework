var app = angular.module('UserModule',['ngResource']);
app.controller('ListController', function($scope, $resource) {
   var user = $resource('/framework/User/id/:id', null, {update: {method: 'PUT'}});
   user.get({id: 123}, function(data) {
       data.fullname='cheong zee swee';
       data.method='update';
       data.$update();
   }); 
   
   
   user.save({fullname: 'new user'});
});