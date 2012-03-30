<h1><?= $title ?></h1>
<h6>May 27th.</h6>
<ul>
  <?php if ($prev): ?><li><a href="<?php echo $prev ?>">Previous</a></li><?php endif ?>
  <?php if ($next): ?><li><a href="<?php echo $next ?>">Next</a></li><?php endif ?>
</ul>