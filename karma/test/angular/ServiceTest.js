describe('ConstServiceTest', function() {
    beforeEach(module('AppModule'));
    
    var service;
    
    beforeEach(inject(function(ConstService) {
        service = ConstService;
    }));
    
    it("Get app name", function() {
        expect(service.app_name).toEqual('client app'); 
    });
});

    