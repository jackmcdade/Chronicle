<!doctype html>
<head>
  <link rel="stylesheet" href="<?php echo asset_path('assets/style.css'); ?>">
</head>

<body>
  <h1><?= $title ?></h1>
  <h6>May 30th.</h6>
  <ul>
    <?php if ($prev): ?><li><a href="<?php echo $prev ?>">Previous</a></li><?php endif ?>
    <?php if ($next): ?><li><a href="<?php echo $next ?>">Next</a></li><?php endif ?>
  </ul>
</body>