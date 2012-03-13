<?php
if( !defined( 'IN_BRAIN' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}

class british extends Hubot
{
	public function __construct( ) { }
	
	/******
	* REQUIRED FUNCTION
	* @param	string	$match - The first word or command word
	* @param	string	$cmd - The full string of commands
	* @param	string	$orig - The untouched string
	*******/
	public function newRules( $match, $cmd, $orig )
	{
		switch( $match )
		{
			case 'british':
				$this->getBrits( str_replace( ".british me ", '', strtolower( $orig ) ) );				
			break;			
		}				
	}
	
	/****
	*
	* @param	string	$test
	* @return	e
	*****/
	private function getBrits( $_ )
	{
		// a = md5( "Snow White" );
		$this->show( file_get_contents( 'http://localhost/britishme/britishme.php?i=' . urlencode( $_ ) . '&a=ece937ff8d2d0b8847b2069006d5fd87' ) );
	}
}
?>