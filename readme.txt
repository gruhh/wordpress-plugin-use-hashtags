=== Use Hashtags – convert #hashtags to search links ===
Contributors: gruhh
Tags: hashtags, user experience, ux, navigation
Requires at least: 5.0
Tested up to: 5.5
Stable tag: 1.0.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Use #hashtags as part of your content, and improve your UX.

== Description ==

With the **Use Hashtags** plugin, you can easily *use hashtags* in your content (and your excerpt). Just type # plus a word, and the plugin will automatically convert it to a link.

The link send the user to the website search page, showing additional content that also uses that hashtag.

This can enhance the user experience, as it creates a new navigation layer inside your content.

* There is no need to maintain the hashtags, just add them to your text, and it's done.
* This plugin is non-destructive, so it does not make any changes to how your content is saved. Only when the content is presented, the link will appear for the visitors.
* This plugin does not generate external links.

**Tested with popular themes:**

* [Twenty Twenty theme](https://wordpress.org/themes/twentytwenty/).
* [GeneratePress theme](https://wordpress.org/themes/generatepress/).
* [Neve theme](https://wordpress.org/themes/neve/).
* [Hello Elementor theme](https://wordpress.org/themes/hello-elementor/).

== Installation ==

1. Install the plugin (uploading the zip or installing from the Plugins > Add New);
2. Activate the plugin and that's it, it's already running;
3. If you want to customize something, look for "Use Hashtags" in the Tools menu;
4. Follow the instructions and click the button to save.

== Frequently Asked Questions ==

= Do I need to add each hashtag as a tag? =

No. The idea here is that a #hashtag added as part of the text will be replaced with a link like `<a href="/?s=#hashtag">#hashtag</a>`.

= I am not seeing the links in the editor. What is wrong? =

This is the correct behavior. Links appear only at the time of rendering the content or excerpt.

= What is a non-destructive plugin? =

We do not change the way your content is saved, only how it is rendered for visitors. If you uninstall the plugin, the #hashtags will remain a simple text.

= Which characters are considered on a hashtag? =

For now, `A-Z`, `a-z`, `0-9` and `_`.

= Can I style the links? =

Yes, every hashtag link has a CSS class `hashtag-link`. You can add the class in your theme's css.

Example: `a.hashtag-link { text weight: bold; }`

== Screenshots ==

1. Example of how a hashtag appears in the content. For this example we are using the [Twenty Twenty theme](https://wordpress.org/themes/twentytwenty/).
2. Example of how a hashtag appears in the content. For this example we are using the [GeneratePress theme](https://wordpress.org/themes/generatepress/).
3. Example of how a hashtag appears in the content. For this example we are using the [Neve theme](https://wordpress.org/themes/neve/).
4. Example of how a hashtag appears in the content. For this example we are using the [Hello Elementor theme](https://wordpress.org/themes/hello-elementor/).
5. Simple settings.

== Changelog ==

= 1.0.3 (2020-08-21) =
* Fixing a bug when a link has an anchor.

= 1.0.2 (2020-08-21) =
* Fixing the search url to get a better behaviour.

= 1.0.1 (2020-08-21) =
* Fixing the url when the wordpress is installed in a path.

= 1.0 (2020-08-21) =
* The first release of the plugin, with the main features.
