(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .controller('Destinataire', Destinataire);

    Destinataire.$inject = ['$q', 'dataserviceDestinataire', 'logger'];

    function Destinataire($q, dataserviceDestinataire, logger) {

        var vm = this;
        vm.showView = false;
        vm.newDestinataire = {
            nom: null,
            prenom: null,
            email: null
        };
        vm.ajoutDestinataireenCours = false;

        vm.creerDestinataire = creerDestinataire;

        activate();

        function activate() {
            var promises = [];
            promises = [];
            return $q.all(promises).then(function () {
                vm.showView = true;
                logger.info('Activated Destinataire View');
            });
        }

        function creerDestinataire(form) {
            if (form.$valid) {
                vm.ajoutDestinataireenCours = true;
                dataserviceDestinataire.postDestinataire(vm.newDestinataire).then(function() {
                    vm.ajoutDestinataireenCours = false;
                    logger.success('Destinataire ajouté', true)
                }, function(data) {
                    logger.error('Erreur lors de l\'ajout du destinataire', true);
                    logger.error(data);
                    vm.ajoutDestinataireenCours = false;
                });
            }
        }
    }
})();
