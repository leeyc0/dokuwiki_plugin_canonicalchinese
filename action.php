<?php

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_canonicalchinese extends DokuWiki_Action_Plugin {
  private $dictionary = array();
  
  function __construct() {
    // the first is canonical form, the second is common form
    $this->dictionary[] = array("眞", "真");
    $this->dictionary[] = array("裏", "裡");
    $this->dictionary[] = array("泄", "洩");
    $this->dictionary[] = array("爲", "為");
    $this->dictionary[] = array("敎", "教");
  }
  
  function register(Doku_Event_Handler $controller) {
    $controller->register_hook('IO_WIKIPAGE_WRITE', 'BEFORE', $this, 'replace_canonical_chinese');
  }
  
  function replace_canonical_chinese (Doku_Event &$event) {
    $str = $event->data[0][1];
    $outputstr = "";
    $offset = 0;
    $replace = true;
    $parsing = true;
    
    if (!$this->getConf('enabled')) {
      return;
    }
    
    while ($parsing) {
      if ($replace) {
        $offset2 = strpos($str, "<nochinesecanonical>", $offset);
        if ($offset2 === false) {
          $tmpstr = substr($str,$offset);
          $parsing = false;
        } else {
          $tmpstr = substr($str,$offset,$offset2-$offset);
        }
        foreach ($this->dictionary as $pair) {
          $regex = "/".preg_quote($pair[1], "/")."/ms";
          $tmpstr = preg_replace($regex, $pair[0], $tmpstr, -1);
        }
        $outputstr .= $tmpstr;
        $offset = $offset2;
        $replace = false;
      } else {
        $offset2 = strpos($str, "</nochinesecanonical>", $offset);
        if ($offset2 === false) {
          $tmpstr = substr($str,$offset);
          $parsing = false;
        } else {
          $tmpstr = substr($str,$offset,$offset2-$offset);
        }
        $outputstr .= $tmpstr;
        $offset = $offset2;
        $replace = true;
      }
    }
    
    $event->data[0][1] = $outputstr;
  }
}

?>
