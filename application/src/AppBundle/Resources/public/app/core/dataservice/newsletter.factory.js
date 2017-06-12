(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceNewsletter', dataserviceNewsletter);

    dataserviceNewsletter.$inject = ['$q', '$http'];
    function dataserviceNewsletter($q, $http) {
        return {
            getNewslettersByCampagne: getNewslettersByCampagne,
            getNewsletter: getNewsletter,
            postNewsletter: postNewsletter,
            deleteNewsletter: deleteNewsletter,
            putNewsletter: putNewsletter,
            getAllLast: getAllLast
        };

        function getAllLast() {
            return $http.get('/api/all/last/newsletter')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

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

        function postNewsletter(newsletter) {
            return $http.post('/api/newsletters', {newsletter: newsletter})
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function putNewsletter(newsletter) {
            return $http.put('/api/newsletter', {newsletter: newsletter})
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function deleteNewsletter(id) {
            return $http.delete('/api/newsletters/' + id)
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();