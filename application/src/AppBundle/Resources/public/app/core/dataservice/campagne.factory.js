(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceCampagne', dataserviceCampagne);

    dataserviceCampagne.$inject = ['$q', '$http'];
    function dataserviceCampagne($q, $http) {
        return {
            getAll: getAll
        };

        function getAll() {
            return $http.get('/api/all/campagne')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();