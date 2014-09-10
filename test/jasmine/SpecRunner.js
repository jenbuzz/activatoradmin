(function() {
  'use strict';

  require.config({
    baseUrl: '../../js/app/',
    paths: {
      'jasmine': '../lib/jasmine/jasmine',
      'jasmine-html': '../lib/jasmine/jasmine-html',
      'boot': '../lib/jasmine/boot',

      'text': '../lib/text',
      'jquery': '../lib/jquery.min',
      'bootstrap': '../lib/bootstrap.min',
      'underscore': '../lib/underscore-min',
      'backbone': '../lib/backbone-min',
      'backbonePaginator': '../lib/backbone.paginator.min'
    },
    shim: {
      'jasmine': {
        exports: 'window.jasmineRequire'
      },
      'jasmine-html': {
        deps: ['jasmine'],
        exports: 'window.jasmineRequire'
      },
      'boot': {
        deps: ['jasmine', 'jasmine-html'],
        exports: 'window.jasmineRequire'
      },

      'bootstrap': {
        deps: ['jquery']
      },
      'underscore': {
        exports: '_'
      },
      'backbone': {
        deps: ['underscore', 'jquery'],
        exports: 'Backbone'
      },
      'backbonePaginator': {
        deps: ['backbone']
      }
    }
  });
  
  var specs = [
    '../../test/jasmine/spec/ActivatorAdminSpec'
  ];

  require(['boot'], function () {
    require(specs, function () {
      window.onload();
    });
  });

})();
