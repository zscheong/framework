describe('MathUtils', function() {
    var utils;
    utils = mathUtils();
    
    it("Interpolate function", function() {
        var x0 = 10, x1 = 100, y0 = 12, y1 = 18;
        var x = 60, result = 16;
        expect(utils.interpolate(x, x0, x1, y0, y1)).toEqual(result);   
    });    
});