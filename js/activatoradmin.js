$(function(){
  "use strict";

  // Model
  var ActivatorItem = Backbone.Model.extend({
    urlRoot: 'index.php/item',
    idAttribute: 'id',

    id: '',
    active: '',
    name: '',
    image: '',
  });

  // Collection
  var ActivatorList = Backbone.Collection.extend({
    model: ActivatorItem,
    url: 'index.php/items'
  });

  // Global Collection
  var ActivatorItems = new ActivatorList;

  // View
  var ActivatorView = Backbone.View.extend({
    tagName: 'li',
    className: 'well',
    template: _.template($('#item').html()),
    events: {
      'click #toggle-activate': 'toggleActivate',
      'click img': 'toggleImage'
    },
    initialize: function() {
      this.listenTo(this.model, 'change', this.render);
    },
    render: function() {
      var json = this.model.toJSON();
      json.imagePath = '';
      if( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('imagePath') && appConfig.imagePath!='' ) {
        json.imagePath = appConfig.imagePath;
      }

      this.$el.html(this.template(json));

      return this.$el;
    },
    toggleActivate: function() {
      var activeState = this.$el.find('#toggle-activate').get(0).checked ? 1 : 0;
      this.model.save({'active': activeState});
    },
    toggleImage: function() {
      var image = 'images/default.jpg';
      if( this.model.get('image')!='' && 
          this.model.get('image')!=null && 
          typeof appConfig != 'undefined' && 
          appConfig.hasOwnProperty('imagePath') && 
          appConfig.imagePath!='' ) {

        image = appConfig.imagePath + this.model.get('image');
      }

      $('#background').show('fast', 'linear', function() {
        $('#container').append('<img class="img-thumbnail img-full" src="'+image+'" />');
      });

      $('#background').on('click', function() {
        $(this).hide();
        $('#container').find('.img-full').remove();
      });
    }
  });

  // AppView
  var ActivatorAppView = Backbone.View.extend({
    el: $('#container'),
    initialize: function() {
      ActivatorItems.fetch({
        success: function(model, response) {
          $(model.models).each(function(index,item) {
            var view = new ActivatorView({
              model: item
            });
            $("#itemlist").append(view.render());
          });
        }
      });
    }
  });

  // Start app
  var ActivatorApp = new ActivatorAppView;

});
