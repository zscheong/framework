app.directive('navBar', ['MathService', function(MathService) {
    return {
        restrict: 'E', 
        transclude: 'true',
        scope: {},
        templateUrl: function(tElement, tAttrs) {
            var url='';
            
            switch(tAttrs.template) {
                case "material":
                    url = 'includes/directive/NavBarWidget/templates/material.html';
                    break;
                default:
                    url = 'includes/directive/NavBarWidget/templates/default.html';
            }
            return url;
        },
        controller: function($scope) {
            $scope.defaults = {
                enableBrand: true,
                enableTitle: true,
                enableSearch: true,
                title: 'Title NavBar'
            };
          
        },
        link: function($scope, $elem, $attrs) {
            $scope.settings = jQuery.extend({}, $scope.defaults, $attrs);
        }
    };
}]);