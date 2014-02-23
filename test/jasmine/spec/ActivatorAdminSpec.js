(function() {

  describe("ActivatorAdmin Model", function() {
    it("should exist", function() {
      return expect(ActivatorItem).toBeDefined();
    });
    it("should not have an empty string urlRoot", function() {
      var item = new ActivatorItem();
      return expect(item.get('urlRoot')).not.toBe("");
    });
    it("should not have an empty string idAttribute", function() {
      var item = new ActivatorItem();
      return expect(item.get('idAttribute')).not.toBe("");
    });
  });

  describe("ActivatorAdmin Collection", function() {
    it("should exist", function() {
      return expect(ActivatorList).toBeDefined();
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
  });

  describe("ActivatorAdmin AppView", function() {
    it("should exist", function() {
      return expect(ActivatorAppView).toBeDefined();
    });
  });

}).call(this);

