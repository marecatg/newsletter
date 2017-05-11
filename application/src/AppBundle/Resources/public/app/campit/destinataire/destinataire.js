(function () {
    'use strict';

    angular
        .module('app.destinataire')
        .controller('Destinataire', Destinataire);

    Destinataire.$inject = ['$q', 'dataserviceDestinataire', 'logger', 'dataserviceListeDiffusion', '$uibModal',
        'FileUploader', '$scope'];

    function Destinataire($q, dataserviceDestinataire, logger, dataserviceListeDiffusion, $uibModal,
                          FileUploader, $scope) {

        var vm = this;
        vm.showView = false;
        vm.newDestinataire = {
            nom: null,
            prenom: null,
            email: null
        };
        vm.ajoutDestinataireenCours = false;
        vm.destinataires = null;
        vm.listesDiffusion = [
            {
                id: -1,
                nom: 'Sans liste de diffusion'
            }
        ];
        vm.currentListeDiffusion = vm.listesDiffusion[0];
        vm.newList = {
            nom: null,
            fileName: null
        };

        //upload limit in octet
        vm.limit = 2097152;
        vm.limitMo = vm.limit / Math.pow(1024, 2);
        vm.saveInProgress = false;

        //uploader
        vm.uploader = new FileUploader({
            removeAfterUpload: true,
            queueLimit: 1,
            filters: [{
                name: 'size',
                fn: function (item) {
                    if (item.size > vm.limit) {
                        vm.errorFileLimit = true;
                        return false;
                    } else {
                        vm.errorFileLimit = false;
                        return true;
                    }
                }
            }]
        });
        vm.lastListRecord = null;
        vm.createOrUpdateDest = 0;

        vm.creerDestinataire = creerDestinataire;
        vm.rechercheDestinatairesByListe = rechercheDestinatairesByListe;
        vm.openGestionDestinataireModal = openGestionDestinataireModal;
        vm.postListeDiffusion = postListeDiffusion;
        vm.resetListeForm = resetListeForm;
        vm.deleteListe = deleteListe;
        vm.changeCreateOrUpdateDest = changeCreateOrUpdateDest;
        vm.modifierDestinataire = modifierDestinataire;

        vm.uploader.onCompleteItem = onCompleteItem;
        vm.uploader.onBeforeUploadItem = onBeforeUploadItem;
        vm.uploader.onErrorItem = onErrorItem;
        vm.uploader.onAfterAddingFile = onAfterAddingFile;

        activate();

        function activate() {
            var promises = [initListesDiffusion(),
                rechercheDestinatairesByListe(null)];
            return $q.all(promises).then(function () {
                vm.showView = true;
                logger.info('Activated Destinataire View');
            });
        }

        function initListesDiffusion() {
            return dataserviceListeDiffusion.getAll()
                .then(function (data) {
                    angular.forEach(data, function (liste) {
                        vm.listesDiffusion.push(liste);
                    });
                }, function () {
                    logger.error('Erreur lors de la récupération des listes de diffusion', true);
                    logger.error(data.data);
                });
        }

        function rechercheDestinatairesByListe(listeDiffusion) {
            if (listeDiffusion === null) {
                listeDiffusion = vm.currentListeDiffusion;
            }
            return dataserviceDestinataire.getDestinataireByListeDiffusion(listeDiffusion.id)
                .then(function (data) {
                    vm.destinataires = data;
                }, function () {
                    logger.error('Erreur lors de la récupération des destinataires', true);
                    logger.error(data);
                });
        }

        function changeCreateOrUpdateDest(destinataire) {
            if (vm.createOrUpdateDest == 0) { //ne pas changer le "==" !!!
                vm.newDestinataire = {
                    nom: null,
                    prenom: null,
                    email: null
                };
            } else {
                vm.newDestinataire = destinataire;

            }
        }

        function creerDestinataire(form) {
            if (form.$valid) {
                vm.ajoutDestinataireenCours = true;
                dataserviceDestinataire.postDestinataire(vm.newDestinataire, vm.currentListeDiffusion.id)
                    .then(function (destinataire) {
                    vm.ajoutDestinataireenCours = false;
                    vm.destinataires.push(destinataire);
                    vm.newDestinataire = {
                        nom: null,
                        prenom: null,
                        email: null
                    };
                    logger.success('Destinataire ajouté', true)
                }, function (data) {
                    logger.error('Erreur lors de l\'ajout du destinataire', true);
                    logger.error(data);
                    vm.ajoutDestinataireenCours = false;
                });
            }
        }

        function modifierDestinataire(form) {
            if (form.$valid) {
                vm.ajoutDestinataireenCours = true;
                dataserviceDestinataire.putDestinataire(vm.newDestinataire).then(function (destinataire) {
                    vm.ajoutDestinataireenCours = false;
                    angular.forEach(vm.destinataires, function(d) {
                       if (d.id === destinataire.id) {
                           d.nom = destinataire.nom;
                           d.prenom = destinataire.prenom;
                           d.email = destinataire.email;
                           d.id = destinataire.id;
                       }
                    });
                    vm.createOrUpdateDest = 0;
                    vm.changeCreateOrUpdateDest();
                    logger.success('Destinataire modifié', true)
                }, function (data) {
                    logger.error('Erreur lors de la modification du destinataire', true);
                    logger.error(data);
                    vm.ajoutDestinataireenCours = false;
                });
            }
        }

        function openGestionDestinataireModal() {
            $uibModal.open({
                templateUrl: 'bundles/app/app/campit/destinataire/modal/modalGestionDestinataire.html',
                controller: 'ModalGestionDestinataire',
                controllerAs: 'vm',
                size: 'md',
                windowClass: 'clearfix',
                resolve: {
                    currentDestinataires: function () {
                        return vm.destinataires
                    }
                }
            }).result.then(function (users) {
                vm.currentListeDiffusion.users = users;
                dataserviceListeDiffusion.putListe(vm.currentListeDiffusion).then(function (data) {
                    vm.destinataires = data.liste.destinataires;
                }, function (data) {
                    logger.error('Erreur lors de l\'ajout des destinataire', true);
                    logger.error(data);
                });
            });
        }

        function deleteListe(id) {
            return dataserviceListeDiffusion.deleteListe(id).then(function (data) {
                vm.listesDiffusion = [
                    {
                        id: -1,
                        nom: 'Sans liste de diffusion'
                    }
                ];
                vm.currentListeDiffusion = vm.listesDiffusion[0];
                initListesDiffusion();
                rechercheDestinatairesByListe(null);
                logger.success('Liste supprimée', true);
            }, function (data) {
                logger.error('Erreur lors de la suppression', true);
                logger.error(data);
            });
        }

        function postListeDiffusion(form) {
            if (form.$valid) {
                return dataserviceListeDiffusion.postListe(vm.newList.nom).then(function (data) {
                    importUser(data.liste);
                }, function (data) {
                    logger.error('Echec de la création', true);
                    logger.error(data);
                });
            }
        }

        function resetListeForm(form) {
            form.$submitted = false;
            vm.newList = {
                nom: null,
                fileName: null
            };
            angular.element('#file').val(null);
            vm.uploader.queue = [];
        }

        function importUser(lastListRecord) {
            if (lastListRecord.id) {
                vm.uploader.url = '/api/listes/' + lastListRecord.id + '/files';
                vm.uploader.uploadAll();
                vm.listeTmp = {
                    id: lastListRecord.id,
                    nom: lastListRecord.nom
                };
            } else {
                logger.error("Impossible d'uploader", true);
            }
        }

        //Uploader function
        function onCompleteItem(fileItem, response, status, headers) {
            if (status === 200) {
                logger.success('Le fichier est enregistré.', true);
                if (vm.listeTmp) {
                    vm.listesDiffusion.push(vm.listeTmp);
                }
                resetListeForm($scope.formListe);
            } else if (status === 412) {
                console.log(response);
            }
            vm.listeTmp = null;
        }

        //set the id project in url before upload
        function onBeforeUploadItem(item) {
            item.url = vm.uploader.url;
        }

        function onErrorItem(item, response, status) {
            vm.listeTmp = null;
            if (status === 406) {
                logger.error("Le fichier n'a pas était enregistré car il contient des utilisateurs qui " +
                    "existent déjà dans l'application.", true);
            } else {
                logger.error("Le fichier n'a pas était enregistré pour cause d'erreur.", true);
            }
        }

        function onAfterAddingFile(item) {
            vm.newList.fileName = item.file.name;
        }
    }
})();
