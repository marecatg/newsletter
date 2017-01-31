(function () {
    'use strict';

    angular
        .module('app.newsletter')
        .run(appRun);

    appRun.$inject = ['routehelper'];

    function appRun(routehelper) {
        routehelper.configureRoutes(getRoutes());
    }

    function getRoutes() {
        return [
            {
                url: '/newsletter',
                config: {
                    templateUrl: 'bundles/app/app/campit/newsletter/newsletter.html',
                    controller: 'Newsletter',
                    controllerAs: 'vm'
                }
            }
        ];
    }
})();
