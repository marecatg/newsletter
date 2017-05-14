(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceDestinataire', dataserviceDestinataire);

    dataserviceDestinataire.$inject = ['$q', '$http'];
    function dataserviceDestinataire($q, $http) {
        return {
            postDestinataire: postDestinataire,
            getAllDestinataire: getAllDestinataire,
            getDestinataireByListeDiffusion: getDestinataireByListeDiffusion,
            deleteDestinataire: deleteDestinataire,
            putDestinataire: putDestinataire
        };

        function getDestinataireByListeDiffusion(idListeDiffusion) {
            return $http.get('/api/destinataires/' + idListeDiffusion + '/by/liste/diffusion')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function getAllDestinataire() {
            return $http.get('/api/all/destinataire')
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function postDestinataire(destinataire, listeId) {
            return $http.post('/api/destinataires', {destinataire: destinataire, listeId: listeId})
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function putDestinataire(destinataire) {
            return $http.put('/api/destinataire', {destinataire: destinataire})
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        function deleteDestinataire(id) {
            return $http.delete('/api/destinataires/' + id)
                .then(function (data) {
                    return $q.when(data.data);
                });
        }
    }
})();
