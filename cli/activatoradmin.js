var inquirer = require('inquirer');

inquirer.prompt([{
  type: 'input',
  name: 'id',
  message: 'What is the ID of the item you want to (de)activate?'
}]).then(function (answers) {
  console.log(answers);
});
