<!DOCTYPE html>
<html lang="en">

  {% include 'meta.tpl' %}

  <body>
    <div id="container" class="container">
      welcome to vuejs

      <ul id="itemlist">
        <li v-for="item in items">
          <span v-text="item.name"></span>
        </li>
      </ul>
    </div>

    <script src="node_modules/vue/dist/vue.js"></script>
    <script src="node_modules/vue-resource/dist/vue-resource.js"></script>
    <script src="js/vue-app.js"></script>
  </body>

</html>
