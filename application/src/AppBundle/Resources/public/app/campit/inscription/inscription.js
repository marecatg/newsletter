(function () {
    'use strict';

    angular
        .module('app.inscription')
        .controller('Inscription', Inscription);

    Inscription.$inject = ['$q', 'dataserviceInscription', 'logger', 'dataserviceNewsletter',
        'dataserviceListeDiffusion'];

    function Inscription($q, dataserviceInscription, logger, dataserviceNewsletter,
                         dataserviceListeDiffusion) {

        var vm = this;
        vm.showView = false;
        vm.newsletters = [];
        vm.inscriptions = [];
        vm.listesDiffusions = [];
        vm.selectionNonSauvegarde = false;
        vm.idNewsletterSelected = null;

        vm.ignoreAlert = ignoreAlert;
        vm.saveChange = saveChange;
        vm.changeSelection = changeSelection;

        activate();

        function activate() {
            var promises = [initInscription(), initNewsletters(), initListesDiffusions()];
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Inscription View');
            });
        }

        function ignoreAlert() {
            vm.selectionNonSauvegarde = false;
        }

        function changeSelection(idNewsletterSelected) {
            vm.idNewsletterSelected = idNewsletterSelected;
            angular.forEach(vm.listesDiffusions, function (liste) {
                liste.select = false;
            });
            angular.forEach(vm.inscriptions, function (inscription) {
                if (inscription.newsletterId === idNewsletterSelected) {
                    angular.forEach(vm.listesDiffusions, function (liste) {
                        if (inscription.idListeSource === liste.id) {
                            liste.select = true;
                        }
                    });
                }
            });
        }

        function saveChange() {
            var insciptions = [];

            angular.forEach(vm.listesDiffusions, function (liste) {
                if (liste.select) {
                    var insciption = {
                        newsletterId: vm.idNewsletterSelected,
                        idListeSource: liste.id
                    };
                    insciptions.push(insciption);
                }
            });

            return dataserviceInscription.putInscriptionNewsletterListeDiffusion(insciptions, vm.idNewsletterSelected)
                .then(function () {
                    logger.success('Inscriptions mises à jour', true);
                    vm.selectionNonSauvegarde = false;
                    initInscription();
                    vm.idNewsletterSelected = null;
                }, function (data) {
                    logger.error('Erreur lors de la sauvegarde des inscriptions', true);
                    logger.error(data);
                });
        }

        function initInscription() {
            return dataserviceInscription.getInscriptionListeDiffusion().then(function (data) {
                vm.inscriptions = data;
            }, function (data) {
                logger.error('Erreur lors de la récupération des inscriptions', true);
                logger.error(data);
            });
        }

        function initNewsletters() {
            return dataserviceNewsletter.getAllLast().then(function (data) {
                vm.newsletters = data;
            }, function (data) {
                logger.error('Erreur lors de la récupération des newsletters', true);
                logger.error(data);
            });
        }

        function initListesDiffusions() {
            return dataserviceListeDiffusion.getAll().then(function (data) {
                vm.listesDiffusions = data;
            }, function (data) {
                logger.error('Erreur lors de la récupération des listes de diffusions', true);
                logger.error(data);
            });
        }
    }
})();
