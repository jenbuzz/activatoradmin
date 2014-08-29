<!DOCTYPE html>
<html lang="en">

  <?php require_once 'header.tpl'; ?>

  <body>
    <div id="container" class="container">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="logout"><form action="<?php echo $baseurl; ?>logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>

        <div class="divider"></div>

        <div class="search">
          <input id="searchterm" type="text" />
          <button id="search"><span class="fa fa-search"></span>search</button>
          <button id="clearsearch"><span class="fa fa-eraser"></span>clear</button>
        </div>
      </nav>

      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      <ul id="itemlist" class="list-unstyled"></ul>

      <div id="pagination-container"></div>
    </div>

    <script src="config/config.js"></script>
    <script data-main="js/app/main" src="js/lib/require.js"></script>
  </body>

</html>
