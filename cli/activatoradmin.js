'use strict';

const fs = require('fs');
const path = require('path');
const ini = require('ini');
const inquirer = require('inquirer');
const mysql = require('mysql');

const config = ini.parse(fs.readFileSync(path.join(__dirname, '/../config/config.ini'), 'utf-8'));

const connection = mysql.createConnection({
    host: config.mysql.host,
    user: config.mysql.user,
    password: config.mysql.password,
    database: config.mysql.name
});
connection.connect();

const {table} = config.mysql;

inquirer.prompt([{
    type: 'input',
    name: 'id',
    message: 'What is the ID of the item you want to (de)activate?',
    validate: value => {
        if (value % 1 !== 0) {
            return 'ID must be a number';
        }

        return true;
    }
}]).then(answers => {
    const {id} = answers;

    if (id === 0) {
        console.log('ID is zero');
        connection.end();
        return;
    }

    connection.query('SELECT * FROM ' + table + ' WHERE id=' + connection.escape(id), (err, rows) => {
        if (err) {
            throw err;
        }

        if (rows.length === 0) {
            throw new Error('Item with ID "' + id + '" does not exist');
        }

        const item = rows[0];

        const isactive = item[config.db_mapping.isactive] ? 0 : 1;

        connection.query('UPDATE ' + table + ' SET ' + config.db_mapping.isactive + '=' + isactive + ' WHERE id=' + connection.escape(id), (err, result) => {
            if (err) {
                throw err;
            }

            if (result.changedRows > 0) {
                const msgIsActive = isactive ? 'activated' : 'deactivated';

                console.log('Item "' + item[config.db_mapping.name] + '" (ID: ' + item.id + ') has been ' + msgIsActive);
            }

            connection.end();
        });
    });
});
