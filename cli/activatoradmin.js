'use strict';

const fs = require('fs');
const path = require('path');
const ini = require('ini');
const inquirer = require('inquirer');
const mysql = require('mysql');

const config = ini.parse(fs.readFileSync(path.join(__dirname, '/../config/config.ini'), 'utf-8'));

const {table, host, user, password, name} = config.mysql;

const connection = mysql.createConnection({
    host,
    user,
    password,
    database: name
});
connection.connect();

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

    let item = null;

    query('SELECT * FROM ' + table + ' WHERE id=' + connection.escape(id))
        .then(
            rows => {
                if (rows.length === 0) {
                    throw new Error('Item with ID "' + id + '" does not exist');
                }

                item = rows[0];

                const isactive = item[config.db_mapping.isactive] ? 0 : 1;

                return query('UPDATE ' + table + ' SET ' + config.db_mapping.isactive + '=' + isactive + ' WHERE id=' + connection.escape(id));
            }
        )
        .then(
            result => {
                if (result.changedRows > 0) {
                    console.log('Item "' + item[config.db_mapping.name] + '" (ID: ' + item.id + ') has been updated!');
                }

                connection.end();
            }
        )
        .catch(err => {
            console.log(err.message);
            connection.end();
        });
});

function query (sql, args) {
    return new Promise((resolve, reject) => {
        connection.query(sql, args, (err, rows) => {
            if (err) {
                return reject(err);
            }

            resolve(rows);
        });
    });
}

