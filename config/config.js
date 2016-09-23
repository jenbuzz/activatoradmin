var appConfig = {
  // Host...
  host: 'localhost',

  // Path to this application (should be '/' if in root)
  baseUrl: '/',

  // Path to images (excluding default.jpg)
  imagePath: 'images/',

  // Map default db column structure to other naming conventions
  dbMapping: {
    name: 'name',
    isactive: 'isactive',
    image: 'image'
  },

  // Number of items on each page
  pageSize: 10,

  // Show info button for each item
  showInfo: true,

  // Show delete button for deleting a single item
  showDelete: true
};
