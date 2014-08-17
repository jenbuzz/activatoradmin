casper.test.begin('Title is ActivatorAdmin', 1, function suite(test) {

  phantom.injectJs("config/config.js");

  casper.start('http://'+appConfig.host+appConfig.baseUrl, function() {
    test.assertTitle('ActivatorAdmin');
  });

  casper.run(function() {
    test.done();
  });

});
