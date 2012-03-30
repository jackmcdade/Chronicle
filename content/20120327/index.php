<h1><?= $title ?></h1>
<h6>May 27th.</h6>
<ul>
  <?php if ($prev): ?><li><a href="<?= $prev ?>">Previous</a></li><? endif ?>
  <?php if ($next): ?><li><a href="<?= $next ?>">Next</a></li><? endif ?>
</ul>