// Karma configuration
// Generated on Mon Jun 01 2015 20:50:28 GMT+0800 (Malay Peninsula Standard Time)

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',

    plugins: [
        'karma-chrome-launcher',
        'karma-jasmine',
        'karma-ng-html2js-preprocessor'
    ],

    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
        '../../../framework/includes/js/angular/lib/angular.js',
        '../../../framework/includes/js/angular/lib/angular-mocks.js',
        '../../../framework/includes/js/jquery/jquery.js',
        '../../../framework/includes/js/jext/jutils.js',
        '../../../framework/includes/app/app.js',
        '../../../framework/includes/directive/NavBarWidget/NavBarWidget.js',
         '../../../framework/includes/directive/NavBarWidget/templates/*.html',
        '*Test.js'
       
    ],


    // list of files to exclude
    exclude: [
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
        '../../../framework/includes/directive/NavBarWidget/templates/*.html':['ng-html2js'] 
    },


    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,


    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['Chrome'],


    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false

  });
};
