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
            getDestinataireByListeDiffusion: getDestinataireByListeDiffusion
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

        function postDestinataire(destinataire) {
            return $http.post('/api/destinataires', {destinataire: destinataire})
                .then(function (data) {
                    return $q.when(data.data);
                });
        }

        // function putAction(action) {
        //     return $http.put('/api/action/meeting', {action: action})
        //         .then(function (data) {
        //             return $q.when(data.data);
        //         });
        // }
    }
})();
