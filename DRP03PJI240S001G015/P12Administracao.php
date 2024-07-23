<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  /* Style the sidebar - fixed full height */
  .sidebar {
    height: 100%;
    width: 160px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    padding-top: 16px;
  }

  /* Style sidebar links */
  .sidebar a {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 20px;
    color: #818181;
    display: block;
  }

  /* Style links on mouse-over */
  .sidebar a:hover {
    color: #f1f1f1;
  }

  /* Style the main content */
  .main {
    margin-left: 160px; /* Same as the width of the sidenav */
    padding: 0px 10px;
  }

  /* Add media queries for small screens (when the height of the screen is less than 450px, add a smaller padding and font-size) */
  @media screen and (max-height: 450px) {
    .sidebar {padding-top: 15px;}
    .sidebar a {font-size: 18px;}
  }
</style>
<body>
  <!-- Load an icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- The sidebar -->
  <div class="sidebar">
    <a href="#home"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href="#services"><i class="fa fa-fw fa-wrench"></i> Services</a>
    <a href="#clients"><i class="fa fa-fw fa-user"></i> Clients</a>
    <a href="#contact"><i class="fa fa-fw fa-envelope"></i> Contact</a>
  </div>
</body>
</html>