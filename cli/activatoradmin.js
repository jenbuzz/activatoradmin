'use strict';

var inquirer = require('inquirer');
var mysql = require('mysql');

var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'activatoradmin'
});
connection.connect();

inquirer.prompt([{
  type: 'input',
  name: 'id',
  message: 'What is the ID of the item you want to (de)activate?'
}]).then(function (answers) {
  var id = answers.id;

  if (!(id % 1 === 0)) {
    throw new Error('ID must be an integer');
  }

  connection.query('SELECT * FROM items WHERE id=' + id, function (err, rows, fields) {
    if (err) {
      throw err;
    }

    var item = rows[0];
    if (!item) {
      throw new Error('Item does not exist');
    }

    var isactive = item.isactive ? 0 : 1;

    connection.query('UPDATE items SET isactive=' + isactive + ' WHERE id=' + id, function (err, result) {
      if (err) {
        throw err;
      }

      if (result.changedRows > 0) {
        var msgIsActive = isactive ? 'activated' : 'deactivated';

      	console.log('Item "' + item.name + '" (ID: ' + item.id + ') has been ' + msgIsActive);
      }

      connection.end();
    });
  });
});