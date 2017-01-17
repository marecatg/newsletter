(function () {
    'use strict';

    angular
        .module('app.accueil')
        .run(appRun);

    appRun.$inject = ['routehelper'];

    function appRun(routehelper) {
        routehelper.configureRoutes(getRoutes());
    }

    function getRoutes() {
        return [
            {
                url: '/',
                config: {
                    templateUrl: 'bundles/app/app/newsletter/accueil/accueil.html',
                    controller: 'Accueil',
                    controllerAs: 'vm',
                    title: 'Accueil'
                }
            }
        ];
    }
})();
