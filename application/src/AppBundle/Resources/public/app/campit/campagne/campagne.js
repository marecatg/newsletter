(function () {
    'use strict';

    angular
        .module('app.campagne')
        .controller('Campagne', Campagne);

    Campagne.$inject = ['$q'];

    function Campagne($q) {

        var vm = this;
        vm.showView = false;

        activate();

        function activate() {
            var promises = [];
            promises = []; //initQuestion load in loadListUser
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Campagne View');
            });
        }
    }
})();
