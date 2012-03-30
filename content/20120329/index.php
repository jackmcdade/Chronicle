<h1><?= $title ?></h1>
<h6>May 29th.</h6>
<ul>
  <? if ($prev): ?><li><a href="<?= $prev ?>">Previous</a></li><? endif ?>
  <? if ($next): ?><li><a href="<?= $next ?>">Next</a></li><? endif ?>
</ul>