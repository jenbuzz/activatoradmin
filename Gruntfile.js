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
        files: ['sass/<%= pkg.name %>.scss', 'js/app/*.js', 'js/app/models/*.js', 'js/app/collections/*.js', 'js/app/views/*.js', 'config/config.js'],
        tasks: ['compass', 'minify', 'concat:css', 'requirejs'],
        options: {
          spawn: false
        }
      }
    },
    compass: {
      dist: {
        options: {
          config: 'config.rb'
        }
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
    concat: {
      css: {
        src: ['css/bootstrap.min.css', 'css/bootstrap-theme.min.css', 'css/font-awesome.min.css', 'css/activatoradmin.min.css'],
        dest: 'css/dist.css',
      }
    },
    requirejs: {
      compile: {
        options: {
          baseUrl: "js/app",
          mainConfigFile: "js/app/main.js",
          name: 'main',
          out: "js/dist/<%= pkg.name %>.js"
        }
      }
    },
    uglify: {
      build: {
        src: 'config/config.js',
        dest: 'config/config.min.js'
      }
    },
    jasmine: {
      activatoradmin: {
        src: 'js/activatoradmin.js',
        options: {
          specs: 'test/jasmine/spec/*Spec.js',
          host: 'http://'+conf.host+conf.baseUrl,
          template: require('grunt-template-jasmine-requirejs'),
          templateOptions: {
            requireConfigFile: 'config/requirejs.config.js'
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
      all: ['js/app/*.js', 'js/app/models/*.js', 'js/app/collections/*.js', 'js/app/views/*.js']
    },
    casperjs: {
      options: {
        async: {
          parallel: false
        }
      },
      files: ['test/casperjs/*.js']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jasmine');
  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-casperjs');
  grunt.loadNpmTasks('grunt-contrib-requirejs');

  grunt.registerTask('default', ['minify', 'test']);
  grunt.registerTask('compile', ['compass', 'requirejs']);
  grunt.registerTask('minify', ['cssmin', 'uglify']);
  grunt.registerTask('test', ['jasmine', 'phpunit', 'jshint', 'casperjs']);
};
