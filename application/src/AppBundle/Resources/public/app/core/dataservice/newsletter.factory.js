(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceNewsletter', dataserviceNewsletter);

    dataserviceNewsletter.$inject = ['$q', '$http'];
    function dataserviceNewsletter($q, $http) {
        return {
            getNewslettersByCampagne: getNewslettersByCampagne,
            getNewsletter: getNewsletter
        };

        function getNewslettersByCampagne(idCampagne) {
            return $http.get('/api/newsletters/' + idCampagne + '/by/campagne')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function getNewsletter(id) {
            return $http.get('/api/newsletters/' + id)
                .then(function (data) {
                    return $q.when(data.data);
                })
        }
    }
})();