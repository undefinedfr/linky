<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Theme;

use LinkyApp\AbstractObject;

/**
 * Class AbstractTheme
 * @since 1.0.0
 */
class AbstractTheme extends AbstractObject
{
    /**
     * @var string Theme ID
     */
    protected $id;
    /**
     * @var string Type
     */
    protected $type;

    public function __construct($id = null, $data = [])
    {
        $this->set('id', $id);

        $this->_setData($data);
        $this->_setType();
    }

    /**
     * Get Image src
     *
     * @return string
     */
    public function getImageSrc()
    {
        $suffix = '/assets/images/themes/' . $this->type . '/' . $this->id . '.png';
        if(file_exists(UNDFND_WP_LINKY_THEME_DIR . $suffix)) {
            return UNDFND_WP_LINKY_THEME_DIR . $suffix;
        } else {
            return UNDFND_WP_LINKY_PLUGIN_URL . $suffix;
        }
    }

    /**
     * Set type
     *
     * @throws \ReflectionException
     */
    private function _setType() {
        $className = new \ReflectionClass(get_class($this));
        $this->type = strtolower(preg_replace('#^Abstract([a-zA-Z]{0,})Theme$#', '$1', $className->getShortName()));
    }
}
