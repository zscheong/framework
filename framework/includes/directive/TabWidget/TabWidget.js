app.directive('tabWidget', function() {
    return {
        restrict: 'E',
        transclude: 'true',
        scope: {},
        controller: function($scope) {
            var panes = $scope.panes = [];
            //var elems = $scope.elems = [];
            
            $scope.select = function(pane) {
                angular.forEach(panes, function(pane) {
                   pane.selected = false; 
                });
                pane.selected = true;
                
                //var width = jQuery(elems[pane.id]).width();
                //jQuery('.tab-space').width(width);
            };
            
            
            this.addPane = function(pane) {
                if(panes.length === 0) {
                    $scope.select(pane);
                }
                //pane.id = panes.length + 1;
                panes.push(pane);
                //elems[pane.id] = elem;
            };
        },
        templateUrl: './global/directive/TabWidget/tab-widget.html'
    };
})
    .directive('tabPane', function() {
    return {
        require: '^tabWidget',
        restrict: 'E',
        transclude: 'true',
        scope: {
            title: '@'
        },
        link: function(scope, element, attrs, tabWidget) {
            tabWidget.addPane(scope);
        },
        templateUrl: './global/directive/TabWidget/tab-pane.html'
    };        
});