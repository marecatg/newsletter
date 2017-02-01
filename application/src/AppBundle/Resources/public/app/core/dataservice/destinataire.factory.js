(function () {
    'use strict';

    angular
        .module('app.core')
        .factory('dataserviceDestinataire', dataserviceDestinataire);

    dataserviceDestinataire.$inject = ['$q', '$http'];
    function dataserviceDestinataire($q, $http) {
        var service = {
            postDestinataire: postDestinataire,
        };

        return service;

        // function getActions(meetingId) {
        //     return $http.get('/api/actions/' + meetingId + '/meeting')
        //         .then(function (data) {
        //             return $q.when(data.data);
        //         });
        // }

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
