<?php
/**
 * Tests to ensure creole syntax is correctly processed
 * and creates expected XHTML output
 *
 * @group plugin_canonicalchinese
 * @group plugins
 */

class plugin_canonicalchinese_syntax_test extends DokuWikiTest {
   protected $pluginsEnabled = array('canonicalchinese');

   public function test_nocanonicalchinese_tag() {
     $info = array();
     $instructions = p_get_instructions('十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學敎育的好書');
     $expected_output = "\n<p>\n十萬個為甚麼真的是科學敎育的好書\n</p>\n";
     $xhtml = p_render('xhtml', $instructions, $info);
     $this->assertEquals($expected_output, $xhtml);
  }
}
?>
