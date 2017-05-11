(function () {
    'use strict';

    angular
        .module('app.core')
        .controller('ModalNewsletter', ModalNewsletter);

    ModalNewsletter.$inject = ['$uibModalInstance', '$q', 'campagne', 'dataserviceNewsletter', 'periodiciteUnite',
        '$scope', 'logger'];

    function ModalNewsletter($uibModalInstance, $q, campagne, dataserviceNewsletter, periodiciteUnite,
        $scope, logger) {

        var vm = this;
        vm.showView = false;
        vm.newsletter = {
            nom: null,
            corps: null,
            campagneId: null,
            dateEnvoi: null,
            periodiciteUnite: null,
            periodiciteValeur: null
        };
        vm.campagne = campagne;
        vm.periodiciteUnite = periodiciteUnite;

        vm.ckeditorOptions = {
            language: 'fr',
            allowedContent: true,
            entities: false
        };

        vm.cancel = cancel;
        vm.creerNewsletter = creerNewsletter;


        activate();
        function activate() {
            var promises = [];
            if (angular.isDefined(campagne) && campagne.id !== -1) {
                vm.newsletter.campagneId = campagne.id;
            }
            return $q.all(promises).then(function () {
                vm.showView = true;
            });
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }

        function ok() {
            $uibModalInstance.close(vm.newsletter);
        }

        function creerNewsletter(form) {
            if (form.$valid) {
                vm.ajoutNewsletterEnCours = true;
                dataserviceNewsletter.postNewsletter(vm.newsletter).then(function (newsletter) {
                    vm.ajoutNewsletterEnCours = false;
                    vm.newsletter = newsletter;
                    ok();
                    logger.success('Newsletter créée', true)
                }, function (data) {
                    logger.error('Erreur lors de la création de la newsletter', true);
                    logger.error(data);
                    vm.ajoutNewsletterEnCours = false;
                });
            }
        }

        ////////////////// Date picker \\\\\\\\\\\\\\\

        $scope.today = function() {
            vm.newsletter.dateEnvoi = new Date();
        };

        $scope.clear = function() {
            vm.newsletter.dateEnvoi = null;
        };

        $scope.inlineOptions = {
            customClass: getDayClass,
            minDate: new Date(),
            showWeeks: true
        };

        $scope.dateOptions = {
            // dateDisabled: disabled,
            formatYear: 'yy',
            maxDate: new Date(2020, 5, 22),
            minDate: new Date(2000, 1, 1),
            startingDay: 1
        };

        // Disable weekend selection
        // function disabled(data) {
        //     var date = data.date,
        //         mode = data.mode;
        //     return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        // }

        $scope.toggleMin = function() {
            $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
            $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
        };

        $scope.toggleMin();

        $scope.open = function() {
            $scope.popup.opened = true;
        };

        $scope.format = 'dd/MM/yyyy';
        $scope.altInputFormats = ['M!/d!/yyyy'];

        $scope.popup = {
            opened: false
        };

        function getDayClass(data) {
            var date = data.date,
                mode = data.mode;
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0,0,0,0);

                for (var i = 0; i < $scope.events.length; i++) {
                    var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }
            return '';
        }

    }
})();
