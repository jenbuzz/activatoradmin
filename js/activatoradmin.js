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
    template: _.template($('#item').html()),
    events: {
      'click #toggle-activate': 'toggleActivate'
    },
    initialize: function() {
      this.listenTo(this.model, 'change', this.render);
    },
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
 
      return this.$el;
    },
    toggleActivate: function() {
      var activeState = this.$el.find('#toggle-activate').get(0).checked ? 1 : 0;
      this.model.save({'active': activeState});
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
