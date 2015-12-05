<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <label for="show-menu" class="show-menu fa fa-bars"></label>
  <input type="checkbox" id="show-menu" role="button">

  <div class="home navbutton"><a href="<?php echo $baseurl; ?>"><button><span class="fa fa-home"></span></button></a></div>

  <div class="stats navbutton"><a href="<?php echo $baseurl; ?>stats"><button><span class="fa fa-bar-chart"></span></button></a></div>

  <div class="logout navbutton"><form action="<?php echo $baseurl; ?>logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>

  <?php if (!isset($isStats) || !$isStats) { ?>
  <div class="divider navbutton"></div>

  <div class="search navbutton">
    <input id="searchterm" type="text" />
    <button id="search"><span class="fa fa-search"></span>search</button>
    <button id="clearsearch"><span class="fa fa-eraser"></span>clear</button>
  </div>
  <?php } ?>

  <div class="github navbutton">
    <a href="https://github.com/dan-lyn/activatoradmin" target="_blank"><span class="fa fa-github"></span></a>
  </div>
</nav>

<header class="jumbotron">
  <h1>ActivatorAdmin</h1>
</header>
