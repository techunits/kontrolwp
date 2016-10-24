<?php

/**********************
* Registers the Kontrol Plugin
* @author Euphern Technology Pvt. Ltd. & David Rugendyke 
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class ClonePostController 
{

    public function actionClone()
    {
        add_filter('post_row_actions', array(&$this, 'duplicatePostListFilter'), 10, 2);
        add_filter('page_row_actions', array(&$this, 'duplicatePostListFilter'), 10, 2);

        add_action('admin_action_kwpclone', array(&$this, 'duplicatePostAction'), 10, 1);
    }

    public function duplicatePostListFilter($actions, $post) {
        $aurl = $this->__duplicatePostActionURL($post);
        $actions['clone'] = '<a href="'.$aurl.'" title="'
                . esc_attr(__("Clone this item", 'duplicate-post'))
                . '">' .  __('Clone', 'duplicate-post') . '</a>';
        $actions['edit_as_new_draft'] = '<a href="#" title="'
                . esc_attr(__('Copy to a new draft', 'duplicate-post'))
                . '">' .  __('New Draft', 'duplicate-post') . '</a>';

        return $actions;
    }

    public function duplicatePostAction() {
        $post_type = (!empty($_REQUEST['post_type']))?$_REQUEST['post_type']:'post';
        if(!empty($_REQUEST['p'])) {
            $post_id = $_REQUEST['p'];
        }
        else {
            wp_die('Invalid Request');
        }

        $user_id = get_current_user_id();
        $post_info = get_post($post_id);
        $cloned_title = $post_info->post_title . ' - KWP Cloned at ' . time();
        $dup_post_id = wp_insert_post(array(
            'post_author'           =>  $user_id,
            'post_content'          =>  $post_info->post_content,
            'post_content_filtered' =>  $post_info->post_content_filtered,
            'post_title'            =>  $cloned_title,
            'post_excerpt'          =>  $post_info->post_excerpt,
            'post_status'           =>  'draft',
            'post_type'             =>  $post_info->post_type,
            'post_password'         =>  $post_info->post_password,
            'post_parent'           =>  $post_info->post_parent
        ));
        $dup_post_edit_url =  get_edit_post_link($dup_post_id);
        wp_redirect($dup_post_edit_url);
        exit();
    }

    private function __duplicatePostActionURL($post) {
        return admin_url('admin.php?action=kwpclone&post_type='.$post->post_type.'&p='.$post->ID);
    }

}

?>