'use strict';

var fs = require('fs');
var ini = require('ini');
var inquirer = require('inquirer');
var mysql = require('mysql');

var config = ini.parse(fs.readFileSync(__dirname + '/../config/config.ini', 'utf-8'));

var connection = mysql.createConnection({
  host: config.mysql.host,
  user: config.mysql.user,
  password: config.mysql.password,
  database: config.mysql.name
});
connection.connect();

var table = config.mysql.table;

inquirer.prompt([{
  type: 'input',
  name: 'id',
  message: 'What is the ID of the item you want to (de)activate?',
  validate: function (value) {
    if (!(value % 1 === 0)) {
      return 'ID must be a number';
    }

    return true;
  }
}]).then(function (answers) {
  var id = answers.id;

  connection.query('SELECT * FROM ' + table + ' WHERE id=' + connection.escape(id), function (err, rows, fields) {
    if (err) {
      throw err;
    }

    if (!rows.length) {
      throw new Error('Item with ID "' + id + '" does not exist');
    }

    var item = rows[0];

    var isactive = item[config.db_mapping.isactive] ? 0 : 1;

    connection.query('UPDATE ' + table + ' SET ' + config.db_mapping.isactive + '=' + isactive + ' WHERE id=' + connection.escape(id), function (err, result) {
      if (err) {
        throw err;
      }

      if (result.changedRows > 0) {
        var msgIsActive = isactive ? 'activated' : 'deactivated';

      	console.log('Item "' + item[config.db_mapping.name] + '" (ID: ' + item.id + ') has been ' + msgIsActive);
      }

      connection.end();
    });
  });
});