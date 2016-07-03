#ActivatorAdmin

[![Build Status](https://secure.travis-ci.org/dan-lyn/activatoradmin.png?branch=master)](http://travis-ci.org/dan-lyn/activatoradmin)

##Third-Party Libraries

**PHP**
- Slim Framework 3.3.0 (https://github.com/slimphp/Slim)
- Pimple 3.0.2 (https://github.com/silexphp/Pimple)
- PSR Http Message 1.0.0 (https://github.com/php-fig/http-message)
- FastRoute 0.7.0 (https://github.com/nikic/FastRoute)
- Container Interoperability 1.1.0 (https://github.com/container-interop/container-interop)
- Twig 1.24.1 (https://github.com/twigphp/Twig)
- Slim Twig View 2.0.0 (https://github.com/slimphp/Twig-View)
- Monolog 1.17.2 (https://github.com/Seldaek/monolog)
- PSR Log 1.0.0 (https://github.com/php-fig/log)

**JS**
- Backbone.js 1.3.3 (http://backbonejs.org/)
- backbone.paginator 2.0.5 (https://github.com/backbone-paginator/backbone.paginator)
- jQuery 3.0.0 (http://jquery.com/)
- RequireJS 2.2.0 (http://requirejs.org/docs/download.html)
- RequireJS text 2.0.14 (https://github.com/requirejs/text)
- D3.js 3.5.16 (https://github.com/mbostock/d3)

**CSS**
- Bootstrap 3.3.6 (http://getbootstrap.com/)
- Font Awesome 4.6.1 (http://fortawesome.github.io/Font-Awesome/)

**Grunt**
- grunt 0.4.5 (http://gruntjs.com/)
- grunt-contrib-uglify 1.0.1 (https://github.com/gruntjs/grunt-contrib-uglify)
- grunt-contrib-cssmin 1.0.1 (https://github.com/gruntjs/grunt-contrib-cssmin)
- grunt-contrib-jasmine 1.0.3 (https://github.com/gruntjs/grunt-contrib-jasmine)
- grunt-template-jasmine-requirejs 0.2.3 (https://github.com/cloudchen/grunt-template-jasmine-requirejs)
- grunt-phpunit 0.3.6 (https://github.com/SaschaGalley/grunt-phpunit)
- grunt-contrib-watch 1.0.0 (https://github.com/gruntjs/grunt-contrib-watch)
- grunt-contrib-jshint 1.0.0 (https://github.com/gruntjs/grunt-contrib-jshint)
- grunt-contrib-compass 1.1.1 (https://github.com/gruntjs/grunt-contrib-compass)
- grunt-contrib-concat 1.0.1 (https://github.com/gruntjs/grunt-contrib-concat)
- grunt-casperjs 2.1.0 (https://github.com/ronaldlokers/grunt-casperjs)
- grunt-contrib-requirejs 1.0.0 (https://github.com/gruntjs/grunt-contrib-requirejs)

**Gulp**
- gulp 3.9.1 (https://github.com/gulpjs/gulp/)
- gulp-concat 2.6.0 (https://github.com/wearefractal/gulp-concat)
- gulp-uglify 1.5.4 (https://github.com/terinjokes/gulp-uglify/)

##Usage

Login using these fixed credentials: Username = admin & Password = admin. The credentials are set in config/config.ini.

A default database structure can be found in docs/db.sql. Use database mapping as explained under Configuration if the default database structure is different.

##Configuration

Setup the configuration in config/config.ini and config/config.js. Changes to config/config.js should be followed by "grunt uglify" for minifying the javascript.

Mapping of column names in tables allows changing the names for "name", "isactive", and "image" to whatever matches the table in use. It must be set up in both configuration files!
```
name = "name"
isactive = "isactive"
image = "image"
```

Setting up the host and baseurl must also be specified in both configuration files. Baseurl is only needed if ActivatorAdmin is not located in the root directory. Here is the format of "host" and "baseurl" - notice that the protocol http(s) is not needed:
```
host: 'localhost'
baseUrl: '/activatoradmin/'
```

It is possible to enable and disable certain frontend features using some configuration variables in config.js:
```
showInfo: true // Show info button for each item
showDelete: true // Show delete button for deleting a single item

```

Enable/Disable logging in config/config.ini: (logging to docs/activatoradmin.log)
```
[logging]
log = 0
```

##Documentation

See API Documentation generated by phpDocumentor v2.5.0 at ROOT_DIRECTORY/docs/phpdoc/

See the results from PHPLOC at ROOT_DIRECTORY/docs/phploc.csv. Update the results by running update_phploc.sh.

##Testing

Test cases have been created and tested using Jasmine v2.3.4, CasperJS v1.1.0-beta3, and PHPUnit 4.0.20.

Run both Jasmine, CasperJS, and PHPUnit test cases using grunt:
```
grunt test
```

Run PHPUnit test cases from ROOT_DIRECTORY:
```
phpunit test/phpunit
```

Run Jasmine test cases at ROOT_DIRECTORY/test/jasmine/SpecRunner.html

Run CasperJS test cases from ROOT_DIRECTORY:
```
casperjs test test/casperjs
```

##License

ActivatorAdmin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
