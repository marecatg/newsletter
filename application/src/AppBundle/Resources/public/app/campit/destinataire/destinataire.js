(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .controller('Destinataire', Destinataire);

    Destinataire.$inject = ['$q', 'dataserviceDestinataire'];

    function Destinataire($q, dataserviceDestinataire) {

        var vm = this;
        vm.showView = false;
        vm.newDestinataire = {
            nom: null,
            prenom: null,
            email: null
        };

        vm.creerDestinataire = creerDestinataire;

        activate();

        function activate() {
            var promises = [];
            promises = [];
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Destinataire View');
            });
        }

        function creerDestinataire(form) {
            if (form.$valid) {

                console.log('envoi');
                dataserviceDestinataire.postDestinataire(vm.newDestinataire);
            }
        }
    }
})();
