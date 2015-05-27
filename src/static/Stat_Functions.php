<?php

namespace GFPDF\Stat;

/**
 * Common Static Functions Shared throughour Gravity PDF
 *
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2015, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.0
 */

/* Exit if accessed directly */
if (! defined('ABSPATH')) {
    exit;
}

/*
    This file is part of Gravity PDF.

    Gravity PDF Copyright (C) 2015 Blue Liquid Designs

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * @since  4.0
 */
class Stat_Functions
{

    /**
     * Check if the current admin page is a Gravity PDF page 
     * @since 4.0
     * @return void
     */    
    public static function is_gfpdf_page() {
        if(is_admin()) {
            if(isset($_GET['page']) && (substr($_GET['page'], 0, 6) === 'gfpdf-') ||
            (isset($_GET['subview']) && strtoupper($_GET['subview']) === 'PDF')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if we are on the current global settings page / tab 
     * @since 4.0
     * @return void
     */  
    public static function is_gfpdf_settings_tab($name) {
        if(is_admin()) {
            if(self::is_gfpdf_page()) {
                $tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';

                if($name === $tab) {
                    return true;
                }
            }
        }
        return false;
    }    

    /**
     * Modified version of get_upload_dir() which just focuses on the base directory
     * no matter if single or multisite installation
     * We also only needed the basedir and baseurl so stripped out all the extras
     * @return Array Base dir and url for the upload directory
     */
    public static function get_upload_dir() {
        $siteurl = get_option('siteurl');
        $upload_path = trim(get_option('upload_path'));

        if (empty($upload_path) || 'wp-content/uploads' == $upload_path) {
            $dir = WP_CONTENT_DIR.'/uploads';
        } elseif (0 !== strpos($upload_path, ABSPATH)) {
            // $dir is absolute, $upload_path is (maybe) relative to ABSPATH
                    $dir = path_join(ABSPATH, $upload_path);
        } else {
            $dir = $upload_path;
        }

        if (!$url = get_option('upload_url_path')) {
            if (empty($upload_path) || ('wp-content/uploads' == $upload_path) || ($upload_path == $dir)) {
                $url = WP_CONTENT_URL.'/uploads';
            } else {
                $url = trailingslashit($siteurl).$upload_path;
            }
        }

            /*
             * Honor the value of UPLOADS. This happens as long as ms-files rewriting is disabled.
             * We also sometimes obey UPLOADS when rewriting is enabled -- see the next block.
             */
            if (defined('UPLOADS') && ! (is_multisite() && get_site_option('ms_files_rewriting'))) {
                $dir = ABSPATH.UPLOADS;
                $url = trailingslashit($siteurl).UPLOADS;
            }

        $basedir = $dir;
        $baseurl = $url;

        return array(
            'basedir' => $basedir,
            'baseurl' => $baseurl,
        );
    }
}