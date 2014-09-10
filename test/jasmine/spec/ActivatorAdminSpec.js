define(['models/item', 'collections/items', 'views/items', 'views/pagination', 'app'], function(ItemsModel, ItemsList, ItemsView, ItemsPaginationView, App) {
  
  describe("ActivatorAdmin Model", function() {
    it("should exist", function() {
      return expect(ItemsModel).toBeDefined();
    });
    it("should not have an empty string urlRoot", function() {
      var item = new ItemsModel();
      return expect(item.get("urlRoot")).not.toBe("");
    });
    it("should not have an empty string idAttribute", function() {
      var item = new ItemsModel();
      return expect(item.get("idAttribute")).not.toBe("");
    });
  });

  describe("ActivatorAdmin Collection", function() {
    it("should exist", function() {
      return expect(ItemsList).toBeDefined();
    });
    it("should have the url set to 'items'", function() {
      var list = new ItemsList();
      return expect(list.url).toEqual('items');
    });
  });

  describe("ActivatorAdmin ItemView", function() {
    it("should exist", function() {
      return expect(ItemsView).toBeDefined();
    });
  });

  describe("ActivatorAdmin PaginationView", function() {
    it("should exist", function() {
      return expect(ItemsPaginationView).toBeDefined();
    });
    it("should have 5 click events", function() {
      var view = new ItemsPaginationView(new ItemsList([]));
      return expect(Object.keys(view.events).length).toEqual(5);
    });
  });

  describe("ActivatorAdmin AppView", function() {
    it("should exist", function() {
      return expect(App).toBeDefined();
    });
    it("should have initialize function", function() {
      return expect(App.initialize).toBeDefined();
    });
  });

});

