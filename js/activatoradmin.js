var ActivatorItem = {},
    ActivatorList = {},
    ActivatorItemView = {},
    ActivatorPaginationView = {},
    ActivatorAppView = {};

require([
  'text!templates/item.tpl',
  'text!templates/pagination.tpl',
  'jquery',
  'bootstrap',
  'underscore',
  'backbone',
  'backbonePaginator'
], function(tplItem, tplPagination) {
  "use strict";

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

  // Model
  ActivatorItem = Backbone.Model.extend({
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

  // Collection
  ActivatorList = Backbone.PageableCollection.extend({
    model: ActivatorItem,
    url: baseUrl+'items',
    state: {
      firstPage: 1,
      currentPage: 1,
      pageSize: pageSize
    }
  });

  // Global Collection
  var ActivatorItems = new ActivatorList([], { mode: "client" });

  // View
  ActivatorItemView = Backbone.View.extend({
    tagName: 'li',
    className: 'well',
    template: _.template(tplItem),
    events: {
      'click .toggle-activate': 'toggleActivate',
      'click img': 'toggleImage'
    },
    initialize: function() {},
    render: function() {
      var model = this.model;
      var image = '';

      if( model.get('image')!=='' &&
          model.get('image')!==null &&
          typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('imagePath') &&
          appConfig.imagePath!=='' &&
          model.get('image').indexOf(baseUrl+appConfig.imagePath)!==0 ) {

        image = baseUrl + appConfig.imagePath + model.get('image');
        model.set('image', image);
      } else if( model.get('image')==='' || model.get('image')===null ) {
        image = baseUrl + 'images/default.jpg';
        model.set('image', image);
      }

      var json = model.toJSON();
      if( typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('show_delete') &&
          appConfig.show_delete ) {

        json.show_delete = appConfig.show_delete;
      } else {
        json.show_delete = false;
      }
      if( typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('show_info') &&
          appConfig.show_info ) {

        json.show_info = appConfig.show_info;
      } else {
        json.show_info = false;
      }
      this.$el.html(this.template(json));

      this.$el.find('label').tooltip({
        placement : 'left'
      });

      if( typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('show_delete') &&
          appConfig.show_delete ) {

        this.$el.find('#itemDelete-'+model.get('id')).find('#itemDeleteConfirm').on('click', function() {
          model.destroy({success: function(model, response) {
            ActivatorItems.getFirstPage({ fetch: true });
            $('.modal-backdrop').remove();
          }});
        });
      }

      return this.$el;
    },
    toggleActivate: function() {
      var activeState = this.$el.find('.toggle-activate').get(0).checked ? 1 : 0;
      this.model.save({'isactive': activeState});
      this.render();
    },
    toggleImage: function() {
      var image = this.model.get('image');
      var imgTop = this.$el.find('img').get(0).offsetTop;
      var imgLeft = this.$el.find('img').get(0).offsetLeft;

      $('body').append('<div id="background"></div>');

      $('#background').show('fast', 'linear', function() {
        $('#container').append('<img class="img-thumbnail img-full" src="'+image+'" style="position: absolute; top: '+imgTop+'px; left: '+imgLeft+'px" />');
      });

      $('#background').on('click', function() {
        $('#container').find('.img-full').remove();
        $(this).remove();
      });
    }
  });

  // PaginationView
  ActivatorPaginationView = Backbone.View.extend({
    events: {
      'click a.first': 'gotoFirst',
      'click a.prev': 'gotoPrev',
      'click a.next': 'gotoNext',
      'click a.last': 'gotoLast',
      'click a.page': 'gotoPage'
    },
    template: _.template(tplPagination),
    initialize: function() {
      ActivatorItems.on('reset', this.render, this);
    },
    render: function() {
      if (ActivatorItems.state.currentPage==ActivatorItems.state.firstPage && ActivatorItems.fullCollection.models.length <= ActivatorItems.state.pageSize) {} else {
        ActivatorItems.state.pageSet = [];
        var showPages = 5;
        var iLimitStarter = ActivatorItems.state.currentPage;
        var iStart = 1;
        if(ActivatorItems.state.currentPage>showPages) {
          iStart = ActivatorItems.state.currentPage-showPages;
        } else {
          showPages = 10;
          iLimitStarter = iStart;
        }
        var iLimit = ((ActivatorItems.state.currentPage+showPages)<=ActivatorItems.state.totalPages) ?
                       (iLimitStarter+showPages) : 
                       ActivatorItems.state.totalPages+1;
        for(var i=iStart; i<iLimit; i++) {
          ActivatorItems.state.pageSet.push(i);
        }
        
        this.$el.html(this.template(ActivatorItems.state));
        $('#pagination-container').append(this.$el);
      }
    },
    gotoFirst: function(e) {
      e.preventDefault();
      ActivatorItems.getPage(1);
    },
    gotoPrev: function(e) {
      e.preventDefault();
      if(ActivatorItems.state.currentPage>ActivatorItems.state.firstPage) {
        ActivatorItems.getPreviousPage();
      }
    },
    gotoNext: function(e) {
      e.preventDefault();
      if(ActivatorItems.state.currentPage<ActivatorItems.state.lastPage) {
        ActivatorItems.getNextPage();
      }
    },
    gotoLast: function(e) {
      e.preventDefault();
      ActivatorItems.getPage(ActivatorItems.state.lastPage);
    },
    gotoPage: function(e) {
      e.preventDefault();
      var page = parseInt($(e.target).text());
      ActivatorItems.getPage(page);
    }
  });

  // AppView
  ActivatorAppView = Backbone.View.extend({
    el: $('#container'),
    initialize: function() {
      ActivatorItems.on('reset', this.addItems, this);

      ActivatorItems.fetch({
        reset: true,
        success: function(model, response) {
          var PaginationView = new ActivatorPaginationView();
          PaginationView.render();
        }
      });
    },
    addItems: function() {
      $('#itemlist').empty();

      ActivatorItems.each(function(item) {
        var view = new ActivatorItemView({
          model: item
        });
        $('#itemlist').append(view.render());
      });
    }
  });

  // Start app
  var ActivatorApp = new ActivatorAppView();

});
