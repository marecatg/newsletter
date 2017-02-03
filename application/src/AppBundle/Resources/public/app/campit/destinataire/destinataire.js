(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .controller('Destinataire', Destinataire);

    Destinataire.$inject = ['$q', 'dataserviceDestinataire', 'logger', 'dataserviceListeDiffusion'];

    function Destinataire($q, dataserviceDestinataire, logger, dataserviceListeDiffusion) {

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
        vm.currentListeDiffusion = vm.listesDiffusion[0].id;

        vm.creerDestinataire = creerDestinataire;
        vm.rechercheDestinatairesByListe = rechercheDestinatairesByListe;

        activate();

        function activate() {
            var promises = [initListesDiffusion(),
                rechercheDestinatairesByListe()];
            return $q.all([promises]).then(function () {
                    vm.showView = true;
                    logger.info('Activated Destinataire View');
                });
        }

        function initListesDiffusion() {
            dataserviceListeDiffusion.getAll()
                .then(function (data) {
                    angular.forEach(data, function (liste) {
                        vm.listesDiffusion.push(liste);
                    });
                    console.log(vm.listesDiffusion);
                }, function () {
                    logger.error('Erreur lors de la récupération des listes de diffusion', true);
                    logger.error(data.data);
                });
        }

        function rechercheDestinatairesByListe(idListeDiffusion) {
            if (idListeDiffusion == null) {
                idListeDiffusion = vm.currentListeDiffusion;
            }
            dataserviceDestinataire.getDestinataireByListeDiffusion(idListeDiffusion)
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
    }
})();
