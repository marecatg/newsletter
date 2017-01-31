(function () {
    'use strict';

    angular
        .module('app.accueil')
        .controller('Accueil', Accueil);

    Accueil.$inject = ['$q'];

    function Accueil($q) {

        var vm = this;
        vm.showView = false;

        activate();

        function activate() {
            var promises = [];
            promises = []; //initQuestion load in loadListUser
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Accueil View');
            });
        }
    }
})();
