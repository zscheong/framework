//var app = angular.module('ExcelCompare', ['ngAnimate']);

app.factory('sharedData', function() {
   var shared = {input: [], reference: []};
   
   return shared;
});
app.controller('CompareController', function($scope) {
   $scope.step = 'upload'; 
   
   $scope.$watch('step', function(new_value, old_value) {
       if(new_value === 'map') {
           $scope.$broadcast('refresh', '');
       }
   });
   $scope.$on('ChangeStep', function(event, data){
       if(data === 'upload') {
           $scope.step = 'map';
       }
   });
   $scope.ToggleForm = function() {
       if($scope.step === 'map') { $scope.step = 'upload'; }
       else if($scope.step === 'upload') { $scope.step = 'map'; }
   }
});
app.controller('CompareUpload', function($scope, $http, sharedData) {
    
    $scope.UploadSubmit = function() {
        //alert("Submit Fnction");
        
        var fd = new FormData();
        fd.append('reference', $scope.reference);
        fd.append('input', $scope.input);
        var options = {
                        headers: { 'Content-Type': undefined },
                        transformRequest: angular.identity 
                    };
        
        var response = $http.post('index.php?module=ExcelUtils&controller=UploadFile',
                                    fd, options);
        response.success(function(data, status, headers, config) {
            //alert(data);
            sharedData.input = data.input;
            sharedData.reference = data.reference;
            
            sharedData.file_input = $scope.input;
            sharedData.file_reference = $scope.reference;
            $scope.$emit('ChangeStep', 'upload');
        });
        response.error(function(data, status, headers, config) {
            alert("Unable to connect Server!");
        });
    };
    $scope.ResetInput = function() {
        alert("Reset All the Input");
        
        var input = jQuery('#form_upload input');
        angular.forEach(input, function(val, key) {
            val.val("");
        });
    }; 
});
app.controller("CompareMap", function($scope, $http, sharedData, transformRequestAsFormPost) {
    $scope.opts = { reference: [], input: []};
    
    $scope.$on('refresh', function(event, data) {
        $scope.opts.input = sharedData.input;
        $scope.opts.reference = sharedData.reference;
    });
    
    $scope.MapSubmit = function() {
        
        var post_data = {    
            file_input: sharedData.file_input.name, 
            file_reference: sharedData.file_reference.name,
            map_input: $scope.map_input,
            map_reference: $scope.map_reference
        }; 
        //var response = $http.post('index.php?module=ExcelUtils&controller=Compare', post_data);
        var response = $http({
            method: "post",
            url: 'index.php?module=ExcelUtils&controller=Compare',
            transformRequest: transformRequestAsFormPost,
            data: post_data
        });
        
        response.success(function(data, status, headers, config) {
            
        });
        response.error(function(data, status, headers, config) {
            alert("Unable to connect Server!");
        });
    }
});