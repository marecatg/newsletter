(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceInscription', dataserviceInscription);

    dataserviceInscription.$inject = ['$q', '$http'];
    function dataserviceInscription($q, $http) {
        return {
            getInscriptionListeDiffusion: getInscriptionListeDiffusion,
            putInscriptionNewsletterListeDiffusion: putInscriptionNewsletterListeDiffusion
        };

        function getInscriptionListeDiffusion() {
            return $http.get('/api/all/inscription/liste/diffusion')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function putInscriptionNewsletterListeDiffusion(inscriptions, idNewsletter) {
            return $http.put('/api/inscription/newsletter/liste/diffusion', {
                inscriptions: inscriptions,
                idNewsletter: idNewsletter
            })
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();