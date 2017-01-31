(function () {
    'use strict';

    angular.module('app.layout')
        .controller('Layout', Layout);

    Layout.$inject = ['$q', 'logger', 'config', '$scope', '$sce'];

    function Layout($q, logger, config, $scope, $rootScope, $sce) {

        var vm = this;
        vm.showView = false;
        vm.title = config.appTitle;

        vm.isDefined = isDefined;
        vm.stopClose = stopClose;


        activate();

        $scope.trustAsHtml = function(string) {
            return $sce.trustAsHtml(string);
        };

        function activate() {

            return $q.all().then(function () {
                        vm.showView = true;
                        logger.info('Activated Layout View');
            });
        }

        function isDefined (object) {
            return angular.isDefined(object);
        }

        $scope.$on('Update.config.title', function (event, title) {
            console.log("Updating page title: " + title);
            $rootScope.title = title;
        });

        function stopClose(event) {
            event.stopPropagation();
        }

    }
})();
