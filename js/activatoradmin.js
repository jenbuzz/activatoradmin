var ActivatorItem = false;
var ActivatorList = false;
var ActivatorItemView = false;
var ActivatorPaginationView = false;
var ActivatorAppView = false;

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

  // Model
  ActivatorItem = Backbone.Model.extend({
    urlRoot: baseUrl+'index.php/item',
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
  ActivatorList = Backbone.Paginator.clientPager.extend({
    model: ActivatorItem,
    paginator_core: {
      type: 'GET',
      dataType: 'json',
      url: baseUrl+'index.php/items'
    },
    paginator_ui: {
      firstPage: 1,
      currentPage: 1,
      perPage: 10,
      totalPages: 10
    },
    parse: function(response) {
      return response;
    }
  });

  // Global Collection
  var ActivatorItems = new ActivatorList();

  // View
  ActivatorItemView = Backbone.View.extend({
    tagName: 'li',
    className: 'well',
    template: _.template(tplItem),
    events: {
      'click #toggle-activate': 'toggleActivate',
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

      this.$el.find('input').tooltip({
        placement : 'top'
      });

      if( typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('show_delete') &&
          appConfig.show_delete ) {

        this.$el.find('#itemDelete-'+model.get('id')).find('#itemDeleteConfirm').on('click', function() {
          model.destroy({success: function(model, response) {
            ActivatorItems.pager();
            $('.modal-backdrop').remove();
          }});
        });
      }

      return this.$el;
    },
    toggleActivate: function() {
      var activeState = this.$el.find('#toggle-activate').get(0).checked ? 1 : 0;
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
      if (ActivatorItems.currentPage==ActivatorItems.firstPage && ActivatorItems.origModels.length <= ActivatorItems.perPage) {} else {
        this.$el.html(this.template(ActivatorItems.info()));
        $('#pagination-container').append(this.$el);
      }
    },
    gotoFirst: function(e) {
      e.preventDefault();
      ActivatorItems.goTo(1);
    },
    gotoPrev: function(e) {
      e.preventDefault();
      ActivatorItems.previousPage();
    },
    gotoNext: function(e) {
      e.preventDefault();
      ActivatorItems.nextPage();
    },
    gotoLast: function(e) {
      e.preventDefault();
      ActivatorItems.goTo(ActivatorItems.information.lastPage);
    },
    gotoPage: function(e) {
      e.preventDefault();
      var page = $(e.target).text();
      ActivatorItems.goTo(page);
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
          ActivatorItems.pager();

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
