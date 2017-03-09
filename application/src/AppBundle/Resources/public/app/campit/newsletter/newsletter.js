(function () {
    'use strict';

    angular
        .module('app.newsletter')
        .controller('Newsletter', Newsletter);

    Newsletter.$inject = ['$q'];

    function Newsletter($q) {

        var vm = this;
        vm.showView = false;

        vm.ckeditorOptions = {
            language: 'fr',
            allowedContent: true,
            entities: false
        };

        activate();

        function activate() {
            var promises = [];
            promises = []; //initQuestion load in loadListUser
            return $q.all(promises).then(function () {
                vm.showView = true;
                console.log('Activated Newsletter View');
            });
        }
    }
})();
