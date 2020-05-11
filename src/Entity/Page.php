<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

use LinkyApp\Entity\Image;

/**
 * Class Page
 * @since 0.0.1
 */
class Page extends AbstractEntity
{
    public $title;
    public $avatar;
    public $social_display;
    public $background_type;
    public $text_color;
    public $background_color;
    public $background_gradient_id;
    public $background_image;
    public $themeId;
    public $analyticsCode;
    public $labels;
    public $menuId;
    public $socialLinks;

    public function __construct($data = [])
    {
        $this->set('title', get_bloginfo('name'));
        $this->set('avatar', UNDFND_WP_LINKY_PLUGIN_URL . '/assets/images/logo.png');

        parent::__construct($data);
    }

    /**
     * Set var
     *
     * @return void;
     */
    public function set($var, $value){
        switch ($var) {
            case 'backgroundImage':
            case 'avatar':
                $this->{$var} = new Image($value);
                break;
            case 'socialLinks':
                // new SocialLinks($value)
                break;
            default:
                $this->{$var} = $value;
                break;
        }
    }
}
