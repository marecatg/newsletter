(function () {
    'use strict';

    angular
        .module('app.core')
        .controller('CoreController', CoreController);

    CoreController.$inject = ['$q', 'logger'];

    function CoreController($q, logger) {
        /*jshint validthis: true, camelcase: false */
        var vm = this;

        mainActivate();

        function mainActivate() {
            var promises = [];
            return $q.all(promises).then(function () {
                logger.info('Activated Core controller');
            });
        }
    }
})();
