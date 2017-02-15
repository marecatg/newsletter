(function () {
    'use strict';

    angular
        .module('app.core')
        .controller('ModalGestionDestinataire', ModalGestionDestinataire);

    ModalGestionDestinataire.$inject = ['$uibModalInstance', '$q', 'currentDestinataire'];

    function ModalGestionDestinataire($uibModalInstance, $q, currentDestinataire) {

        var vm = this;


        vm.cancel = cancel;
        vm.currentDestinataire = currentDestinataire;

        activate();

        function activate() {
            var promises = [];
            return $q.all(promises).then(function () {

            });

        }


        function cancel() {
            $uibModalInstance.close(false);
        }

    }
})();
