define([
  'jquery',
  'underscore',
  'backbone',
  'backbonePaginator',
  'models/items'
], function($, _, Backbone, BackbonePaginator, ItemsModel) {
  'use strict';

  // Setup baseUrl (if ActivatorAdmin is in root the baseUrl should be /)
  var baseUrl = '';
  if( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('baseUrl') ) {
    baseUrl = appConfig.baseUrl;
  }

  // Setup pageSize; default=5
  var pageSize = 5;
  if ( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('pageSize') ) {
    pageSize = appConfig.pageSize;
  }

  var ItemsList = Backbone.PageableCollection.extend({
    model: ItemsModel,
    url: baseUrl+'items',
    state: {
      firstPage: 1,
      currentPage: 1,
      pageSize: pageSize
    },
    search: function(searchterm){
      if( searchterm === '' ) {
        return this;
      }

      var searchlimit = pageSize;
      var searchcount = 0;
      var searchpattern = new RegExp(searchterm, 'gi');
      return _(this.fullCollection.filter(function(data) {

        var dataOk = searchpattern.test(data.get('name'));
        if( dataOk && searchcount<searchlimit ) {
          searchcount++;
          return true;
        }

        return false;
      }));
    }
  });

  return ItemsList;

});
