var app = angular.module('ProfileModule',['textAngular']);
app.controller('ProfileController', function($scope) {
   $scope.welcome = "Hello, Welcom to Angular!"; 
});
app.controller('InfoController', function($scope) {

    $scope.note = "This site created from scratch using AngularJS and MVC framework";
   
    $scope.user = {
       name: "Cheong Zee Swee",
       short: "zsc",
       designation: "PHP Software Developer",
       country: "Malaysia",
       phone: "012-7357468",
       email1: "zscheong@gmail.com",
       email2: "zscheong@hotmail.com"
    };
   
});
app.controller('TabsController', function($scope) {
    $scope.tabs = 'This is tabs board'; 
    $scope.orightml = '<h2>Try me!</h2><p>textAngular is a super cool WYSIWYG Text Editor directive for AngularJS</p><p><img class="ta-insert-video" ta-insert-video="http://www.youtube.com/embed/2maA1-mvicY" src="" allowfullscreen="true" width="300" frameborder="0" height="250"/></p><p><b>Features:</b></p><ol><li>Automatic Seamless Two-Way-Binding</li><li>Super Easy <b>Theming</b> Options</li><li style="color: green;">Simple Editor Instance Creation</li><li>Safely Parses Html for Custom Toolbar Icons</li><li class="text-danger">Doesn&apos;t Use an iFrame</li><li>Works with Firefox, Chrome, and IE8+</li></ol><p><b>Code at GitHub:</b> <a href="https://github.com/fraywing/textAngular">Here</a> </p><h4>Supports non-latin Characters</h4><p>?? ? ??? ???, ??? ??? ??? ? ??, ??? ??? ?? ? ?? ? ??? ??? ??? ?? ??? ??? ?, ? ?? ??? ???, ?? ??? ??? ? ? ??? ??? ??? ??, ?? ??? ??? ? ? ?? ??? ???, ?? ??? ??? ? ? ?? ??? ??? ???, ?? ? ??? ??? ???</p>';
    $scope.htmlcontent = $scope.orightml;
    $scope.disabled = false;
});