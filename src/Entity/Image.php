<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Entity;

/**
 * Class Image
 * @since 0.0.1
 */
class Image
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getImageUrl($size = 'thumbnail') {
        $image = wp_get_attachment_image_src($this->id, $size);
        if(strpos($size, 'icon') !== false) {
            $imageFull = wp_get_attachment_image_src($this->id, 'full');
            if($image == $imageFull) {
                $image = wp_get_attachment_image_src($this->id, 'thumbnail');
            }
        }

        return $image[0];
    }
}
