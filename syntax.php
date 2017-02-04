<?php
if(!defined('DOKU_INC')) die();
require_once(DOKU_PLUGIN.'syntax.php');
class syntax_plugin_canonicalchinese extends DokuWiki_Syntax_Plugin {
  
  function getType() {
    return "substition";
  }
  
  function getAllowedTypes() {
    return array('container', 'formatting', 'substition', 'protected', 'disabled', 'paragraphs');
  }
  
  function getSort() {
    return 19;
  }
  function connectTo($mode) {
    $this->Lexer->addEntryPattern('\<nochinesecanonical\>(?=.*?\<\/nochinesecanonical\>)',$mode, 'plugin_canonicalchinese');
    $this->Lexer->addExitPattern('\<\/nochinesecanonical\>','plugin_canonicalchinese');
  }
  function handle($match, $state, $pos, Doku_Handler $handler) {
    if ($state == DOKU_LEXER_ENTER || $state == DOKU_LEXER_EXIT) {
      return '';
    } elseif ($state == DOKU_LEXER_UNMATCHED) {
      return $match;
    }
  }
  function render($mode, Doku_Renderer $R, $data) {
    $R->doc .= $data;
  }
}
?>
