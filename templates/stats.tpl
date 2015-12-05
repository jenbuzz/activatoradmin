<!DOCTYPE html>
<html lang="en">

  <?php require_once 'meta.tpl'; ?>

  <body>
    <div id="container" class="container">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <label for="show-menu" class="show-menu fa fa-bars"></label>
        <input type="checkbox" id="show-menu" role="button">

        <div class="home navbutton"><a href="<?php echo $baseurl; ?>"><button><span class="fa fa-home"></span></button></a></div>

        <div class="stats navbutton"><a href="<?php echo $baseurl; ?>stats"><button><span class="fa fa-bar-chart"></span></button></a></div>

        <div class="logout navbutton"><form action="<?php echo $baseurl; ?>logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>

        <div class="github navbutton">
          <a href="https://github.com/dan-lyn/activatoradmin" target="_blank"><span class="fa fa-github"></span></a>
        </div>
      </nav>

      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      <div class="statsActivated"></div>
    </div>

    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/d3/d3.min.js"></script>
    <script src="js/stats.js"></script>
  </body>

</html>
