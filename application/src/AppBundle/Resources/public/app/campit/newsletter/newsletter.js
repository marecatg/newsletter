(function () {
    'use strict';

    angular
        .module('app.newsletter')
        .controller('Newsletter', Newsletter);

    Newsletter.$inject = ['$q', 'dataserviceCampagne', 'dataserviceNewsletter'];

    function Newsletter($q, dataserviceCampagne, dataserviceNewsletter) {

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

        vm.ckeditorOptions = {
            language: 'fr',
            allowedContent: true,
            entities: false
        };
        vm.currentNewsletter = null;

        vm.rechercheNewsletters = rechercheNewsletters;
        vm.getNewsletter = getNewsletter;

        activate();

        function activate() {
            var promises = [initCampagnes(), rechercheNewsletters()];
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
            if (campagne == null) {
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
    }
})();
