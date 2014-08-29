// Setup baseUrl (if ActivatorAdmin is in root the baseUrl should be /)
var baseUrl = '';
if( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('baseUrl') ) {
  baseUrl = appConfig.baseUrl;
}

// Setup pageSize; default=5
var pageSize = 5;
if ( typeof appConfig != 'undefined' && appConfig.hasOwnProperty('pageSize') ) {
  pageSize = appConfig.pageSize;
}
