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

describe('MathService', function() {
    beforeEach(module('AppModule'));
    
    var service;
    
    beforeEach(inject(function(MathService) {
        service = MathService;
    }));
    
    it("Interpolate Function - normal operation", function() {
        var x0 = 10, x1 = 100, y0 = 12, y1 = 18;
        var x = 60, result = 16;
        
        expect(service.interpolate(x, x0, x1, y0, y1)).toEqual(result); 
    });
});
    