<?php
/**
 * Comment Syntax support for DokuWiki; [TEST] SCRIPTIO CONTINUA
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 *
 * remove new line chars (\n) inside a multiline paragraph.
 * useful when writing multiline paragraphs in languages like Japanese
 * that white space is not necessary between words and sentences.
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class syntax_plugin_commentsyntax_continua extends DokuWiki_Syntax_Plugin {

    protected $pluginMode;
    protected $match_pattern = '\b\n(?!\n)';  // '(?<!\n)\n(?\n])' does not work

    public function __construct() {
        $this->pluginMode = substr(get_class($this), 7); // drop 'syntax_'
    }

    public function getType(){ return 'substition'; }
    public function getSort(){ return 369; }

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern($this->match_pattern, $mode, $this->pluginMode);
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) {
        return '';
    }
    public function render($format, Doku_Renderer $renderer, $data) {
        return true;
    }
}
