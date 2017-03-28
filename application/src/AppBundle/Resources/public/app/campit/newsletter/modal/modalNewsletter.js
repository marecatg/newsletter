(function () {
    'use strict';

    angular
        .module('app.core')
        .controller('ModalNewsletter', ModalNewsletter);

    ModalNewsletter.$inject = ['$uibModalInstance', '$q', 'campagne', 'dataserviceNewsletter'];

    function ModalNewsletter($uibModalInstance, $q, campagne, dataserviceNewsletter) {

        var vm = this;
        vm.showView = false;
        vm.newsletter = {
            nom: null,
            corps: null,
            campagneId: null
        };

        vm.cancel = cancel;
        vm.campagne = campagne;
        vm.ok = ok;

        vm.ckeditorOptions = {
            language: 'fr',
            allowedContent: true,
            entities: false
        };

        activate();

        function activate() {
            var promises = [];
            if (angular.isDefined(campagne)) {
                vm.newsletter.campagneId = campagne.id;
            }
            return $q.all(promises).then(function () {
                vm.showView = true;
            });
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }

        function ok(form) {
            if (form.$submitted && form.$valid) {
                $uibModalInstance.close(vm.newsletter);
            }
        }

    }
})();
