<?php

/**********************
* Wordpress Dashboard widget for KontrolWP
* @author Euphern Technology Pvt. Ltd.
* @author_uri http://www.euphern.com
* @since 2.0.3
***********************/


class KWPDashboardController {
    public function actionQuickWidget() {
        add_action('wp_dashboard_setup', array(&$this, 'kontrolwp_dashboard_widget_setup'));
    }

    /**
     * Add a dashboard widget for KontrolWP Quick Links.
     *
     */
    public function kontrolwp_dashboard_widget_setup() {
        wp_add_dashboard_widget(
            'kontrolwp_dashboard',
            'KontrolWP Quick Links',
            array(&$this, 'kontrolwp_dashboard_widget_cb')
        );  
    }

    public function kontrolwp_dashboard_widget_cb() {
        $html = '<style type="text/css">
                    #kontrolwp_dashboard .rss-widget {border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px;}
                    #kontrolwp_dashboard .rss-widget:last-child {border-bottom: 0 none; padding-bottom: 0px; margin-bottom: 0px;}
                </style>
                <div class="rss-widget">
                    <ul>
                        <li>
                            <a class="rsswidget" href="https://github.com/techunits/kontrolwp/releases/tag/v'.APP_VER.'">
                                &raquo; Release Notes for KontrolWP: '.APP_VER.'
                            </a>
                        </li>
                        <li>
                            <a class="rsswidget" href="https://github.com/techunits/kontrolwp/wiki/Functional-References">
                                &raquo; Functional References for Developers
                            </a>
                        </li>
                        <li>
                            <a class="rsswidget" href="https://www.kontrolwp.com/feature/post-duplicator/">
                                &raquo; Post/Page/Custom Post Type Duplicator
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="rss-widget">
                    <ul class="subsubsub" style="float: none;">
                        <li class="all">
                            <a href="'.site_url('/wp-admin/options-general.php?page=kontrolwp&url=custom_post_types').'">Post Types</a> |
                        </li>
                        <li class="all">
                            <a href="'.site_url('/wp-admin/options-general.php?page=kontrolwp&url=taxonomies').'">Taxonomies</a> |
                        </li>
                        <li class="all">
                            <a href="'.site_url('/wp-admin/options-general.php?page=kontrolwp&url=custom_fields').'">Advanced Custom Fields</a> |
                        </li>
                        <li class="all">
                            <a href="'.site_url('/wp-admin/options-general.php?page=kontrolwp&url=custom_settings').'">Admin Settings</a> | 
                        </li>
                        <li class="all">
                            <a href="'.site_url('/wp-admin/widgets.php').'">Widgets</a>
                        </li>
                    </ul>
                </div>';
        echo $html;
    }
}

?>