/* require.js configuration should not be manipulated! */
requirejs.config({
  paths: {
    text: 'js/lib/text',
    jquery: 'js/lib/jquery.min',
    bootstrap: 'js/lib/bootstrap.min',
    underscore: 'js/lib/underscore-min',
    backbone: 'js/lib/backbone-min',
    backbonePaginator: 'js/lib/backbone.paginator.min'
  },
  shim: {
    bootstrap: {
      deps: ['jquery']
    },
    underscore: {
      exports: '_'
    },
    backbone: {
      deps: ['underscore', 'jquery'],
      exports: 'Backbone'
    },
    backbonePaginator: {
      deps: ['backbone']
    }
  }
});
