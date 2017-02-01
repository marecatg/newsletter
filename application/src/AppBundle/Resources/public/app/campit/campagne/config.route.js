(function () {
    'use strict';

    angular
        .module('app.campagne')
        .run(appRun);

    appRun.$inject = ['routehelper', 'page'];

    function appRun(routehelper, page) {
        routehelper.configureRoutes(getRoutes(page));
    }

    function getRoutes(page) {
        return [
            {
                url: page.routeCampagne,
                config: {
                    templateUrl: 'bundles/app/app/campit/campagne/campagne.html',
                    controller: 'Campagne',
                    controllerAs: 'vm',
                    title: 'Campagne'
                }
            }
        ];
    }
})();
