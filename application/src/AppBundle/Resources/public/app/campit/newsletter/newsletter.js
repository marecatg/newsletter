(function () {
    'use strict';

    angular
        .module('app.newsletter')
        .controller('Newsletter', Newsletter);

    Newsletter.$inject = ['$q', 'dataserviceCampagne', 'dataserviceNewsletter', '$uibModal'];

    function Newsletter($q, dataserviceCampagne, dataserviceNewsletter, $uibModal) {

        var vm = this;
        vm.showView = false;
        vm.campagnes = [
            {
                id: -1,
                nom: 'Sans campagnes'
            }
        ];
        vm.currentCampagne = vm.campagnes[0];
        vm.newsletters = [];
        vm.currentNewsletter = null;

        vm.rechercheNewsletters = rechercheNewsletters;
        vm.getNewsletter = getNewsletter;
        vm.openNewsletterModal = openNewsletterModal;

        activate();

        function activate() {
            var promises = [initCampagnes(), rechercheNewsletters(vm.campagnes[0])];
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Newsletter View');
            });
        }

        function initCampagnes() {
            return dataserviceCampagne.getAll()
                .then(function (data) {
                    angular.forEach(data, function (liste) {
                        vm.campagnes.push(liste);
                    });
                }, function () {
                    logger.error('Erreur lors de la récupération des campagnes', true);
                    logger.error(data.data);
                });
        }

        function rechercheNewsletters(campagne) {
            if (campagne === null) {
                campagne = vm.currentCampagne;
            }
            return dataserviceNewsletter.getNewslettersByCampagne(campagne.id)
                .then(function (data) {
                    vm.newsletters = data;
                }, function () {
                    logger.error('Erreur lors de la récupération des newsletters', true);
                    logger.error(data);
                });
        }

        function getNewsletter(id) {
            return dataserviceNewsletter.getNewsletter(id).then(function (data) {
                vm.currentNewsletter = data;
            }, function () {
                logger.error('Erreur lors de la récupération de la newsletter', true);
                logger.error(data);
            })
        }

        function openNewsletterModal() {
            $uibModal.open({
                templateUrl: 'bundles/app/app/campit/newsletter/modal/modalNewsletter.html',
                controller: 'ModalNewsletter',
                controllerAs: 'vm',
                size: 'lg',
                windowClass: 'clearfix',
                resolve: {
                    campagne : function() {
                        return vm.currentCampagne
                    }
                }
            }).result.then(function(newsletter) {
                if (newsletter !== null) {
                    vm.newsletters.push(newsletter);
                }
            });
        }
    }
})();
