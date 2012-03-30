<h1><?= $title ?></h1>
<p>Check out my entries:</p>

<ul>
<?php foreach ($entries as $entry): ?>
  <li><a href="<?= $entry['url'] ?>"><?= $entry['title'] ?></a></li>
<?php endforeach ?>
</ul>