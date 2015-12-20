define([
  'jquery', 
  'underscore', 
  'backbone',
  'collections/items',
  'views/items',
  'views/pagination',
  'bootstrap'
], function($, _, Backbone, ItemsList, ItemsView, ItemsPaginationView) {
  'use strict';

  var initialize = function() {
    
    var ActivatorItems = new ItemsList([], { mode: 'client' });
    
    var AppView = Backbone.View.extend({
      el: $('#container'),
      events: {
        'click #search': 'search',
        'keyup #searchterm': 'entersearch',
        'click #clearsearch': 'clearsearch'
      },
      initialize: function() {
        ActivatorItems.on('reset', this.addItems, this);

        ActivatorItems.fetch({
          reset: true,
          success: function(model, response) {
            var PaginationView = new ItemsPaginationView(ActivatorItems);
            PaginationView.render();
          }
        });
      },
      addItems: function() {
        $('#itemlist').empty();

        ActivatorItems.each(function(item) {
          var view = new ItemsView({
            model: item
          });
          $('#itemlist').append(view.render(ActivatorItems));
        });
      },
      search: function() {
        var searchterm = $('#searchterm').val();
        if (searchterm!=='') {
          $('#itemlist').empty();

          var searchresults = ActivatorItems.search(searchterm);
          searchresults.each(function(item) {
            var view = new ItemsView({
              model: item
            });
            $('#itemlist').append(view.render(ActivatorItems));
          });

          $('#pagination-container').hide();
        }
      },
      entersearch: function(event) {
        if (event.keyCode===13) {
          this.search();
        }
      },
      clearsearch: function() {
        $('#itemlist').empty();
        $('#searchterm').val('');

        ActivatorItems.fetch({
          reset: true,
          success: function(model, response) {
            $('#pagination-container').show();
          }
        });
      }
    });

    // Start app
    var ActivatorApp = new AppView();
  };

  return {
    initialize: initialize
  };

});
