<?php
/**
 * YiiMailer class - wrapper for PHPMailer
 * Yii extension for sending emails using views and layouts
 * Copyright (c) 2013 YiiMailer
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 *
 * @package YiiMailer
 * @author Vernes Šiljegović
 * @copyright  Copyright (c) 2013 YiiMailer
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version 1.0, 2013-01-02
 */



/**
 * Include the the PHPMailer class.
 */
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'PHPMailer'.DIRECTORY_SEPARATOR.'class.phpmailer.php');

/**
 * Define the name of the config file
 */
define('CONFIG_FILE','mail.php');

class YiiMailer extends PHPMailer {
	
	private $viewPath='application.views.mail';
	
	private $layoutPath='application.views.mail.layouts';
	
	private $baseDirPath='webroot.images.mail';
	
	private $layout;
	
	private $view;
	
	private $data;
	
	public $CharSet='UTF-8';
	
	public $AltBody='';
	
	/**
	 * Set and configure initial parameters
	 * @param string $layout Layout file
	 */
	public function __construct($view='', $data=array(), $layout='')
	{
		//initialize config
		$config=require(Yii::getPathOfAlias('application.config').DIRECTORY_SEPARATOR.CONFIG_FILE);
		$this->setConfig($config);
		//set view
		$this->setView($view);
		//set data
		$this->setData($data);
		//set layout
		$this->setLayout($layout);
	}
	
	/**
	 * Configure parameters
	 * @param array $config Config parameters
	 * @throws CException 
	 */
	private function setConfig($config)
	{
		if(!is_array($config))
			throw new CException("Configuration options must be an array!");
		foreach($config as $key=>$val)
		{
			$this->$key=$val;
		}
	}
	
	/**
	 * Set the view to be used
	 * @param string $view View file
	 * @throws CException 
	 */
	private function setView($view)
	{
		if($view!='')
		{
			if(!is_file(Yii::app()->controller->getViewFile($this->viewPath.'.'.$view)))
				throw new CException('View '.$view.' not found');
			$this->view=$view;
		}
	}
	
	/**
	 * Get currently used view
	 * @return string View filename
	 */
	public function getView()
	{
		return $this->view;
	}
	
	/**
	 * Send data to be used in mail body
	 * @param array $data Data array
	 */
	private function setData($data)
	{
		$this->data=$data;
	}
	
	/**
	 * Get current data array
	 * @return array Data array
	 */
	public function getData()
	{
		return $this->data;
	}
	
	/**
	 * Set layout file to be used
	 * @param string $layout Layout filename
	 * @throws CException 
	 */
	public function setLayout($layout)
	{
		if($layout!='')
		{
			if(!is_file(Yii::app()->controller->getViewFile($this->layoutPath.'.'.$layout)))
				throw new CException('Layout '.$layout.' not found!');
			$this->layout=$layout;
		}
	}
	
	/**
	 * Get current layout
	 * @return string Layout filename
	 */
	public function getLayout()
	{
		return $this->layout;
	}
	
	/**
	 * Set path for email views
	 * @param string $path Yii path
	 * @throws CException 
	 */
	public function setViewPath($path)
	{
		if (!is_string($path) && !preg_match("/[a-z0-9\.]/i",$path))
			throw new CException('Path '.$path.' not valid!');
		$this->viewPath=$path;
	}
	
	/**
	 * Get path for email views
	 * @return string Yii path 
	 */
	public function getViewPath()
	{
		return $this->viewPath;
	}
	
	/**
	 * Set path for email layouts
	 * @param string $path Yii path
	 * @throws CException 
	 */
	public function setLayoutPath($path)
	{
		if (!is_string($path) && !preg_match("/[a-z0-9\.]/i",$path))
			throw new CException('Path '.$path.' not valid!');
		$this->layoutPath=$path;
	}
	
	/**
	 * Get path for email layouts
	 * @return string Yii path 
	 */
	public function getLayoutPath()
	{
		return $this->layoutPath;
	}
	
	/**
	 * Set path for images to embed in email messages
	 * @param string $path Yii path
	 * @throws CException 
	 */
	public function setBaseDirPath($path)
	{
		if (!is_string($path) && !preg_match("/[a-z0-9\.]/i",$path))
			throw new CException('Path '.$path.' not valid!');
		$this->baseDirPath=$path;
	}
	
	/**
	 * Get path for email images
	 * @return string Yii path 
	 */
	public function getBaseDirPath()
	{
		return $this->baseDirPath;
	}
	
	/**
	 * Generates HTML email, with or without layout
	 */
	public function render()
	{
		//render body
		$body=Yii::app()->controller->renderPartial($this->viewPath.'.'.$this->view, $this->data, true);
		if($this->layout)
		{
			//has layout
			$this->MsgHTMLWithLayout($body, Yii::getPathOfAlias($this->baseDirPath));
		}
		else
		{
			//no layout
			$this->MsgHTML($body, Yii::getPathOfAlias($this->baseDirPath));
		}
	}
	
	/**
	 * Render HTML email message with layout
	 * @param string $message Email message
	 * @param string $basedir Path for images to embed in message
	 */
	public function MsgHTMLWithLayout($message, $basedir = '')
	{
		$this->MsgHTML(Yii::app()->controller->renderPartial($this->layoutPath.'.'.$this->layout, array('content'=>$message,'data'=>$this->data), true), $basedir);
	}
	
}