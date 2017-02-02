(function () {
    'use strict';

    var core = angular.module('app.core');

    // core.config(toastrConfig);
    //
    // toastrConfig.$inject = ['toastr'];
    // function toastrConfig(toastr) {
    //     toastr.options.timeOut = 4000;
    //     toastr.options.positionClass = 'toast-bottom-right';
    // }

    core.config(["toastrConfig",function(toastrConfig) {

        var options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "4000"
        };

        angular.extend(toastrConfig, options);
    }]);

    var config = {
        appErrorPrefix: '[My app] ', //Configure the exceptionHandler decorator
        appTitle: 'Application Campit',
        version: '1.0.0'
    };

    core.value('config', config);

    core.config(configure);

    configure.$inject = ['$logProvider', '$routeProvider', 'routehelperConfigProvider',
        '$httpProvider', 'IdleProvider', 'KeepaliveProvider'];
    function configure($logProvider, $routeProvider, routehelperConfigProvider,
                       $httpProvider, IdleProvider, KeepaliveProvider) {
        // turn debugging off/on (no info or warn)

        if ($logProvider.debugEnabled) {
            $logProvider.debugEnabled(true);
        }

        // Configure the common route provider
        routehelperConfigProvider.config.$routeProvider = $routeProvider;
        routehelperConfigProvider.config.docTitle = config.appTitle;

        $httpProvider.defaults.cache = false;
        if (!$httpProvider.defaults.headers.get) {
            $httpProvider.defaults.headers.get = {};
        }

        // disable IE ajax request caching
        $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';

        IdleProvider.idle(2400);
        IdleProvider.timeout(10);
        KeepaliveProvider.interval(2);
    }
})();
