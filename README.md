# Chronicle

By Jack McDade (inspired by Travis Schmeisser)

Chronicle is a simple, chronilogically organized, file-based publishing engine. It takes a content directory (which can contain literally anything you want, as long as you have an index.php file), adds a little yaml magic for meta data, and powers all the navigation between entries.

## Getting Started

* Drop Chronicle on your server (local or otherwise)
* Customize the main `config.yaml` file to set your global site information
* rename the `htaccess` file to `.htaccess` (support for no mod_rewrite access is on the roadmap)
* Start publishing!

## Diving In

* Chronicle looks for date-based directories inside the `/content` directory and will automatically redirect the user to the newest "entry" upon visiting the root url ("/").
* Your entries have `$prev` and `$next` path variables available to use in your index.php file. For example, add previous and next entry navigation. Look in the `/content` directory for examples
* If you add a `meta.yaml` file to any given content subdirectory, any of the [YAML](http://en.wikipedia.org/wiki/YAML) key:value pairs will be availble to use in both the index.php view and archive listing page.
* Your archive page will pull all the meta data from all of your content directories to help you build a list. Look at `content/archive/index.php` for some examples.

### More complete documentation coming soon!