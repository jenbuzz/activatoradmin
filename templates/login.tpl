<!DOCTYPE html>
<html lang="en">

  <?php require_once 'header.tpl'; ?>

  <body>
    <div id="container" class="container">
      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      <div class="container">
        <div class="row">
          <div class="col-md-4 well login">
            <legend>Login</legend>
            <form method="POST" action="<?php echo $baseurl; ?>login" accept-charset="UTF-8">
              <input type="text" id="username" class="form-control" name="username" placeholder="Username" />
              <input type="password" id="password" class="form-control" name="password" placeholder="Password" />
              <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" style="margin-top: 15px;">Sign in</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </body>

</html>
