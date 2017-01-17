(function () {
    'use strict';

    angular
        .module('app.accueil')
        .controller('Accueil', Accueil);

    Accueil.$inject = ['$q', 'logger'];

    function Accueil($q, logger) {

        var vm = this;

        activate();

        function activate() {
            var promises = [];
            promises = []; //initQuestion load in loadListUser
            return $q.all(promises).then(function () {
                ;
                logger.info('Activated Accueil View');
            });
        }
    }
})();
