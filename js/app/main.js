requirejs.config({
  paths: {
    text: '../lib/text',
    jquery: '../../node_modules/jquery/dist/jquery.min',
    bootstrap: '../../node_modules/bootstrap/dist/js/bootstrap.min',
    underscore: '../lib/underscore-min',
    backbone: '../lib/backbone-min',
    backbonePaginator: '../lib/backbone.paginator.min'
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

require(['app'], function(App) {
  App.initialize();
});
