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
      if( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('db_mapping') ) {
        if( appConfig.db_mapping.hasOwnProperty('name') && appConfig.db_mapping.name!=='' ) {
          this.set('name', this.get(appConfig.db_mapping.name));
        }
        if( appConfig.db_mapping.hasOwnProperty('isactive') && appConfig.db_mapping.isactive!=='' ) {
          this.set('isactive', this.get(appConfig.db_mapping.isactive));
        }
        if( appConfig.db_mapping.hasOwnProperty('image') && appConfig.db_mapping.image!=='' ) {
          this.set('image', this.get(appConfig.db_mapping.image));
        }
      }
    }
  });

  return ItemsModel;

});
