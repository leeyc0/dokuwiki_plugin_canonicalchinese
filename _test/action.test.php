<?php
/**
 * Tests to ensure creole syntax is correctly processed
 * and creates expected XHTML output
 *
 * @group plugin_canonicalchinese
 * @group plugins
 */

class plugin_canonicalchinese_action_test extends DokuWikiTest {
   protected $pluginsEnabled = array('canonicalchinese');

   public function test_canonicalchinese_replace() {
     global $conf;
     $data[] = array("", '十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學教育的好書');
     $expected_output_enabled = '十萬個爲甚麼<nochinesecanonical>真</nochinesecanonical>的是科學敎育的好書';
     $expected_output_disabled = '十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學教育的好書';
     $event = new Doku_Event("IO_WIKIPAGE_WRITE", $data);
     $action_class = new action_plugin_canonicalchinese();

     # test with conf disabled
     $action_class->replace_canonical_chinese($event);
     $this->assertEquals($expected_output_disabled, $data[0][1]);

     # test with conf enabled
     $conf['plugin']['canonicalchinese']['enabled'] = true;
     $action_class->replace_canonical_chinese($event);
     $this->assertEquals($expected_output_enabled, $data[0][1]);
  }
}
?>
