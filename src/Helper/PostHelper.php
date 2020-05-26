<?php
/**
 * @author    [Undefined] RIVIERE Nicolas <hello@undefined.fr>
 * @copyright 2020-present Undefined
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.undefined.fr
 */

namespace LinkyApp\Helper;

/**
 * Class PostHelper
 * @since 0.0.1
 */
if(!class_exists('PostHelper')) {
    class PostHelper
    {
        private $edited = false;

        public function __construct($post = '')
        {
            $this->data = new stdClass();
            if ($post)
                $this->fill($post);
            return $this;
        }

        /**
         * LoadByID
         *
         * @param $ID
         * @return PostHelper
         */
        public function load($ID)
        {
            global $wpdb;
            $post = $wpdb->get_row('SELECT * FROM ' . $wpdb->posts . ' WHERE ID = "' . mysqli::escape_string($ID) . '"');
            return $this->fill($post);
        }

        /**
         * Fill Post
         *
         * @param $data
         * @return $this
         */
        public function fill($data)
        {

            if (is_array($data)) {
                foreach ($data as $k => $v) {
                    $this->data->{$k} = $v;
                }
            }
            else
                $this->data = $data;

            return $this;
        }

        /**
         * Get All Post Data
         *
         * @param string $key
         * @return bool|mixed|stdClass
         */
        public function getData($key = '')
        {
            if (!$key)
                return $this->data;

            if (!$this->data)
                return false;

            if ($this->data->{$key}) {
                return $this->data->{$key};
            }
            else {
                return get_post_meta($this->getID(), strtolower($key), true);
            }
        }

        /**
         * Get PostID
         * @return bool|mixed|stdClass
         */
        public function getID()
        {
            if ($this->data->ID)
                return $this->getData('ID');
            else
                return false;
        }
    }
}