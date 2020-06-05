# WP Linky

Version : **0.0.1**

Author : **Nicolas RIVIERE**

### Description :


### Usage :


### Types :

 
### How to add type : 
 

_wp-content/themes/{THEME_NAME}/linky/views/fields/custom.php_ - For field
_wp-content/themes/{THEME_NAME}/linky/views/render/custom.php_ - For render view
_wp-content/themes/{THEME_NAME}/linky/assets/icons/dialogfeed.svg_ - For icon


### Actions

**`linky_actionName`**
- param 

###### Definition:



###### Exemple:

```
function on_linky_actionName(  ) {
    // Do something
}
add_action( 'linky_actionName', 'on_linky_actionName', 10, 1 );
```

###### ___

### Filters

**`on_linky_filterName`**
- param 

###### Definition:


###### Exemple:

```
function on_linky_filterName( ) {
    return 
}
add_filter( 'on_linky_filterName', 'on_linky_filterName', 10, 1 );
```

###### ___