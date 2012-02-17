<?php
/***
* Hubot Extendable *Smart* Brain - A.K.A. Tippy
* Author: Peter Olds
* Email: peter@olds.co
* Date Modified: 2/16/2012 8:30 PM
* Version: 1.0
*
* Feel free to modify this script as you please :)
****/

/***
* Some of these functions may look confusing
* this "bot" is designed to be an intelligent bot.
* I was interested in making it feel more human so you can
* ask it things like "Please do action, thank you!"
* and the script will strip "Please" "do" and ",thank you!"
* mostly stupid but kinda cool at the same time
****/
define( 'IN_BRAIN', TRUE );


// Init the class
$Hubot = new Hubot(  );

// Start the class
$Hubot->doExecute();

class Hubot
{
	public $cmd;
	
	/***
	* API Token. Make sure random people can't run this
	* Make sure your Hubot is passing this token along
	* or we'll run into issues :)
	* md5("Jack Sparrow") - Seriously - Change if you dare ;)
	***/
	public $token = "2ee9a2ec7ebffaecc61f8f011981852e";
	
	/***
	*
	* @access	public
	* @param	none
	* @return 	none
	****/
	function __construct( ) { }
	
	/***
	*
	* @access	public
	* @param	none
	* @return 	none
	****/
	public function doExecute()
	{
		if ( !isset( $_GET['token'] ) || $_GET['token'] != $this->token )
		{
			// Remember show() also exits so we're good here.
			$this->show ( "He's dead Jim" );
		}
		
		$this->cmd = $_GET['cmd'];
		$this->cmd_orig = $this->cmd;
		$this->cmd = urldecode( strtolower( substr( $this->cmd, 1 ) ) );
		$this->cmd = $this->realistic( $this->cmd );
		
		//$this->show ( $this->dir() );
		
		$matches = explode( " ", $this->cmd );
		
		$this->cmd = "";		
		foreach ( $matches as $m )
		{
			if ( $m != '' )
			{
				$this->cmd .= $m . " ";
			}
		}
		
		$i = 0;
		$done = false;
		while ( !$done ):
			if ( $matches[$i] != '' ):
				$done = true;
				$match = $matches[$i];
			endif;
			$i++;			
		endwhile;
		
		$this->requirer( $match, $this->cmd, $this->cmd_orig );		
	}	
	
	/***********************************
	* Handler Functions	
	************************************/

	/****
	* Hubot outputs this.
	* @access	protected
	* @param	string	Message to output
	* @return	string	
	*****/
	protected function show( $msg )
	{
		$msg = preg_replace( '/(<br ?\/?>)/i', '\n', $msg );
		echo $msg;
		exit;
	}
	
	/***
	*
	* @access	private
	* @param	string	Message to clean
	* @return	string	
	*****/
	private function realistic( $msg )
	{
		if ( $msg )
		{
			//preg_replace( '#[^a-zA-Z9-0]#', "", $msg );
			$search = array( "/( ?)hubot( ?)/i", "/do(es?)/i", "/please/", "/thank(s?)( you?)/i", "/ a /i", "/for/i", "/(h?)is/i", "/( ?)new( ?)/i", "/get/i", "/fetch/i", "/the/i", "/what/i", "/have/i" );
			$new = preg_replace( $search, "", $msg );
			return $new;
		}
	}
	
	/***
	* Really cool function that reads in every script in our brain and auto-instantiates it and executes.
	*
	* @access	private
	* @param	array		
	* @param	string	The cleaned string
	* @param	string	The original input untouched (Allows you to handle the string yourself in other files)
	* @return	none
	***/	
	private function requirer( $match, $cmd, $orig )
	{
		$itemHandler = opendir( $this->dir() );
    	$i = 0;
    	while( ( $item = readdir( $itemHandler ) ) !== false )
    	{
        	if( substr( $item, 0, 1 ) != "." )
        	{
            	if( !is_dir( $item ) && substr( $item, -4 ) == ".php" )
            	{
                	require_once ( $this->dir() . $item );
                	$item = str_replace( ".php", "", $item );
                	$$item = new $item();
                	$$item->newRules( $match, $cmd, $orig );                	
            	}              
        	}
       	}	
	}
	
	/***
	* @access	protected
	* @param	none
	* @return	string
	***/		
	protected function dir()
	{
		return dirname(__FILE__) .  '/brain/';			
	}
}
?>
