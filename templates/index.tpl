<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>ActivatorAdmin</title>

    <meta name="robots" content="noindex,nofollow">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/activatoradmin.min.css" rel="stylesheet">
  </head>

  <body>
    <div id="container" class="container">
      <div class="logout"><form action="/activatoradmin/logout" method="get"><button>sign out</button></form></div>

      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      <ul id="itemlist" class="list-unstyled"></ul>

      <div id="pagination-container"></div>
    </div>

    <script src="js/lib/require.js"></script>
    <script src="config/config.js"></script>
    <script src="config/requirejs.config.js"></script>
    <script src="js/activatoradmin.min.js"></script>
  </body>

</html>
