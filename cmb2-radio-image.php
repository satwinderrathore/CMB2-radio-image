<?php
/*
Plugin Name: CMB2 Radio Image
Description: https://github.com/satwinderrathore/CMB2-Radio-Image/
Version: 0.1
Author: Satwinder Rathore
Author URI: http://satwinderrathore.wordpress.com
License: GPL-2.0+
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'CMB2_Radio_Image' ) ) {
    /**
     * Class CMB2_Radio_Image
     */
    class CMB2_Radio_Image {

        public function __construct() {
            add_action( 'cmb2_render_radio_image', array( $this, 'callback' ), 10, 5 );
            add_filter( 'cmb2_list_input_attributes', array( $this, 'attributes' ), 10, 4 );
            add_action( 'admin_head', array( $this, 'admin_head' ) );
        }

        public function callback($field, $escaped_value, $object_id, $object_type, $field_type_object) {
            echo $field_type_object->radio();
        }


        public function attributes($args, $defaults, $field, $cmb) {
            if ($field->args['type'] == 'radio_image' && isset($field->args['images'])) {
                foreach ($field->args['images'] as $field_id => $image) {
                    if ($field_id == $args['value']) {
                        $image = trailingslashit($field->args['images_path']) . $image;
                        $args['label'] = '<img src="' . $image . '" alt="' . $args['value'] . '" title="' . $args['label'] . '" />';
                    }
                }
            }
            return $args;
        }


        public function admin_head() {
            ?>
            <style>
                .cmb-type-radio-image .cmb2-radio-list {
                    display: block;
                    clear: both;
                    overflow: hidden;
                }

                .cmb-type-radio-image .cmb2-radio-list input[type="radio"] {
                    display: none;
                }

                .cmb-type-radio-image .cmb2-radio-list li {
                    display: inline-block;
                    margin-bottom: 0;
                }

                .cmb-type-radio-image .cmb2-radio-list input[type="radio"] + label {
                    border: 3px solid #eee;
                    display: block;
                }

                .cmb-type-radio-image .cmb2-radio-list input[type="radio"] + label:hover,
                .cmb-type-radio-image .cmb2-radio-list input[type="radio"]:checked + label {
                    border-color: #ccc;
                }

                .cmb-type-radio-image .cmb2-radio-list li label img {
                    display: block;
                }
            </style>
            <?php
        }
    }

    $cmb2_radio_image = new CMB2_Radio_Image();

}