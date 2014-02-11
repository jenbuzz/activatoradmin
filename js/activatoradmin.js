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
  window.ActivatorItem = Backbone.Model.extend({
    urlRoot: baseUrl+'index.php/item',
    idAttribute: 'id',
    initialize: function() {
      if( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('db_mapping') ) {
        if( appConfig.db_mapping.hasOwnProperty('name') && appConfig.db_mapping.name!='' ) {
          this.set('name', this.get(appConfig.db_mapping.name));
        }
        if( appConfig.db_mapping.hasOwnProperty('isactive') && appConfig.db_mapping.isactive!='' ) {
          this.set('isactive', this.get(appConfig.db_mapping.isactive));
        }
        if( appConfig.db_mapping.hasOwnProperty('image') && appConfig.db_mapping.image!='' ) {
          this.set('image', this.get(appConfig.db_mapping.image));
        }
      }
    }
  });

  // Collection
  window.ActivatorList = Backbone.Paginator.clientPager.extend({
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
  window.ActivatorItemView = Backbone.View.extend({
    tagName: 'li',
    className: 'well',
    template: _.template(tplItem),
    events: {
      'click #toggle-activate': 'toggleActivate',
      'click img': 'toggleImage'
    },
    initialize: function() {
      this.listenTo(this.model, 'change', this.render);
    },
    render: function() {
      if( this.model.get('image')!='' &&
          this.model.get('image')!==null &&
          typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('imagePath') &&
          appConfig.imagePath!='' &&
          this.model.get('image').indexOf(baseUrl+appConfig.imagePath)!==0 ) {

        var image = baseUrl + appConfig.imagePath + this.model.get('image');
        this.model.set('image', image);
      } else if( this.model.get('image')=='' || this.model.get('image')===null ) {
        var image = baseUrl + 'images/default.jpg';
        this.model.set('image', image);
      }

      this.$el.html(this.template(this.model.toJSON()));

      this.$el.find('input').tooltip({
        placement : 'top'
      });

      return this.$el;
    },
    toggleActivate: function() {
      var activeState = this.$el.find('#toggle-activate').get(0).checked ? 1 : 0;
      this.model.save({'isactive': activeState});
    },
    toggleImage: function() {
      var image = this.model.get('image');
      var imgTop = this.$el.find('img').get(0).offsetTop;
      var imgLeft = this.$el.find('img').get(0).offsetLeft;

      $('#background').show('fast', 'linear', function() {
        $('#container').append('<img class="img-thumbnail img-full" src="'+image+'" style="position: absolute; top: '+imgTop+'px; left: '+imgLeft+'px" />');
      });

      $('#background').on('click', function() {
        $(this).hide();
        $('#container').find('.img-full').remove();
      });
    }
  });

  // PaginationView
  window.ActivatorPaginationView = Backbone.View.extend({
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
      this.$el.html(this.template(ActivatorItems.info()));
      $('#pagination-container').append(this.$el);
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
  window.ActivatorAppView = Backbone.View.extend({
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
