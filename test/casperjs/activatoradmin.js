phantom.injectJs("config/config.js");

casper.test.begin('URL is reachable', 1, function suite(test) {

  casper.start('http://'+appConfig.host+appConfig.baseUrl, function() {
    test.assertHttpStatus(200);
  });

  casper.run(function() {
    test.done();
  });

});

casper.test.begin('Title is ActivatorAdmin', 1, function suite(test) {

  casper.start('http://'+appConfig.host+appConfig.baseUrl, function() {
    test.assertTitle('ActivatorAdmin');
  });

  casper.run(function() {
    test.done();
  });

});

casper.test.begin('Login is working', 2, function suite(test) {

  var url = 'http://'+appConfig.host+appConfig.baseUrl;
  var urlLogin = url+'login';

  casper.start(url, function() {
    test.assertEquals(this.getCurrentUrl(), urlLogin);

    this.fill('form[action="/activatoradmin/login"]', {
      'username': 'admin',
      'password': 'admin',
    }, true);
  });

  casper.waitForSelector('#itemlist', function() {
    test.assertEquals(this.getCurrentUrl(), url);
  });

  casper.run(function() {
    test.done();
  });

});

casper.test.begin('Search is working', 2, function suite(test) {

  casper.waitForSelector('#searchterm', function() {
    this.sendKeys('#searchterm', 'a long title that will always return 0 results');
    this.click('#search');

    this.wait(200);

    test.assertElementCount('#itemList li', 0);
  });

  casper.then(function() {
    this.click('#clearsearch');
  });

  casper.waitForSelector('#pagination-container', function() {
    test.assertVisible('#pagination-container');
  });

  casper.run(function() {
    test.done();
  });

});

casper.test.begin('Logout is working', 2, function suite(test) {

  var url = 'http://'+appConfig.host+appConfig.baseUrl;
  var urlLogin = url+'login';

  casper.start(url, function() {
    test.assertEquals(this.getCurrentUrl(), url);

    this.click('.logout form button');
  });

  casper.waitForSelector('#username', function() {
    test.assertEquals(this.getCurrentUrl(), urlLogin);
  });

  casper.run(function() {
    test.done();
  });

});
