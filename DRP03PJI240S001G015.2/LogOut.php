<?php

  session_start();
  ob_start();
  unset($_SESSION['nome_func'], $_SESSION['cargo'], $_SESSION['departamento'],);

  header("Location: index.php");