(function () {
    'use strict';

    angular
        .module('app.newsletter')
        .run(appRun);

    appRun.$inject = ['routehelper', 'page'];

    function appRun(routehelper, page) {
        routehelper.configureRoutes(getRoutes(page));
    }

    function getRoutes(page) {
        return [
            {
                url: page.routeNewsletter,
                config: {
                    templateUrl: 'bundles/app/app/campit/newsletter/newsletter.html',
                    controller: 'Newsletter',
                    controllerAs: 'vm'
                }
            }
        ];
    }
})();
