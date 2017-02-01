(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .run(appRun);

    appRun.$inject = ['routehelper', 'page'];

    function appRun(routehelper, page) {
        routehelper.configureRoutes(getRoutes(page));
    }

    function getRoutes(page) {
        return [
            {
                url: page.routeDestinataire,
                config: {
                    templateUrl: 'bundles/app/app/campit/destinataire/destinataire.html',
                    controller: 'Destinataire',
                    controllerAs: 'vm',
                    title: 'Destinataire'
                }
            }
        ];
    }
})();
