<?php
/***
* This is a simple working example.
****/
if( !defined( 'IN_BRAIN' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}

/******
* The class MUST be named the same as the .php filename.
*******/
class example extends Hubot
{
	function __construct( ) { }
	
	/******
	* REQUIRED FUNCTION
	* @param	string	$match - The first word or command word
	* @param	string	$cmd - The full string of commands
	* @return	none
	*******/
	public function newRules( $match, $cmd, $orig )
	{
		/*******
		* Add Rules to Hubots's Brain
		* Add the word that will trigger the rule
		* DO NOT ADD A DEFAULT CASE!!!!
		********/
		switch( $match )
		{
			case 'php':
				$this->php( $cmd );
			case 'example':
				$this->show( "You triggered me by telling me .example" );
			break;			
		}				
	}
	
	/***
	* This function is entirely optional
	* @param	string	The command string
	* @return	none
	****/
	public function php( $cmd )
	{
		$d = explode( " ", $cmd );	 	
	 	/****
	 	* Again don't add a default case.
	 	*****/
	 	switch ( $d[1] )
	 	{
			case 'date':
				$this->show( date('Y-m-d') . " -- Command Run: .php date");
				break;
			case 'version':
				$this->show( phpversion() . " -- Command Run: .php version");				
				break;
	 	}	 		 				
	}	
}
?>