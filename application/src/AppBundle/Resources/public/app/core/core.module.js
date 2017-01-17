(function() {
    'use strict';

    angular.module('app.core', [
        /*
         * Angular modules
         */
        'angular-loading-bar', 'ngAnimate', 'ngRoute', 'ngSanitize', 'ngIdle',
        /*
         * Our reusable cross app code modules
         */
        'blocks.exception', 'blocks.logger', 'blocks.router', 'ckeditor', 'ngAnimate'
    ]);
})();
