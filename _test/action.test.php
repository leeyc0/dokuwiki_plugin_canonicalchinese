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

  public function test_default_config() {
    $action_class = new action_plugin_canonicalchinese();
    $this->assertFalse($action_class->getConf('enabled'), "plugin should be disabled by default");
  }

  public function test_event_handler() {
    $action_class_reflection = new ReflectionClass('action_plugin_canonicalchinese');
    $dictionary = $action_class_reflection->getProperty("dictionary");
    $dictionary->setAccessible(true);
    global $conf;
    $conf['plugin']['canonicalchinese']['enabled'] = true;
    $input_string = "真裡洩為教";
    $expected_string = "眞裏泄爲敎";
    $this->assertEquals(mb_strlen($input_string), sizeof($dictionary->getValue(new action_plugin_canonicalchinese())), "make sure we did not forget to modify test cases for any dict changes");
    $event_data = array(array("fake_path", $input_string, false), false, "fake_page", false);
    trigger_event("IO_WIKIPAGE_WRITE", $event_data);
    $this->assertEquals($expected_string, $event_data[0][1], "characters should convert to canonical form upon saving");
  }

  public function canonicalchinese_replace_provider()
  {
    return array(
      array(true,
        '十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學教育的好書 真眞<nochinesecanonical>科學教育</nochinesecanonical>的好書',
        '十萬個爲甚麼<nochinesecanonical>真</nochinesecanonical>的是科學敎育的好書 眞眞<nochinesecanonical>科學教育</nochinesecanonical>的好書'
      ),
      array(false,
        '十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學教育的好書 真眞<nochinesecanonical>科學教育</nochinesecanonical>的好書',
        '十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學教育的好書 真眞<nochinesecanonical>科學教育</nochinesecanonical>的好書'
      ),
      array(true,
        '十萬個為甚麼<nochinesecanonical>真</nochinesecanonical>的是科學教育的好書 真眞<nochinesecanonical>科學教育 教育的好書',
        '十萬個爲甚麼<nochinesecanonical>真</nochinesecanonical>的是科學敎育的好書 眞眞<nochinesecanonical>科學教育 教育的好書'
      )
    );
  }
  
  /**
   * @dataProvider canonicalchinese_replace_provider
   */
  public function test_canonicalchinese_replace($enabled, $inputs_string, $expected_string) {
    global $conf;
    $conf['plugin']['canonicalchinese']['enabled'] = $enabled;
    $data[] = array("", $inputs_string);
    $event = new Doku_Event("IO_WIKIPAGE_WRITE", $data);
    $action_class = new action_plugin_canonicalchinese();
    $action_class->replace_canonical_chinese($event);
    $enabled_str = $enabled ? 'enabled' : 'disabled';
    $this->assertEquals($expected_string, $data[0][1], "convert to canonical form: $enabled_str");
  }
}
?>
