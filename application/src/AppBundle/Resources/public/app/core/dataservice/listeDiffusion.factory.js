(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceListeDiffusion', dataserviceListeDiffusion);

    dataserviceListeDiffusion.$inject = ['$q', '$http'];
    function dataserviceListeDiffusion($q, $http) {
        return {
            getAll: getAll,
            putListe: putListe,
            postListe: postListe,
            deleteListe: deleteListe
        };

        function getAll() {
            return $http.get('/api/all/listes/diffusion')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function putListe(liste) {
            return $http.put('/api/liste/diffusion', {liste: liste})
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function postListe(nom) {
            return $http.post('/api/listes/' + nom + '/diffusions')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function deleteListe(id) {
            return $http.delete('/api/listes/' + id + '/diffusion')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();
