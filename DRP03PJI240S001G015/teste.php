<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<script>
  /* Set the width of the sidebar to 250px (show it) */
  function openNav() {
  document.getElementById("mySidepanel").style.width = "250px";
  }

  /* Set the width of the sidebar to 0 (hide it) */
  function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
  }
</script>
<style>
  /* The sidepanel menu */
  .sidepanel {
  height: 250px; /* Specify a height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1; /* Stay on top */
  top: 0;
  left: 0;
  background-color: #111; /* Black*/
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidepanel */
  }

  /* The sidepanel links */
  .sidepanel a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
  transition: 0.3s;
  }

  /* When you mouse over the navigation links, change their color */
  .sidepanel a:hover {
  color: #f1f1f1;
  }

  /* Position and style the close button (top right corner) */
  .sidepanel .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
  }

  /* Style the button that is used to open the sidepanel */
  .openbtn {
  font-size: 20px;
  cursor: pointer;
  background-color: #111;
  color: white;
  padding: 10px 15px;
  border: none;
  }

  .openbtn:hover {
  background-color: #444;
  }
</style>
<body>
  <div id="mySidepanel" class="sidepanel">
    <a href="#" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a>
  </div>

  <button class="openbtn" onclick="openNav()">&#9776; Toggle Sidepanel</button>
  <h2>Collapsed Sidepanel</h2>
  <p>Content...</p>
</body>
</html>
