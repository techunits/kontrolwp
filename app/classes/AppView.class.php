<?php

class AppView extends Lvc_View
{
	protected function beforeAction()
	{
		//echo ' VIEW OUTPUT! ';	
	}
	
	public function addCSS($cssFile)
	{
		$this->controller->requireCss($cssFile);
	}
}

?>