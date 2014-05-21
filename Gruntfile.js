module.exports = function(grunt) {

  // Load config.js
  var conf = grunt.file.read('config/config.js');
  conf = conf.replace("var appConfig = ", "");
  conf = conf.substring(0, conf.indexOf(";"));
  conf = eval("("+conf+")");

  // Init grunt
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    watch: {
      scripts: {
        files: ['js/<%= pkg.name %>.js', 'css/<%= pkg.name %>.css'],
        tasks: ['minify'],
        options: {
          spawn: false
        }
      }
    },
    uglify: {
      build: {
        src: 'js/<%= pkg.name %>.js',
        dest: 'js/<%= pkg.name %>.min.js'
      }
    },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'css/',
        src: ['<%= pkg.name %>.css'],
        dest: 'css/',
        ext: '.min.css'
      }
    },
    jasmine: {
      activatoradmin: {
        src: 'js/activatoradmin.js',
        options: {
          specs: 'test/jasmine/spec/*Spec.js',
          host: 'http://localhost'+conf.baseUrl,
          template: require('grunt-template-jasmine-requirejs'),
          templateOptions: {
            requireConfig: {
              paths: {
                text: 'js/lib/text',
                jquery: 'js/lib/jquery.min',
                bootstrap: 'js/lib/bootstrap.min',
                underscore: 'js/lib/underscore-min',
                backbone: 'js/lib/backbone-min',
                backbonePaginator: 'js/lib/backbone.paginator.min'
              },
              shim: {
                bootstrap: {
                  deps: ['jquery']
                },
                underscore: {
                  exports: '_'
                },
                backbone: {
                  deps: ['underscore', 'jquery'],
                  exports: 'Backbone'
                },
                backbonePaginator: {
                  deps: ['backbone']
                }
              }
            }
          }
        }
      }
    },
    phpunit: {
      classes: {
        dir: 'test/phpunit/'
      }
    },
    jshint: {
      all: ['js/<%= pkg.name %>.js']
    },
    uncss: {
      dist: {
        files: {
          'css/activatoradmin.css': ['templates/index.tpl', 'templates/item.tpl', 'templates/login.tpl', 'templates/pagination.tpl']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-jasmine');
  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-uncss');

  grunt.registerTask('default', ['minify', 'test']);
  grunt.registerTask('minify', ['uglify', 'cssmin']);
  grunt.registerTask('test', ['jasmine', 'phpunit', 'jshint']);
  grunt.registerTask('uncss', ['uncss']);
};
