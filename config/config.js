var appConfig = {
  // Host...
  host: 'localhost',

  // Path to this application (should be '/' if in root)
  baseUrl: '/activatoradmin/',

  // Path to images (excluding default.jpg)
  imagePath: 'images/',

  // Map default db column structure to other naming conventions
  db_mapping: {
    name: 'name',
    isactive: 'isactive',
    image: 'image'
  },

  // Number of items on each page
  pageSize: 10,

  // Show info button for each item
  show_info: true,

  // Show delete button for deleting a single item
  show_delete: true
};

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

