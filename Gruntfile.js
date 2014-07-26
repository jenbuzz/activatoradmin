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
        files: ['sass/<%= pkg.name %>.scss', 'js/<%= pkg.name %>.js', 'css/<%= pkg.name %>.css'],
        tasks: ['compass', 'minify', 'concat:css'],
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
    concat: {
      css: {
        src: ['css/activatoradmin.min.css', 'css/bootstrap.min.css', 'css/bootstrap-theme.min.css', 'css/font-awesome.min.css'],
        dest: 'css/dist.css',
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
      all: ['js/<%= pkg.name %>.js']
    },
    uncss: {
      dist: {
        files: {
          'css/uncss.css': ['templates/index.tpl', 'templates/item.tpl', 'templates/login.tpl', 'templates/pagination.tpl']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-jasmine');
  grunt.loadNpmTasks('grunt-phpunit');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-uncss');

  grunt.registerTask('default', ['minify', 'test']);
  grunt.registerTask('compile', ['compass']);
  grunt.registerTask('minify', ['uglify', 'cssmin']);
  grunt.registerTask('test', ['jasmine', 'phpunit', 'jshint']);
  grunt.registerTask('removecss', ['uncss']);
};
