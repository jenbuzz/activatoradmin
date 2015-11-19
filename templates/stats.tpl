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

        <div class="github">
          <a href="https://github.com/dan-lyn/activatoradmin" target="_blank"><span class="fa fa-github"></span></a>
        </div>
      </nav>

      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      Statistics...

      <style>
      .bar {
        fill: steelblue;
      }

      .bar:hover {
        fill: brown;
      }

      .axis {
        font: 10px sans-serif;
      }

      .axis path,
      .axis line {
        fill: none;
        stroke: #000;
        shape-rendering: crispEdges;
      }

      .x.axis path {
        display: none;
      }
      </style>
      <div class="graph"></div>

    </div>

    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/d3/d3.min.js"></script>
    <script src="js/stats.js"></script>

  </body>

</html>
