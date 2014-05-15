<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>ActivatorAdmin</title>

    <meta name="robots" content="noindex,nofollow">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="../css/activatoradmin.css" rel="stylesheet">
  </head>

  <body>
    <div id="container" class="container">
      <header class="jumbotron">
        <h1>ActivatorAdmin</h1>
      </header>

      <div class="container login">
        <div class="row">
          <div class="col-md-4 well" style="float: none; margin: 0 auto;">
            <legend>Login</legend>
            <form method="POST" action="/activatoradmin/index.php/login" accept-charset="UTF-8">
              <input type="text" id="username" class="form-control" name="username" placeholder="Username" style="float: none;" />
              <input type="password" id="password" class="form-control" name="password" placeholder="Password" style="float: none;" />
              <button type="submit" name="submit" class="btn btn-primary btn-block" style="margin-top: 15px;">Sign in</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </body>

</html>
