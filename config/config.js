var appConfig = {
  // Host...
  host: 'localhost',

  // Path to this application (should be '/' if in root)
  baseUrl: '/activatoradmin/',

  // Path to images (excluding default.jpg)
  imagePath: 'images/',

  // Map default db column structure to other naming conventions
  db_mapping: {
    name: 'name',
    isactive: 'isactive',
    image: 'image'
  },

  // Number of items on each page
  pageSize: 10,

  // Show info button for each item
  show_info: true,

  // Show delete button for deleting a single item
  show_delete: true
};
