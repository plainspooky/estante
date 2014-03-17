<?php
/*
  XHTML
  versão 0.1

  Copyright (C) 2005  Giovanni Nunes <bitatwork@yahoo.com>

  This program is free software; you can redistribute it and/or modify it under
  the terms of the GNU General Public License as published by the the Free
  Software Foundation; either version 2 of the License, or (at your option) any
  later version. 

  This program is distributed in the hope that it will be useful, but WITHOUT
  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
  FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
  details.

  You should have received a copy of the GNU General Public License along with
  this program; if not, write to the Free Software Foundation, Inc., 59 Temple
  Place, Suite 330, Boston, MA  02111-1307  USA
*/

function xhtml_begin($LANGUAGE)
{
  return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" ".
         "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n".
	 "<html lang=\"".$LANGUAGE."\"".
	 " xmlns=\"http://www.w3.org/1999/xhtml\">\n\n";
}

function xhtml_header($CHARSET,$AUTHOR,$KEYWORDS,$DESCRIPTION,$STYLE,$TITLE)
{
  return "<head>\n".
         "<meta http-equiv=\"Content-Type\" ".
	 "content=\"text/html; charset=".$CHARSET."\"/>\n".
	 "<meta http-equiv=\"Content-Script-Type\"".
	 " content=\"text/javascript\"/>\n".
	 "<meta name=\"author\" content=\"".$AUTHOR."\" />\n".
         "<meta name=\"keywords\" content=\"".$KEYWORDS."\" />\n".
         "<meta name=\"description\" content=\"".$DESCRIPTION."\" />\n".
         "<link rel=\"stylesheet\" type=\"text/css\"".
	 " href=\"".$STYLE."\" />\n".
         "<title>".$TITLE."</title>\n".
         "</head>\n\n";
}

function xhtml_begin_body()
{
  return "<body>\n";
}
 
function xhtml_end_body()
{
  return "</body>\n\n";
}

function xhtml_end()
{
  return "</html>";
}

function xhtml_ulist($LIST)
{
  $XHTML="<ul>\n";

  foreach($LIST as $I)
  {
    $XHTML=$XHTML."<li>".$I."</li>\n";
  }
  return $XHTML."</ul>\n\n";
}  

function xhtml_olist($LIST)
{
  $XHTML="<ol>\n";

  foreach($LIST as $I)
  {
    $XHTML=$XHTML."<li>".$I."</li>\n";
  }
  return $XHTML."</ol>\n\n";
}

/* MSX RULEZ */
?>
