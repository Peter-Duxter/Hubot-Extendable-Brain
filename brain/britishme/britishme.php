<?php
/**
* This file wasn't included in the british.php brain script mainly 
* because simple_html_dom doesn't work very nicely with already instantiated
* objects and I was too lazy to re-write it.
* Will do so in a future version.
* As of 3/13/2012 this file is guarunteed to work,
* we use it to help translate what our British developer is talking about.
* All rights go to peevish.co.uk for definitions of words that you search for.
* Using an unmodfied british.php syntax is as follows:
*
* .british me ace
*
* @author:   Peter Olds
* @email:    peter@olds.co
* @version:  1
* @modified: 3/13/2012 2:33 AM MST
**/


header('Content-Type: text/html');
header('Access-Control-Allow-Origin: *');
set_time_limit(0);

scrapeSlang();

function htmltrim( $text )
{
	while( substr_count( $text ,"  ") != 0 )
	{
        $text = str_replace("  ", " ", $text );
    }
    return $text;
}

function scrapeSlang()
{
	include_once( "simple_html_dom.php" );
	
	if ( !isset( $_GET['i'] ) ):
		exit();
	else:
		$i = urldecode( trim( $_GET['i'] ) );
	endif;
	
	if ( !isset( $_GET['a'] ) || ( $_GET['a'] != md5( "Snow White" ) ) ):
		exit();
	endif;
	
	$url = "http://www.peevish.co.uk/slang/" . substr( $i, 0, 1 ) . ".htm";
	
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/18.6.872.0 Safari/535.2 UNTRUSTED/1.0 3gpp-gba UNTRUSTED/1.0');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($ch); 
	curl_close($ch);
	
	$dom = str_get_html( $html );
	$html = $dom->find( 'table[WIDTH="97%"]', 0 )->innertext;
	$html = str_get_html( $html );
	
	$out = "";
	foreach( @$html->find( 'tr' ) as $element )
	{
		$word = strtolower( trim( $element->find( 'td', 0 )->plaintext ) );
		$def = trim( $element->find( 'td', 1 )->plaintext );
		
		$word = ltrim( $word );
		$word = rtrim( $word );
		$word = str_replace( "<b>", '', $word );
		$word = str_replace( "</b>", '', $word );
		$word = str_replace( "<strong>", '', $word );
		$word = str_replace( "</strong>", '', $word );
		$word = preg_replace( '/\<a name="(.*)"\>\<\/a\>/', '', $word );
		
		$def = htmltrim( $def );
		$def = str_replace( "</i>", '', $def );
		$def = str_replace( "<i>", '', $def );
		$def = str_replace( "&quot;", '', $def );
		$def = str_replace( "<em>", '', $def );
		$def = str_replace( "</em>", '', $def );
		$def = preg_replace( '/\<a href="(.*)"\>/', '', $def );
		$def = str_replace( "</a>", '', $def );
		$def = str_replace( "<p>", '', $def );
		$def = str_replace( "</p>", '', $def );
		
		if ( preg_match( "/\b" . $i . "\b/i", $word ) )
		{
			$out .= $word . "\n";
			$out .= $def . "\n\n";
		}				
	}
	if ( !$out || $out == ""):
		echo "No matches for " . $i;
	else:	
		echo $out;
	endif;
	
	exit();			
}