<?php

/**********************
* Registers the Kontrol Plugin
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/


class RegisterController extends AdminController
{
	
	public $wpdb;
	
	/**********************
	* Constructor
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	protected function beforeAction() {
		
		parent::beforeAction();
		
		global $wpdb;
		$this->wpdb = $wpdb; 
			
	}
	
	
	/**********************
	* Controller Index
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionIndex()
	{
		$this->controller_layout = 'enter-key';
	}
	
	/**********************
	* Upgrade Kontrol
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function actionUpgrade()
	{
		
		$response = array();
		
		$fields = array(
            'ac'=>'register', 'app_id'=>APP_ID, 'app_ver'=>APP_VER, 'app_url'=>get_bloginfo('url'), 'app_key'=>trim($this->post['key'])
        );
		
		$fields_string = '';
		
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string,'&');
		
		$ch = curl_init();
		// Connect to Kontrol and validate the key
		curl_setopt($ch, CURLOPT_URL, APP_UPGRADE_ACTIVATE_URL.'/index.php');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		
		
		// Execute post
		$result = curl_exec($ch);
		
		if(!$result) {
			$response = array('result'=>'false', 'error'=>'A CURL error occured while attempting to contact - '.APP_UPGRADE_ACTIVATE_URL);
			echo json_encode($response);
		}else{
			$response = stripslashes($result);
			$resp = json_decode($response);
			// Successs?
			if($resp->result == 'true') {
				update_option('kontrol_verify_cache', $resp->wp_key);
				update_option('kontrol_serial', $resp->app_key);
			}
			echo $response;
		}
				
		// Close connection
		curl_close($ch);

	}
	
	

}

?>