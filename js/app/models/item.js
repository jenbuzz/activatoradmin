define([
  'jquery',
  'underscore',
  'backbone',
  'settings'
], function($, _, Backbone) {
  'use strict';

  var ItemsModel = Backbone.Model.extend({
    urlRoot: baseUrl+'item',
    idAttribute: 'id',
    initialize: function() {
      if (typeof appConfig !== 'undefined' && appConfig.hasOwnProperty('dbMapping')) {
        if (appConfig.dbMapping.hasOwnProperty('name') && appConfig.dbMapping.name!=='') {
          this.set('name', this.get(appConfig.dbMapping.name));
        }
        if (appConfig.dbMapping.hasOwnProperty('isactive') && appConfig.dbMapping.isactive!=='' ) {
          this.set('isactive', this.get(appConfig.dbMapping.isactive));
        }
        if (appConfig.dbMapping.hasOwnProperty('image') && appConfig.dbMapping.image!=='') {
          this.set('image', this.get(appConfig.dbMapping.image));
        }
      }
    }
  });

  return ItemsModel;
});
