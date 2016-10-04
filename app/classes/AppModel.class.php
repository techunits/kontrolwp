<?

/**********************
* Controls the models of the Kontrol WP Framework
* Plugin URI: http://www.kontrolwp.com
* @author David Rugendyke
* @author_uri http://www.ironcode.com.au
* @since 1.0.0
***********************/

class KontrolModel
{
	
	/**********************
	* Loads a model, checks in various locations for them
	* @author David Rugendyke
	* @since 1.0.0
	***********************/
	public function load($model, $controller = NULL) 
	{
	   // Check to see if the model exists in the general models dir, otherwise search through the module model dirs
	   $model_path = APP_MODEL_PATH.$model.'.model.php';
	   $model_controller_path = APP_MODULE_PATH.$controller.'/models/'.$model.'.model.php';
	   
	  // echo $model_controller_path.'<br>';

	   // Check to see if it's in this controllers model dir first
	   if(file_exists($model_controller_path) && $controller) {
		    require_once($model_controller_path);
			return;
	   }elseif(file_exists($model_path)){
			require_once($model_path);	
			return;
	   }else{
			  // Check other modules to see if they have the required model
			 foreach(glob(APP_MODULE_PATH.'*/models/'.$model.'.model.php', GLOB_NOSORT) as $model_found) { 
				 require_once($model_found);
				 return;
			 }   
	   }
	   
	}
	
	
}