app.directive('fileModel', ['$parse', function($parse) {
    return {
        restict: 'A',
        link: function($scope, $elem, $attr) {
            var model = $parse($attr.fileModel);
            var modelSetter = model.assign;    
            
            $elem.bind('change', function() {
                $scope.$apply(function() {
                   modelSetter($scope, $elem[0].files[0]); 
                });
            });
        }
    }    
}]);