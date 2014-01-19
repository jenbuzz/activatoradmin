<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>ActivatorAdmin</title>

    <meta name="robots" content="noindex,nofollow" />

    <script id="item" type="text/template">

        <label>
          <input id="toggle-activate" type="checkbox" <% if(active==1) { %>checked="checked" <% } %>/>
          <%=name%>
        </label>
        <img class="img-thumbnail" src="<% if(image) { %><%=imagePath%><%=image%><% } else { %>images/default.jpg<% } %>" height="90px" />

    </script>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/activatoradmin.css" rel="stylesheet">
  </head>

  <body>
    <div id="container" class="container">
      <div class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </div>

      <ul id="itemlist" class="list-unstyled"></ul>
    </div>

    <div id="background"></div>

    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/underscore-min.js"></script>
    <script src="js/lib/backbone-min.js"></script>
    <script src="config/config.js"></script>
    <script src="js/activatoradmin.js"></script>
  </body>

</html>
