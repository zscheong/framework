describe('Testing navbar directive', function() {
    var scope, elem, compiled;    
    beforeEach(module('AppModule'));
    beforeEach(module('C:/xampp/htdocs/project/framework/framework/includes/directive/NavBarWidget/templates/material.html'));
    beforeEach(inject(function($compile, $rootScope) {
        scope = $rootScope.$new();
        compiled = $compile;
    }));
    
    it("material template", function() {
        elem = angular.element('<nav-bar template="material"></nav-bar>');
        compiled(elem)(scope);
        scope.$digest();
        
        var container = jQuery('.template-container');
        expect(container.hasClass("type-material")).toBe(true); 
    });
});
    