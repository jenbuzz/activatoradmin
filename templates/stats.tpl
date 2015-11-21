<!DOCTYPE html>
<html lang="en">

  <?php require_once 'header.tpl'; ?>

  <body>
    <div id="container" class="container">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="logout"><form action="<?php echo $baseurl; ?>logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>

        <div class="github">
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
