$(function(){

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
    events: {
      'click #toggle-activate': 'toggleActivate'
    },
    initialize: function() {
      this.listenTo(this.model, 'change', this.render);
    },
    render: function() {
      var html = '<input id="toggle-activate" type="checkbox" ';
      if(this.model.get('active')==1) {
        html+= 'checked="checked" ';
      }
      html+= '/> '+this.model.get('name');
      html+= '<img src="images/default.jpg" />';

      this.el.innerHTML = html;

      return this;
    },
    toggleActivate: function() {
      var isActive = this.$el.find('#toggle-activate').get(0).checked;
      if(isActive) {
        this.model.save({'active': 1});
      } else {
        this.model.save({'active': 0});
      }
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
            $("#itemlist").append(view.render().el);
          });
        }
      });
    }
  });

  // Start app
  var ActivatorApp = new ActivatorAppView;

});
