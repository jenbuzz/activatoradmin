define([
  'jquery',
  'underscore',
  'backbone',
  'text!../../../templates/pagination.tpl'
], function($, _, Backbone, tplPagination) {
  'use strict';

  var ItemsPaginationView = Backbone.View.extend({
    events: {
      'click a.first': 'gotoFirst',
      'click a.prev': 'gotoPrev',
      'click a.next': 'gotoNext',
      'click a.last': 'gotoLast',
      'click a.page': 'gotoPage',
    },
    template: _.template(tplPagination),
    initialize: function(ActivatorItems) {
      this.ActivatorItems = ActivatorItems;
      this.ActivatorItems.on('reset', this.render, this);
    },
    render: function() {
      if (this.ActivatorItems.state.currentPage===this.ActivatorItems.state.firstPage && this.ActivatorItems.fullCollection.models.length <= this.ActivatorItems.state.pageSize ) {} else {
        this.ActivatorItems.state.pageSet = [];
        var showPages = 5;
        var iLimitStarter = this.ActivatorItems.state.currentPage;
        var iStart = 1;
        if(this.ActivatorItems.state.currentPage>showPages) {
          iStart = this.ActivatorItems.state.currentPage-showPages;
        } else {
          showPages = 10;
          iLimitStarter = iStart;
        }
        var iLimit = ((this.ActivatorItems.state.currentPage+showPages)<=this.ActivatorItems.state.totalPages) ?
                       (iLimitStarter+showPages) :
                       this.ActivatorItems.state.totalPages+1;
        for(var i=iStart; i<iLimit; i++) {
          this.ActivatorItems.state.pageSet.push(i);
        }

        this.$el.html(this.template(this.ActivatorItems.state));
        $('#pagination-container').append(this.$el);
      }
    },
    gotoFirst: function(e) {
      e.preventDefault();
      this.ActivatorItems.getPage(1);
    },
    gotoPrev: function(e) {
      e.preventDefault();
      if (this.ActivatorItems.state.currentPage>this.ActivatorItems.state.firstPage) {
        this.ActivatorItems.getPreviousPage();
      }
    },
    gotoNext: function(e) {
      e.preventDefault();
      if (this.ActivatorItems.state.currentPage<this.ActivatorItems.state.lastPage) {
        this.ActivatorItems.getNextPage();
      }
    },
    gotoLast: function(e) {
      e.preventDefault();
      this.ActivatorItems.getPage(this.ActivatorItems.state.lastPage);
    },
    gotoPage: function(e) {
      e.preventDefault();
      var page = parseInt($(e.target).text());
      this.ActivatorItems.getPage(page);
    }
  });

  return ItemsPaginationView;
});
