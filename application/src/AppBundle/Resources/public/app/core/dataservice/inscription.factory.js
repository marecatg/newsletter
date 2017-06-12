(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceInscription', dataserviceInscription);

    dataserviceInscription.$inject = ['$q', '$http'];
    function dataserviceInscription($q, $http) {
        return {
            getInscriptionListeDiffusion: getInscriptionListeDiffusion
        };

        function getInscriptionListeDiffusion() {
            return $http.get('/api/all/insciption/liste/diffusion')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();