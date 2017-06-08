(function () {
    'use strict';

    angular
        .module('app.inscription')
        .controller('Inscription', Inscription);

    Inscription.$inject = ['$q'];

    function Inscription($q) {

        var vm = this;
        vm.showView = false;
        vm.newsletters = [];

        activate();

        function activate() {
            var promises = [];
            promises = []; //initQuestion load in loadListUser
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Inscription View');
            });
        }

        function initInscription() {

        }
    }
})();
