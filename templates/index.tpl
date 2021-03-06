<!DOCTYPE html>
<html lang="en">

  {% include 'meta.tpl' %}

  <body>
    <div id="container" class="container">
      {% include 'header.tpl' %}

      <ul id="itemlist" class="list-unstyled"></ul>

      <div id="pagination-container"></div>
    </div>

    <script src="config/config.min.js"></script>
    <script src="node_modules/popper.js/dist/popper.min.js"></script>
    <script data-main="js/dist/activatoradmin" src="node_modules/requirejs/require.js"></script>
  </body>

</html>
