(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .controller('Destinataire', Destinataire);

    Destinataire.$inject = ['$q', 'dataserviceDestinataire', 'logger', 'dataserviceListeDiffusion', '$uibModal'];

    function Destinataire($q, dataserviceDestinataire, logger, dataserviceListeDiffusion, $uibModal) {

        var vm = this;
        vm.showView = false;
        vm.newDestinataire = {
            nom: null,
            prenom: null,
            email: null
        };
        vm.ajoutDestinataireenCours = false;
        vm.destinataires = null;
        vm.listesDiffusion = [
            {
                id: -1,
                nom: 'Sans liste de diffusion'
            }
        ]
        vm.currentListeDiffusion = vm.listesDiffusion[0];

        vm.creerDestinataire = creerDestinataire;
        vm.rechercheDestinatairesByListe = rechercheDestinatairesByListe;
        vm.openGestionDestinataireModal = openGestionDestinataireModal;

        activate();

        function activate() {
            var promises = [initListesDiffusion(),
                rechercheDestinatairesByListe()];
            return $q.all(promises).then(function () {
                vm.showView = true;
                logger.info('Activated Destinataire View');
            });
        }

        function initListesDiffusion() {
            return dataserviceListeDiffusion.getAll()
                .then(function (data) {
                    angular.forEach(data, function (liste) {
                        vm.listesDiffusion.push(liste);
                    });
                }, function () {
                    logger.error('Erreur lors de la récupération des listes de diffusion', true);
                    logger.error(data.data);
                });
        }

        function rechercheDestinatairesByListe(listeDiffusion) {
            if (listeDiffusion == null) {
                listeDiffusion = vm.currentListeDiffusion;
            }
            return dataserviceDestinataire.getDestinataireByListeDiffusion(listeDiffusion.id)
                .then(function (data) {
                    vm.destinataires = data;
                }, function () {
                    logger.error('Erreur lors de la récupération des destinataires', true);
                    logger.error(data.data);
                });
        }

        function creerDestinataire(form) {
            if (form.$valid) {
                vm.ajoutDestinataireenCours = true;
                dataserviceDestinataire.postDestinataire(vm.newDestinataire).then(function () {
                    vm.ajoutDestinataireenCours = false;
                    if (vm.currentListeDiffusion == vm.listesDiffusion[0].id) {
                        rechercheDestinatairesByListe(vm.currentListeDiffusion);
                    }
                    logger.success('Destinataire ajouté', true)
                }, function (data) {
                    logger.error('Erreur lors de l\'ajout du destinataire', true);
                    logger.error(data.data);
                    vm.ajoutDestinataireenCours = false;
                });
            }
        }

        function openGestionDestinataireModal() {
            $uibModal.open({
                templateUrl: 'bundles/app/app/campit/destinataire/modal/modalGestionDestinataire.html',
                controller: 'ModalGestionDestinataire',
                controllerAs: 'vm',
                size: 'md',
                windowClass: 'clearfix',
                resolve: {
                    currentDestinataires : function() {
                        return vm.destinataires
                    }
                }
            }).result.then(function(users) {
                vm.currentListeDiffusion.users = users;
                dataserviceListeDiffusion.putListe(vm.currentListeDiffusion).then(function(data) {
                    vm.destinataires = data.liste.destinataires;
                }, function(data) {
                    logger.error('Erreur lors de l\'ajout des destinataire', true);
                    logger.error(data.data);
                });
            });
        }
    }
})();
