(function () {
    'use strict';

    angular
        .module('app.campagne')
        .run(appRun);

    appRun.$inject = ['routehelper'];

    function appRun(routehelper) {
        routehelper.configureRoutes(getRoutes());
    }

    function getRoutes() {
        return [
            {
                url: '/campagne',
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
