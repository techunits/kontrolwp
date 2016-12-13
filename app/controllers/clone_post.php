<?php

/**********************
* Post cloning for KontrolWP
* @author Sougata Pal
* @author_uri https://www.linkedin.com/in/skallpaul
* @since 2.0.6
***********************/

class ClonePostController {

    public function actionClone() {
        add_filter('post_row_actions', array(&$this, 'duplicatePostListFilter'), 10, 2);
        add_filter('page_row_actions', array(&$this, 'duplicatePostListFilter'), 10, 2);
        add_action('post_submitbox_misc_actions', array(&$this, 'attachPostSubmitCloneButton'), 10, 1);
        add_action('admin_bar_menu', array(&$this, 'duplicatePostAdminBarMenu'), 99999);

        add_action('admin_action_kwpclone', array(&$this, 'duplicatePostAction'), 10, 1);
        add_action('admin_action_kwpclonepublish', array(&$this, 'duplicatePostPublishAction'), 10, 1);
    }

    public function attachPostSubmitCloneButton($post) {
        $html  = '<div id="major-publishing-actions" style="overflow:hidden">';
        $html .=    '<div id="publishing-action">';
        $html .=        '<a title="Clone" class="preview button" id="custom" href="'.$this->__duplicatePostActionURL($post).'">Clone as Draft</a>';
        $html .=        '<a title="Clone" class="preview button" id="custom" href="'.$this->__duplicatePostPublishActionURL($post).'">Clone &amp; Publish</a>';
        $html .=    '</div>';
        $html .= '</div>';
        echo $html;
    }

    public function duplicatePostListFilter($actions, $post) {
        $actions['clone'] = '<a href="'.$this->__duplicatePostActionURL($post).'" title="'
                . esc_attr(__("Clone this item"))
                . '">' .  __('Clone') . '</a>';
        $actions['clone-publish'] = '<a href="'.$this->__duplicatePostPublishActionURL($post).'" title="'
                . esc_attr(__("Clone &amp; Publish this post"))
                . '">' .  __('Clone &amp; Publish') . '</a>';

        return $actions;
    }

    public function duplicatePostAdminBarMenu($wp_admin_bar) {
        global $post;
        if(!empty($post)) {
            $wp_admin_bar->add_menu(array(
                'id'    =>  'kwp-clone',
                'title' =>  '<img src="'.plugins_url('kontrolwp/images/icon-clone.png').'" />&nbsp;&nbsp;<span>Clone / Duplicate</span>'
            ));

            $wp_admin_bar->add_menu(array(
                'id'        =>  'kwp-clone-draft',
                'parent'    =>  'kwp-clone',
                'title'     =>  '<img src="'.plugins_url('kontrolwp/images/icon-edit.png').'" />&nbsp;&nbsp;<span>Clone to Draft</span>',
                'href'      =>  $this->__duplicatePostActionURL($post)
            ));

            $wp_admin_bar->add_menu(array(
                'id'        =>  'kwp-clonepublish',
                'parent'    =>  'kwp-clone',
                'title'     =>  '<img src="'.plugins_url('kontrolwp/images/icon-edit.png').'" />&nbsp;&nbsp;<span>Clone &amp; Publish</span>',
                'href'      =>  $this->__duplicatePostPublishActionURL($post)
            ));
        }
    }

    public function duplicatePostAction() {
        $post_type = (!empty($_REQUEST['post_type']))?$_REQUEST['post_type']:'post';
        if(!empty($_REQUEST['p'])) {
            $post_id = $_REQUEST['p'];
        }
        else {
            wp_die('Invalid Request');
        }

        //  get current user_id
        $user_id = get_current_user_id();

        //  clone post and generate new post ID
        $dup_post_id = $this->duplicatePost($post_id, $user_id, 'draft');

        //  open EDIT page for the newly created CLONED post
        $dup_post_edit_url =  htmlspecialchars_decode(get_edit_post_link($dup_post_id));
        wp_redirect($dup_post_edit_url);
        exit();
    }


    public function duplicatePostPublishAction() {
        $post_type = (!empty($_REQUEST['post_type']))?$_REQUEST['post_type']:'post';
        if(!empty($_REQUEST['p'])) {
            $post_id = $_REQUEST['p'];
        }
        else {
            wp_die('Invalid Request');
        }

        //  get current user_id
        $user_id = get_current_user_id();

        //  clone post and generate new post ID
        $dup_post_id = $this->duplicatePost($post_id, $user_id, 'publish');
        
        //  open view page for the newly created CLONED post
        $dup_post_url =  htmlspecialchars_decode(get_permalink($dup_post_id));
        wp_redirect($dup_post_url);
        exit();
    }

    private function duplicatePost($post_id, $user_id, $status = 'publish') {
        $post_info = get_post($post_id);

        //  save duplicate post info
        $cloned_title = preg_replace('/ - KWP Clone (\d+)/i', '', $post_info->post_title) . ' - KWP Clone ' . time().rand();
        $dup_post_id = wp_insert_post(array(
            'post_author'           =>  $user_id,
            'post_content'          =>  $post_info->post_content,
            'post_content_filtered' =>  $post_info->post_content_filtered,
            'post_title'            =>  $cloned_title,
            'post_excerpt'          =>  $post_info->post_excerpt,
            'post_status'           =>  $status,
            'post_type'             =>  $post_info->post_type,
            'post_password'         =>  $post_info->post_password,
            'post_parent'           =>  $post_info->post_parent
        ));

        //  save duplicate postmeta info
        $post_metakey_list = get_post_custom_keys($post_id);
        foreach($post_metakey_list as $post_metakey) {
            if(!stristr($post_metakey, '_edit_')) {
                $post_metaval = get_post_meta($post_id, $post_metakey, true);
                add_post_meta($dup_post_id, $post_metakey, $post_metaval);
            }
        }

        return $dup_post_id;
    }

    private function __duplicatePostActionURL($post) {
        return admin_url('admin.php?action=kwpclone&post_type='.$post->post_type.'&p='.$post->ID);
    }

    private function __duplicatePostPublishActionURL($post) {
        return admin_url('admin.php?action=kwpclonepublish&post_type='.$post->post_type.'&p='.$post->ID);
    }
}

?>