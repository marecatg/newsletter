(function () {
    'use strict';

    angular
        .module('app.core')
        .controller('ModalGestionDestinataire', ModalGestionDestinataire);

    ModalGestionDestinataire.$inject = ['$uibModalInstance', '$q', 'currentDestinataires', 'dataserviceDestinataire'];

    function ModalGestionDestinataire($uibModalInstance, $q, currentDestinataires, dataserviceDestinataire) {

        var vm = this;
        vm.showView = false;
        vm.allDestinataires = null;

        vm.cancel = cancel;
        vm.currentDestinataires = currentDestinataires;
        vm.ok = ok;

        activate();

        function activate() {
            var promises = [getAllDestinataire()];
            return $q.all(promises).then(function () {
                vm.showView = true;
            });
        }

        function getAllDestinataire() {
            return dataserviceDestinataire.getAllDestinataire().then(function (data) {
                vm.allDestinataires = data;
                initDestinataires();
            }, function (data) {
                logger.error('Erreur lors de la récupération des destinataires', true);
                logger.error(data.data);
            });
        }

        function initDestinataires() {
            angular.forEach(vm.allDestinataires, function (destinataire) {
                destinataire.present = false;
                angular.forEach(vm.currentDestinataires, function (destinatairePresent) {
                    if (destinatairePresent.id === destinataire.id) {
                        destinataire.present = true;
                    }
                });
            });
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }

        function ok() {
            var newDestinataires = [];
            angular.forEach(vm.allDestinataires, function(value) {
               if (value.present) newDestinataires.push(value);
            });
            $uibModalInstance.close(newDestinataires);
        }

    }
})();
