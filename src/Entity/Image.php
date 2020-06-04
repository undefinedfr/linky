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
 * @since 1.0.0
 */
class Image
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get Image url for specific size
     * If size icon_* not exist, load thumbnail size
     *
     * @param string $size
     * @return mixed
     */
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
