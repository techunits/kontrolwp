<?=wp_editor( !empty($field_value) ? $field_value : $field->settings['default_value'], '_kontrol['.$field->field_key.']', $settings = array('media_buttons'=>$field->settings['allow_media_buttons']) );?>

  