
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
  </head>
  <style>
    .mainbox{
      position: absolute;
      width: 60%;
      height: 60%;
      top: 50%;
      left: 50%;
      transform: translate(-50%,-50%);
    }
  </style>
  <body>
  <div class="mainbox">  
    <br>
      <div class="field">
        <p class="control has-icons-left has-icons-right">
          <input class="input" type="email" placeholder="Email">
          <span class="icon is-left">
            <i class="fas fa-envelope"></i>
          </span>
          <span class="icon is-right">
            <i class="fas fa-check"></i>
          </span>
        </p>
      </div>
    <div class="field">
      <p class="control has-icons-left">
        <input class="input" type="password" placeholder="Password">
        <span class="icon is-small is-left">
          <i class="fas fa-lock"></i>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control">
        <button class="button is-success">
          Login
        </button>
      </p>
    </div>
  </div>
  </body>
</html>