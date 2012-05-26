<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <STYLE type="text/css">
      td { padding: 5px; }
      .ok {color: green;}
      .pending, .error {color: red;}
      span {display: block;}
    </STYLE>
  </head>
  <body>
    <div id="migrations">
      <?php if (isset($view)) { ?> 
        <?php echo $view ?>
      <?php } ?>
    </div>
  </body>
</html>