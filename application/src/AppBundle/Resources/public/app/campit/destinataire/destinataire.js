(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .controller('Destinataire', Destinataire);

    Destinataire.$inject = ['$q'];

    function Destinataire($q) {

        var vm = this;
        vm.showView = false;

        activate();

        function activate() {
            var promises = [];
            promises = [];
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Destinataire View');
            });
        }
    }
})();
