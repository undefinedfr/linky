# WP Linky

Version : **1.3.3**

Author : **Nicolas RIVIERE**

### Description :

Linky is a free module offering to create a landing page containing all the links you want.

It works like Linktree, Later or others but directly in your website. Much better for your SEO ;)

With Linky, you can:

* Choose a theme for your page
* Customize your page with title, avatar, background color, gradients, link color...ect
* Add social links in your page
* Choose menu for your page
* Choose border, text and background color for your links
* Add label in your links
* Add category in your links
* Add separator between links
* Add analytics code for your page
* Choose avatar for your header page
* Choose title for your header page
* Choose text and background color for your header page
* Choose text and background color for your body page
* Show page render in admin panel


### Installation :

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Plugin Name screen to configure the plugin
4. Configure plugin in Linky menu


### Types :
You can override link type
 
### How to add type : 
_wp-content/themes/{THEME_NAME}/linky/views/fields/custom.php_ - For field
_wp-content/themes/{THEME_NAME}/linky/views/render/custom.php_ - For render view
_wp-content/themes/{THEME_NAME}/linky/assets/icons/dialogfeed.svg_ - For icon


### Actions

**`linky_after_construct`**
- object $this Linky object

###### Definition:
Do something after class initialisation


###### Exemple:

```
function on_linky_after_construct() {
    // Do something
}
add_action( 'linky_after_construct', 'on_linky_after_construct', 10, 1 );
```

###### --

**`linky_install`**

###### Definition:
Do something after plugin install


###### Exemple:

```
function on_linky_install() {
    // Do something
}
add_action( 'linky_install', 'on_linky_install', 10, 1 );
```

###### --

**`linky_uninstall`**

###### Definition:
Do something after plugin uninstall


###### Exemple:

```
function on_linky_uninstall() {
    // Do something
}
add_action( 'linky_uninstall', 'on_linky_uninstall', 10, 1 );
```

###### --

**`linky_before_admin_enqueue`**

###### Definition:
Do something before admin script enqueue


###### Exemple:

```
function on_linky_before_admin_enqueue() {
    // Do something
}
add_action( 'linky_before_admin_enqueue', 'on_linky_before_admin_enqueue', 10, 1 );
```

###### --

**`linky_after_admin_enqueue`**

###### Definition:
Do something after admin script enqueue


###### Exemple:

```
function on_linky_after_admin_enqueue() {
    // Do something
}
add_action( 'linky_after_admin_enqueue', 'on_linky_after_admin_enqueue', 10, 1 );
```

###### --

**`linky_before_enqueue`**

###### Definition:
Do something before front script enqueue


###### Exemple:

```
function on_linky_before_enqueue() {
    // Do something
}
add_action( 'linky_before_enqueue', 'on_linky_before_enqueue', 10, 1 );
```

###### --

**`linky_after_enqueue`**

###### Definition:
Do something after front script enqueue


###### Exemple:

```
function on_linky_after_enqueue() {
    // Do something
}
add_action( 'linky_after_enqueue', 'on_linky_after_enqueue', 10, 1 );
```

###### ___

### Filters

**`linky_menu_page_capalibilty`**
- string $capabilty default capability (`manage_options`)

###### Definition:
Override admin page capability

###### Exemple:
```
function on_linky_menu_page_capalibilty( $capabilty ) {
    return $capabilty;
}
add_filter( 'linky_menu_page_capalibilty', 'on_linky_menu_page_capalibilty', 10, 1 );
```

###### --

**`linky_submenu_appareance_page_capalibilty`**
- string $capabilty default capability (`manage_options`)

###### Definition:
Override admin submenu Appareance page capability


###### Exemple:
```
function on_linky_submenu_appareance_page_capalibilty( $capabilty ) {
    return $capabilty;
}
add_filter( 'linky_submenu_appareance_page_capalibilty', 'on_linky_submenu_appareance_page_capalibilty', 10, 1 );
```

###### --

**`linky_submenu_social_page_capalibilty`**
- string $capabilty default capability (`manage_options`)

###### Definition:
Override admin submenu Social page capability


###### Exemple:
```
function on_linky_submenu_social_page_capalibilty( $capabilty ) {
    return $capabilty;
}
add_filter( 'linky_submenu_social_page_capalibilty', 'on_linky_submenu_social_page_capalibilty', 10, 1 );
```

###### --

**`linky_submenu_links_page_capalibilty`**
- string $capabilty default capability (`manage_options`)

###### Definition:
Override admin submenu Links page capability


###### Exemple:
```
function on_linky_submenu_links_page_capalibilty( $capabilty ) {
    return $capabilty;
}
add_filter( 'linky_submenu_links_page_capalibilty', 'on_linky_submenu_links_page_capalibilty', 10, 1 );
```

###### --

**`linky_submenu_themes_page_capalibilty`**
- string $capabilty default capability (`manage_options`)

###### Definition:
Override admin submenu Themes page capability


###### Exemple:
```
function on_linky_submenu_themes_page_capalibilty( $capabilty ) {
    return $capabilty;
}
add_filter( 'linky_submenu_themes_page_capalibilty', 'on_linky_submenu_themes_page_capalibilty', 10, 1 );
```

###### --

**`linky_menu_icon`**
- string $menu_icon_path path to SVG icon

###### Definition:
Override front menu icon path (SVG)


###### Exemple:
```
function on_linky_menu_icon( $menu_icon_path ) {
    return get_template_directory_uri() . '/assets/images/menu.svg';
}
add_filter( 'linky_menu_icon', 'on_linky_menu_icon', 10, 1 );
```

###### --

**`linky_header_title`**
- string $menu_icon_path path to SVG icon

###### Definition:
Override text title for specific theme ("My Links")

###### Exemple:
```
function on_linky_header_title( $title ) {
    return __('Welcome');
}
add_filter( 'linky_header_title', 'on_linky_header_title', 10, 1 );
```

###### --

**`linky_avatar_image_size`**
- string $icon_image_size default image size

###### Definition:
Override avatar image size

###### Exemple:
```
function on_linky_avatar_image_size( $icon_image_size ) {
    return 'large';
}
add_filter( 'linky_avatar_image_size', 'on_linky_avatar_image_size', 10, 1 );
```


###### ___
