(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceListeDiffusion', dataserviceListeDiffusion);

    dataserviceListeDiffusion.$inject = ['$q', '$http'];
    function dataserviceListeDiffusion($q, $http) {
        return {
            getAll: getAll
        };

        function getAll() {
            return $http.get('/api/all/listes/diffusion')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();
