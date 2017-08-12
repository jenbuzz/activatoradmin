<!DOCTYPE html>
<html lang="en">

  {% include 'meta.tpl' %}

  <body>
    <div id="container" class="container">
      {% include 'header.tpl' %}

      <div class="container">
        <div class="row">
          <div class="col-md-4 well login">
            <legend>Login</legend>
            {% if isError %}
                <p class="text-danger">Wrong username or password!</p>
            {% endif %}
            <form method="POST" action="{{ baseurl }}login" accept-charset="UTF-8">
              <div class="form-group{% if isError %} has-error{% endif %}">
                <input type="text" id="username" class="form-control" name="username" placeholder="Username" />
              </div>
              <div class="form-group{% if isError %} has-error{% endif %}">
                <input type="password" id="password" class="form-control" name="password" placeholder="Password" />
              </div>
              <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
            </form>
          </div>
        </div>
      </div>

    </div>

    <script>document.forms[0].elements[0].focus();</script>
  </body>

</html>
