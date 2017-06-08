(function () {
    'use strict';

    angular
        .module('app.inscription')
        .run(appRun);

    appRun.$inject = ['routehelper', 'page'];

    function appRun(routehelper, page) {
        routehelper.configureRoutes(getRoutes(page));
    }

    function getRoutes(page) {
        return [
            {
                url: page.routeInscription,
                config: {
                    templateUrl: 'bundles/app/app/campit/inscription/inscription.html',
                    controller: 'Inscription',
                    controllerAs: 'vm',
                    title: 'Inscription'
                }
            }
        ];
    }
})();
