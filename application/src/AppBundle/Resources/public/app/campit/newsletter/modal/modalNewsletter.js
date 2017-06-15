(function () {
    'use strict';

    angular
        .module('app.core')
        .controller('ModalNewsletter', ModalNewsletter);

    ModalNewsletter.$inject = ['$uibModalInstance', '$q', 'campagne', 'dataserviceNewsletter',
        '$scope', 'logger', 'newsletter', "periodiciteUnite"];

    function ModalNewsletter($uibModalInstance, $q, campagne, dataserviceNewsletter,
        $scope, logger, newsletter, periodiciteUnite) {

        var vm = this;
        vm.showView = false;
        vm.newsletter = newsletter;
        vm.newsletter.dateEnvoi = new Date(newsletter.dateEnvoi);
        vm.campagne = campagne;
        vm.isEdit = angular.isDefined(vm.newsletter.id);
        vm.periodiciteUnite = periodiciteUnite;

        vm.ckeditorOptions = {
            language: 'fr',
            allowedContent: true,
            entities: false,
            disallowedContent : 'img{width,height}'
        };

        CKEDITOR.on('instanceReady', function(ev) {

            // Ends self closing tags the HTML4 way, like <br>.
            ev.editor.dataProcessor.htmlFilter.addRules({
                elements: {
                    $: function(element) {
                        // Output dimensions of images as width and height
                        if (element.name == 'img') {
                            var style = element.attributes.style;

                            if (style) {
                                // Get the width from the style.
                                var match = /(?:^|\s)width\s*:\s*(\d+)px/i.exec(style),
                                    width = match && match[1];

                                // Get the height from the style.
                                match = /(?:^|\s)height\s*:\s*(\d+)px/i.exec(style);
                                var height = match && match[1];

                                // Get the float from the style.
                                match = /(?:^|\s)float\s*:\s*(\w+)/i.exec(style);
                                var float = match && match[1];

                                if (width) {
                                    element.attributes.style = element.attributes.style.replace(/(?:^|\s)width\s*:\s*(\d+)px;?/i, '');
                                    element.attributes.width = width;
                                }

                                if (height) {
                                    element.attributes.style = element.attributes.style.replace(/(?:^|\s)height\s*:\s*(\d+)px;?/i, '');
                                    element.attributes.height = height;
                                }
                                if (float) {
                                    element.attributes.style = element.attributes.style.replace(/(?:^|\s)float\s*:\s*(\w+)/i, '');
                                    element.attributes.align = float;
                                }

                            }
                        }

                        if (!element.attributes.style) delete element.attributes.style;

                        return element;
                    }
                }
            });
        });

        vm.cancel = cancel;
        vm.creerNewsletter = creerNewsletter;
        vm.modifierNewsletter = modifierNewsletter;


        activate();
        function activate() {
            var promises = [];
            if (angular.isDefined(campagne) && campagne.id !== -1) {
                vm.newsletter.campagneId = campagne.id;
            }
            return $q.all(promises).then(function () {
                vm.showView = true;
            });
        }

        function cancel() {
            $uibModalInstance.dismiss();
        }

        function ok() {
            $uibModalInstance.close(vm.newsletter);
        }

        function creerNewsletter(form) {
            if (form.$valid) {
                var n = angular.copy(vm.newsletter);
                var d = n.dateEnvoi;
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                n.dateEnvoi = curr_year + "-" + curr_month + "-" + curr_date;
                vm.ajoutNewsletterEnCours = true;
                dataserviceNewsletter.postNewsletter(n).then(function (newsletter) {
                    vm.ajoutNewsletterEnCours = false;
                    vm.newsletter = newsletter;
                    vm.newsletter.dateEnvoi = new Date(newsletter.dateEnvoi);
                    logger.success('Newsletter créée', true);
                    ok();
                }, function (data) {
                    logger.error('Erreur lors de la création de la newsletter', true);
                    logger.error(data);
                    vm.ajoutNewsletterEnCours = false;
                });
            }
        }

        function modifierNewsletter(form) {
            if (form.$valid) {
                var n = angular.copy(vm.newsletter);
                var d = n.dateEnvoi;
                var curr_date = d.getDate();
                var curr_month = d.getMonth() + 1; //Months are zero based
                var curr_year = d.getFullYear();
                n.dateEnvoi = curr_year + "-" + curr_month + "-" + curr_date;
                vm.ajoutNewsletterEnCours = true;
                dataserviceNewsletter.putNewsletter(n).then(function (newsletter) {
                    vm.ajoutNewsletterEnCours = false;
                    vm.newsletter = newsletter;
                    vm.newsletter.dateEnvoi = new Date(newsletter.dateEnvoi);
                    logger.success('Newsletter créée', true);
                    ok();
                }, function (data) {
                    logger.error('Erreur lors de la création de la newsletter', true);
                    logger.error(data);
                    vm.ajoutNewsletterEnCours = false;
                });
            }
        }

        ////////////////// Date picker \\\\\\\\\\\\\\\

        $scope.today = function() {
            vm.newsletter.dateEnvoi = new Date();
        };

        $scope.clear = function() {
            vm.newsletter.dateEnvoi = null;
        };

        $scope.inlineOptions = {
            customClass: getDayClass,
            minDate: new Date(),
            showWeeks: true
        };

        $scope.dateOptions = {
            // dateDisabled: disabled,
            formatYear: 'yy',
            maxDate: new Date(2020, 5, 22),
            minDate: new Date(2000, 1, 1),
            startingDay: 1
        };

        // Disable weekend selection
        // function disabled(data) {
        //     var date = data.date,
        //         mode = data.mode;
        //     return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        // }

        $scope.toggleMin = function() {
            $scope.inlineOptions.minDate = $scope.inlineOptions.minDate ? null : new Date();
            $scope.dateOptions.minDate = $scope.inlineOptions.minDate;
        };

        $scope.toggleMin();

        $scope.open = function() {
            $scope.popup.opened = true;
        };

        $scope.format = 'dd/MM/yyyy';
        $scope.altInputFormats = ['M!/d!/yyyy'];

        $scope.popup = {
            opened: false
        };

        function getDayClass(data) {
            var date = data.date,
                mode = data.mode;
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0,0,0,0);

                for (var i = 0; i < $scope.events.length; i++) {
                    var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }
            return '';
        }

    }
})();
