<!DOCTYPE html>
<html lang="en">

  <?php require_once 'header.tpl'; ?>

  <body>
    <div id="container" class="container">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="home"><a href="<?php echo $baseurl; ?>"><button><span class="fa fa-home"></span></button></a></div>

        <div class="stats"><a href="<?php echo $baseurl; ?>stats"><button><span class="fa fa-bar-chart"></span></button></a></div>

        <div class="logout"><form action="<?php echo $baseurl; ?>logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>

        <div class="divider"></div>

        <div class="search">
          <input id="searchterm" type="text" />
          <button id="search"><span class="fa fa-search"></span>search</button>
          <button id="clearsearch"><span class="fa fa-eraser"></span>clear</button>
        </div>

        <div class="github">
          <a href="https://github.com/dan-lyn/activatoradmin" target="_blank"><span class="fa fa-github"></span></a>
        </div>
      </nav>

      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      <ul id="itemlist" class="list-unstyled"></ul>

      <div id="pagination-container"></div>
    </div>

    <script src="config/config.min.js"></script>
    <script data-main="js/dist/activatoradmin" src="js/lib/require.js"></script>
  </body>

</html>
