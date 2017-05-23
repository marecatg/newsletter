(function () {
    'use strict';

    angular
        .module('app.newsletter')
        .controller('Newsletter', Newsletter);

    Newsletter.$inject = ['$q', 'dataserviceCampagne', 'dataserviceNewsletter', '$uibModal', 'logger'];

    function Newsletter($q, dataserviceCampagne, dataserviceNewsletter, $uibModal, logger) {

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
        vm.deleteNewsletter = deleteNewsletter;
        vm.modifierNewsletter = modifierNewsletter;

        activate();

        function activate() {
            var promises = [initCampagnes(), rechercheNewsletters(vm.campagnes[0])];
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Newsletter View');
            });
        }

        function modifierNewsletter() {
            $uibModal.open({
                templateUrl: 'bundles/app/app/campit/newsletter/modal/modalNewsletter.html',
                controller: 'ModalNewsletter',
                controllerAs: 'vm',
                size: 'lg',
                windowClass: 'clearfix',
                resolve: {
                    campagne : function() {
                        return vm.currentCampagne
                    },
                    newsletter : function() {
                        return {
                            id: vm.currentNewsletter.id,
                            nom: vm.currentNewsletter.nom,
                            corps: vm.currentNewsletter.contenus[0].contenu_h_t_m_l,
                            campagneId: vm.currentCampagne.id,
                            dateEnvoi: vm.currentNewsletter.date_prochain_envoi,
                            periodiciteUnite: vm.currentNewsletter.periodicite_unite,
                            periodiciteValeur: vm.currentNewsletter.periodicite_valeur
                        };
                    }
                }
            }).result.then(function(newsletter) {
                if (newsletter !== null) {
                    vm.currentNewsletter = null;
                    rechercheNewsletters();
                }
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
            if (!campagne) {
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

        function deleteNewsletter(id) {
            return dataserviceNewsletter.deleteNewsletter(id).then(function () {
                vm.currentNewsletter = null;

                var copy = angular.copy(vm.newsletters);
                angular.forEach(copy, function(n, key) {
                    if (n.id === id) {
                        vm.newsletters.splice(key, 1);
                        return true;
                    }
                });

                logger.success('Newsletter supprimée', true);
            }, function () {
                logger.error('Erreur lors de la suppression de la newsletter', true);
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
                    },
                    newsletter: function() {
                        return {
                            nom: null,
                            corps: null,
                            campagneId: null,
                            dateEnvoi: null,
                            periodiciteUnite: null,
                            periodiciteValeur: null
                        };
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
