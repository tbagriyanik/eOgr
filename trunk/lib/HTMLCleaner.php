<?php
/*HTMLCleaner 1.0 (c) 2007-2008 Lucian Sabo
HTML source code cleaner (great help for cleaning MS Word content)
luciansabo@gmail.com

Licenced under Creative Commons Attribution-Noncommercial-Share Alike 3.0 Unported (http://creativecommons.org/licenses/by-nc-sa/3.0/)
for personal, non-commercial use
--------*/
define("TAG_WHITELIST",0);
define("TAG_BLACKLIST",1);
define("ATTRIB_WHITELIST",0);
define("ATTRIB_BLACKLIST",1);

class HTMLCleaner
{
var $Options;
var $Tag_whitelist='<table><tbody><thead><tfoot><tr><th><td><colgroup><col>
<p><br><hr><blockquote>
<b><i><u><sub><sup><strong><em><tt><var>
<code><xmp><cite><pre><abbr><acronym><address><samp>
<fieldset><legend>
<a><img>
<h1><h2><h3><h4><h4><h5><h6>
<ul><ol><li><dl><dt>
<frame><frameset><iframe>
<form><input><select><option><optgroup><button><textarea><object><embed>';
var $Attrib_blacklist='id|on[\w]+';
var $CleanUpTags=array('a','span','b','i','u','strong','em','big','small','tt','var','code','xmp','cite','pre','abbr','acronym','address','q','samp','sub','sup');//array of inline tags that can be merged
var $TidyConfig;
var $Encoding='latin1';
var $Version='1.0 RC6';
function HTMLCleaner(){
$this->Options = array(
			'RemoveStyles'		=> true,	//removes style definitions like style and class
			'IsWord'		=> true,	//Microsoft Word flag - specific operations may occur
			'UseTidy'		=> true,	//uses the tidy engine also to cleanup the source (reccomended)
			'TidyBefore'		=> false,	//apply Tidy first (not reccomended as tidy messes up sometimes legitimate spaces
			'CleaningMethod'	=> array(TAG_WHITELIST,ATTRIB_BLACKLIST),	//cleaning methods
			'OutputXHTML'		=> true,	//converts to XHTML by using TIDY.
			'FillEmptyTableCells' => true, 	//fills empty cells with non-breaking spaces
			'DropEmptyParas'	=> true,	//drops empty paragraphs
			'Optimize'			=>true,		//Optimize code - merge tags
			'Compress'			=> false);	//trims all spaces (line breaks, tabs) between tags and between words.

// Specify TIDY configuration
$this->TidyConfig = array(
       'indent'         => true, /*a bit slow*/
       'output-xhtml'   => true, //Outputs the data in XHTML format
	   'word-2000'		=> false, //Removes all proprietary data when an MS Word document has been saved as HTML
	   //'clean'		=> true, /*too slow*/
	   'drop-proprietary-attributes' =>true, //Removes all attributes that are not part of a web standard
	   'hide-comments' => true, //Strips all comments
	   'preserve-entities' => true,	// preserve the well-formed entitites as found in the input
	   'quote-ampersand' => true,//output unadorned & characters as &amp;.
	   'show-body-only' => true,
	   'wrap'           => 200); //Sets the number of characters allowed before a line is soft-wrapped
}
/*-----------------------------------------------------------------------------*/
function RemoveBlacklistedAttributes($attribs){
		//the attribute _must_ have a line-break or a space before
		$this->html =  preg_replace('/[\s]+('.$attribs.')=[\s]*("[^"]*"|\'[^\']*\')/i',"",$this->html); //double and single quoted
		$this->html =  preg_replace('/[\s]+('.$attribs.')=[\s]*[^ |^>]*/i',"",$this->html); 	//not quoted
}

/*-----------------------------------------------------------------------------*/
function TidyClean()
{
if (!class_exists('tidy')) {
	if( function_exists( 'tidy_parse_string' ) ) {
	//use procedural style for compatibility with PHP 4.3
	tidy_set_encoding($this->Encoding);
	foreach ($this->TidyConfig as $key => $value) {
	   tidy_setopt($key,$value);
	}
	tidy_parse_string($this->html);
	tidy_clean_repair();
	$this->html=tidy_get_output();	    
	}
	else
	print("<b>No tidy support. Please enable it in your php.ini.\r\nOnly basic cleaning is beeing applied\r\n</b>");
}
else
	{
	//PHP 5 only !!!
	$tidy = new tidy;
	$tidy->parseString($this->html, $this->TidyConfig, $this->Encoding);
	$tidy->cleanRepair();
	$this->html=$tidy;
	}
}
/*-----------------------------------------------------------------------------*/	
function cleanUp($encoding='latin1') {  

if(!empty($encoding))
$this->Encoding=$encoding;

//++++
if($this->Options['IsWord']){
	$this->TidyConfig['word-2000']=true;
	$this->TidyConfig['drop-proprietary-attributes']=true;
	}
else $this->TidyConfig['word-2000']=false;

//++++
if($this->Options['OutputXHTML']){
	$this->Options['UseTidy']=true;
	$this->TidyConfig['output-xhtml']=true;
} else $this->TidyConfig['output-xhtml']=false;

//++++
// Tidy
if($this->Options['UseTidy']){
if($this->Options['TidyBefore'])
$this->TidyClean();
}  
      
    // remove escape slashes  
    $this->html = stripslashes($this->html);  
      
//++++
    if($this->Options['CleaningMethod'][0]==TAG_WHITELIST){
		// trim everything before the body tag right away, leaving possibility for body attributes  
		if(preg_match("/<body/i", "$this->html"))
	    $this->html = stristr( $this->html, "<body");  
	      
	    // strip tags, still leaving attributes, second variable is allowable tags  
	    $this->html = strip_tags($this->html, $this->Tag_whitelist);  
	}
	        
//++++
	if($this->Options['RemoveStyles'])
		//remove class and style definitions from tidied result
		$this->RemoveBlacklistedAttributes('class|style');
	
//++++
	if($this->Options['IsWord']){	
	$this->RemoveBlacklistedAttributes('lang|[ovwxp]:\w+'); 
	}
	
//++++
	if($this->Options['CleaningMethod'][1]==ATTRIB_BLACKLIST){
	if(!empty($this->Attrib_blacklist))
	$this->RemoveBlacklistedAttributes($this->Attrib_blacklist);
	}	

//++++
	if($this->Options['Optimize']){
	//Optimize until nothing can be done for PHP 5, twice for PHP 4
	if((int)phpversion()>=5){
	$repl=1;
	while($repl){
	$repl=0;
	foreach($this->CleanUpTags as $tag){
	$this->html=preg_replace("/<($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<\/($tag)>/i","\\2", $this->html,-1,$count); //strip empty inline tags (must be on top of merge inline tags)
	$repl+=$count;
	$this->html=preg_replace("/<\/($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<($tag)>/i","\\2", $this->html,-1,$count);//merge inline tags
	$repl+=$count;				
	}
	}
	
	}
	else {//PHP 4
	$repl=1;
	while($repl){
	$repl=0;
	foreach($this->CleanUpTags as $tag){
	$count=preg_match("/<($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<\/($tag)>/i", $this->html);$repl+=$count;
	$this->html=preg_replace("/<($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<\/($tag)>/i","\\2", $this->html); //strip empty inline tags (must be on top of merge inline tags)	
	
	$count=preg_match("/<\/($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<($tag)>/i", $this->html);$repl+=$count;
	$this->html=preg_replace("/<\/($tag)[^>]*>[\s]*([(&nbsp;)]*)[\s]*<($tag)>/i","\\2", $this->html);//merge inline tags
	}
	}
	
	}//end php version test
		
	
	//drop empty paras after merging tags
	if($this->Options['DropEmptyParas'])
	$this->html=preg_replace('/<(p|h[1-6]{1})([^>]*)>[\s]*[(&nbsp;)]*[\s]*<\/(p|h[1-6]{1})>/i',"\r\n", $this->html);
	
	//trim extra spaces only if tidy is not set to indent
		if(!$this->TidyConfig['indent']){
		$this->html = preg_replace('/([^<>])[\s]+([^<>])/i',"\\1 \\2", $this->html);//trim spaces between words
		$this->html = preg_replace('/[\n|\r|\r\n|][\n|\r|\r\n|]+</i',"<", $this->html);	//trim excess spaces before tags
		}
	}	
//++++
	
	//must be on top of	FillEmptyTableCells, because it can strip nbsp enclosed in paras
	if($this->Options['DropEmptyParas'] && !$this->Options['Optimize'])
	$this->html=preg_replace('/<(p|h[1-6]{1})([^>]*)>[\s]*[(&nbsp;)]*[\s]*<\/(p|h[1-6]{1})>/i',"\r\n", $this->html);
//++++

	if($this->Options['FillEmptyTableCells'])
	  $this->html = preg_replace("/<td([^>]*)>[\s]*<\/td>/i", "<td\\1>&nbsp;</td>", $this->html);
   
//++++

    if($this->Options['Compress']) 
		{
		$this->html = preg_replace('/>[\s]+/',">", $this->html);	//trim spaces after tags
		$this->html = preg_replace('/[\s]+<\//',"</", $this->html);	//trim spaces before end tags
		$this->html = preg_replace('/[\s]+</',"<", $this->html);	//trim spaces before tags
		$this->html = preg_replace('/([^<>])[\s]+([^<>])/',"\\1 \\2", $this->html);//trim spaces between words
		}
//++++
// Tidy
if($this->Options['UseTidy']){
if(!$this->Options['TidyBefore'])
$this->TidyClean();
}  
	
	return $this->html;    
} 
}
