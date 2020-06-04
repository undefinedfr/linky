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
 * @since 1.0.0
 */
class Page extends AbstractEntity
{
    /**
     * @var string $title
     */
    public $title;

    /**
     * @var int|\LinkyApp\Entity\Image $avatar
     */
    public $avatar;

    /**
     * @var bool $social_display
     */
    public $social_display;

    /**
     * @var string $background_type
     */
    public $background_type;

    /**
     * @var string $text_color
     */
    public $text_color;

    /**
     * @var string $background_color
     */
    public $background_color;

    /**
     * @var string $background_gradient_id
     */
    public $background_gradient_id;

    /**
     * @var int|\LinkyApp\Entity\Image $background_image
     */
    public $background_image;

    /**
     * @var string $header_theme
     */
    public $header_theme;

    /**
     * @var string $body_theme
     */
    public $body_theme;

    /**
     * @var string $links_background_color
     */
    public $links_background_color;

    /**
     * @var string $links_text_color
     */
    public $links_text_color;

    /**
     * @var string $links_border_color
     */
    public $links_border_color;

    /**
     * @var string $links_label_background_type
     */
    public $links_label_background_type;

    /**
     * @var string $links_label_background_gradient_id
     */
    public $links_label_background_gradient_id;

    /**
     * @var string $links_label_background_color
     */
    public $links_label_background_color;

    /**
     * @var string $links_label_text_color
     */
    public $links_label_text_color;

    /**
     * @var string $header_background_type
     */
    public $header_background_type;

    /**
     * @var string $header_background_color
     */
    public $header_background_color;

    /**
     * @var string $header_background_gradient_id
     */
    public $header_background_gradient_id;

    /**
     * @var string $header_text_color
     */
    public $header_text_color;

    /**
     * @var int|\LinkyApp\Entity\Image $header_background_image
     */
    public $header_background_image;

    /**
     * @var string $separator_color
     */
    public $separator_color;

    /**
     * @var string $analyticsCode
     */
    public $analyticsCode;

    /**
     * @var array $labels
     */
    public $labels;

    public function __construct($data = [])
    {
        $this->set('title', get_bloginfo('name'));
        $this->set('avatar', 0);

        parent::__construct($data);
    }

    /**
     * Set var
     *
     * @param string $var var key
     * @param string $value value
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
            default:
                $this->{$var} = $value;
                break;
        }
    }
}
