<!DOCTYPE html>
<html lang="en">

  <?php require_once 'header.tpl'; ?>

  <body>
    <div id="container" class="container">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="logout"><form action="<?php echo $baseurl; ?>logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>
      </nav>

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
