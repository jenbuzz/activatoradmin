<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>ActivatorAdmin</title>

    <meta name="robots" content="noindex,nofollow" />

    <script id="item" type="text/template">

        <label>
          <input id="toggle-activate" type="checkbox" <% if(isactive==1) { %>checked="checked" <% } %>/>
          <%=name%>
        </label>
        <img class="img-thumbnail" src="<% if(image) { %><%=image%><% } else { %>images/default.jpg<% } %>" />

    </script>

    <script id="pagination" type="text/template">

        <ul class="pagination">
          <li<% if (currentPage == 1) { %> class="disabled"<% } %>><a href="#" class="first">First</a></li>
          <li<% if (currentPage == 1) { %> class="disabled"<% } %>><a href="#" class="prev">Previous</a></li>
          <% _.each (pageSet, function (p) { %>
            <% if (currentPage == p) { %>
              <li class="active"><a href="#"><%= p %></a></li>
            <% } else { %>
              <li><a href="#" class="page"><%= p %></a></li>
            <% } %>
          <% }); %>
          <li<% if (lastPage == currentPage || lastPage == 0) { %> class="disabled"<% } %>><a href="#" class="next">Next</a></li>
          <li<% if (lastPage == currentPage || lastPage == 0) { %> class="disabled"<% } %>><a href="#" class="last">Last</a></li>
        </ul>

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

      <div id="pagination-container"></div>
    </div>

    <div id="background"></div>

    <script src="js/lib/jquery.min.js"></script>
    <script src="js/lib/underscore-min.js"></script>
    <script src="js/lib/backbone-min.js"></script>
    <script src="js/lib/backbone.paginator.min.js"></script>
    <script src="config/config.js"></script>
    <script src="js/activatoradmin.js"></script>
  </body>

</html>
