(function() {
    'use strict';

    angular.module('app.core', [
        /*
         * Angular modules
         */
        'angular-loading-bar', 'ngRoute', 'ngSanitize', 'ngIdle',
        /*
         * Our reusable cross app code modules
         */
        'blocks.logger', 'blocks.router', 'ckeditor'
    ]);
})();
