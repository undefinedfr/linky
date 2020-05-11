# WP Linky

Version : **0.0.1**

Author : **Nicolas RIVIERE**

### Description :


### Usage :


### Types :

 
### How to add type : 
 

_wp-content/themes/{THEME_NAME}/wp-linky/views/fields/custom.php_ - For field
_wp-content/themes/{THEME_NAME}/wp-linky/views/render/custom.php_ - For render view
_wp-content/themes/{THEME_NAME}/wp-linky/assets/icons/dialogfeed.svg_ - For icon


### Actions

**`wp_linky_actionName`**
- param 

###### Definition:



###### Exemple:

```
function on_wp_linky_actionName(  ) {
    // Do something
}
add_action( 'wp_linky_actionName', 'wp_linky_actionName', 10, 1 );
```

###### ___

### Filters

**`on_wp_linky_filterName`**
- param 

###### Definition:


###### Exemple:

```
function on_wp_linky_filterName( ) {
    return 
}
add_filter( 'on_wp_linky_filterName', 'on_wp_linky_filterName', 10, 1 );
```

###### ___