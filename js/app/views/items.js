define([
  'jquery',
  'underscore',
  'backbone',
  'text!../../../templates/item.tpl',
  'text!../../../templates/pagination.tpl',
  'settings'
], function($, _, Backbone, tplItem, tplPagination) {
  'use strict';

  var ItemsView = Backbone.View.extend({
    tagName: 'li',
    className: 'well',
    template: _.template(tplItem),
    events: {
      'click .toggle-activate': 'toggleActivate',
      'click img': 'toggleImage'
    },
    initialize: function() {},
    render: function(ActivatorItems) {
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
          appConfig.hasOwnProperty('showDelete') &&
          appConfig.showDelete ) {

        json.show_delete = appConfig.showDelete;
      } else {
        json.show_delete = false;
      }
      if( typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('showInfo') &&
          appConfig.showInfo ) {

        json.show_info = appConfig.showInfo;
      } else {
        json.show_info = false;
      }
      this.$el.html(this.template(json));

      this.$el.find('label').tooltip({
        placement : 'left'
      });

      if( typeof appConfig != 'undefined' &&
          appConfig.hasOwnProperty('showDelete') &&
          appConfig.showDelete ) {

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

      $('body').append('<div id="background" class="backgroundOverlay"></div>');

      $('#background').show('fast', 'linear', function() {
        $('#container').append('<img class="img-thumbnail img-full" src="'+image+'" style="position: absolute; top: '+imgTop+'px; left: '+imgLeft+'px" />');
      });

      $('#background').on('click', function() {
        $('#container').find('.img-full').remove();
        $(this).remove();
      });
    }
  });
  
  return ItemsView;

});
