module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
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
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');


  grunt.registerTask('default', ['uglify', 'cssmin']);

};
