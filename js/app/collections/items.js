define([
  'jquery',
  'underscore',
  'backbone',
  'backbonePaginator',
  'models/item',
  'settings'
], function($, _, Backbone, BackbonePaginator, ItemsModel) {
  'use strict';

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
