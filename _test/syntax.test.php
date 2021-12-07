<?php

/**
 * DokuWiki Comment Syntax Plugin tests
 *
 * @group plugin_commentsyntax
 * @group plugins
 */
class plugin_commentsyntax_test extends DokuWikiTest
{
    protected $pluginsEnabled = array('commentsyntax');

    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();
      //TestUtils::rcopy(dirname(DOKU_CONF), dirname(__FILE__).'/conf');
    }

    public function setup() : void
    {
        global $conf;
        parent::setup();
        $conf ['plugin']['commentsyntax']['use_cstyle_nest']   = 1;
        $conf ['plugin']['commentsyntax']['use_oneline_style'] = 1;
        $conf ['plugin']['commentsyntax']['log_invalid_macro'] = 0;
    }

    // remove newlines from string
    private function normalizeLineEndings($s, $eol = '')
    {
        return str_replace(["\r", "\n"], $eol, $s);
    }

    private function getHTML($text)
    {
        $instructions = p_get_instructions($text);
        $xhtml = p_render('xhtml', $instructions, $info);
        return $this->normalizeLineEndings($xhtml);
    }

    /**
     * C-style comment syntax
     */
    function test_cstyle_syntax()
    {
        $text = "\nWiki /* comment out */ text\n";
        $expectHtml = '<p>Wiki text</p>';
        $this->assertEquals($expectHtml, $this->getHtml($text));

        $text = <<<'EOS'
              * item 1
            /** item 2  omit this line! */
              * item 3
            
            EOS;
        $expectHtml = '<ul>'
            .'<li class="level1"><div class="li"> item 1</div></li>'
            .'<li class="level1"><div class="li"> item 3</div></li>'
            .'</ul>';
        $this->assertEquals($expectHtml, $this->getHtml($text));

        // nested comment
        $text = <<<'EOS'
            /** item 1
            /** item 2  omit this line! */
              * item 3   */
              * item 4
            
            EOS;
        $expectHtml = '<ul>'
            .'<li class="level1"><div class="li"> item 4</div></li>'
            .'</ul>';
        $this->assertEquals($expectHtml, $this->getHtml($text));
    }

    /**
     * One line comment
     */
    function test_oneline_syntax()
    {
        $text = "\nWiki text // allow slash (/) in one line comment\n";
        $expectHtml = '<p>Wiki text</p>';
        $this->assertEquals($expectHtml, $this->getHtml($text));

        $text = "\nWiki //text// // allow slash (/) in one line comment\n";
        $expectHtml = '<p>Wiki <em>text</em></p>';
        $this->assertEquals($expectHtml, $this->getHtml($text));
    }
}
// vim:set fileencoding=utf-8 :
