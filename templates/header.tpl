{% if isLogin==false %}
<nav class="navbar navbar-default fixed-top bg-light border border-top-0 container" role="navigation">
  <label for="show-menu" class="show-menu fa fa-bars"></label>
  <input type="checkbox" id="show-menu" role="button">

  <div class="pull-left">
    <div class="home navbutton"><a href="{{ baseurl }}"><button><span class="fa fa-home"></span></button></a></div>

    <div class="stats navbutton"><a href="{{ baseurl }}stats"><button><span class="fa fa-bar-chart"></span></button></a></div>

    <div class="logout navbutton"><form action="{{ baseurl }}logout" method="get"><button><span class="fa fa-sign-out"></span>sign out</button></form></div>

    {% if isStats==false %}
    <div class="divider navbutton"></div>

    <div class="search navbutton">
      <input id="searchterm" type="text" placeholder="enter search term ..." />
      <button id="search"><span class="fa fa-search"></span>search</button>
      <button id="clearsearch"><span class="fa fa-eraser"></span>clear</button>
    </div>
    {% endif %}
  </div>

  <div class="github navbutton">
    <a href="https://github.com/jenbuzz/activatoradmin" target="_blank" title="ActivatorAdmin on GitHub"><span class="fa fa-github"></span></a>
  </div>
</nav>
{% endif %}

<header class="jumbotron">
  <h1>ActivatorAdmin</h1>
</header>
