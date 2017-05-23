(function () {
    'use strict';

    angular
        .module('app.campagne')
        .controller('Campagne', Campagne);

    Campagne.$inject = ['$q', '$scope'];

    function Campagne($q, $scope) {

        var vm = this;
        vm.showView = false;
        vm.newCampagne = {
            nom: null,
            dateEnvoi: null,
            periodiciteUnite: null,
            periodiciteValeur: null
        };
        vm.ajoutCampagneEnCours = false;

        vm.creerCampagne = creerCampagne;

        activate();

        function activate() {
            var promises = [];
            promises = []; //initQuestion load in loadListUser
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Campagne View');
            });
        }

        function creerCampagne(form) {

        }

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
    }
})();
