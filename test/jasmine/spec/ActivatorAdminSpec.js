(function() {

  describe("ActivatorAdmin Model", function() {
    it("should exist", function() {
      return expect(ActivatorItem).toBeDefined();
    });
    it("should not have an empty string urlRoot", function() {
      var item = new ActivatorItem();
      return expect(item.get("urlRoot")).not.toBe("");
    });
    it("should not have an empty string idAttribute", function() {
      var item = new ActivatorItem();
      return expect(item.get("idAttribute")).not.toBe("");
    });
  });

  describe("ActivatorAdmin Collection", function() {
    it("should exist", function() {
      return expect(ActivatorList).toBeDefined();
    });
    it("should have the model equal ActivatorItem", function() {
      var collection = new ActivatorList();
      return expect(collection.model).toEqual(ActivatorItem);
    });
  });

  describe("ActivatorAdmin ItemView", function() {
    it("should exist", function() {
      return expect(ActivatorItemView).toBeDefined();
    });
  });

  describe("ActivatorAdmin PaginationView", function() {
    it("should exist", function() {
      return expect(ActivatorPaginationView).toBeDefined();
    });
    it("should have 5 click events", function() {
      return expect(Object.keys(ActivatorPaginationView.prototype.events).length).toEqual(5);
    });
  });

  describe("ActivatorAdmin AppView", function() {
    it("should exist", function() {
      return expect(ActivatorAppView).toBeDefined();
    });
    it("should have element set to #container", function() {
      return expect(ActivatorAppView.prototype.el.selector).toEqual("#container");
    });
  });

}).call(this);

