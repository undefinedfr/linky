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
    public $header_theme;
    public $body_theme;
    public $links_background_color;
    public $links_text_color;
    public $links_border_color;
    public $links_label_background_type;
    public $links_label_background_gradient_id;
    public $links_label_background_color;
    public $links_label_text_color;
    public $header_background_type;
    public $header_background_color;
    public $header_background_gradient_id;
    public $header_text_color;
    public $header_background_image;
    public $separator_color;
    public $analyticsCode;
    public $labels;
    public $menuId;
    public $socialLinks;

    public function __construct($data = [])
    {
        $this->set('title', get_bloginfo('name'));
        $this->set('avatar', new Image(0));

        parent::__construct($data);
    }

    /**
     * Set var
     *
     * @return void;
     */
    public function set($var, $value){
        switch ($var) {
            case 'header_background_image':
            case 'background_image':
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
