'use strict';

var expect = require('chai').expect;

describe('activatoradmin', function() {
  this.timeout(15000);

  it('should run activatoradmin.js command-line script', function(done) {
    var spawn = require( 'child_process' ).spawn;
    var child = spawn('node', [__dirname + '/../../cli/activatoradmin.js']);

    child.stdin.setEncoding('utf-8');
    child.stdin.write("0\n");
    child.stdin.end();

    // For debugging output:
    // child.stdout.pipe(process.stdout);

    child.stdout.on('data', function (result) {
      if (result.toString().indexOf('ID is zero') === 0) {
        done();
      }
    });
  });
});