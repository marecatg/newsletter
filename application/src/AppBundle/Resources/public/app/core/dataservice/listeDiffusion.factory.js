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
            postListe: postListe
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
    }
})();
