<?php
/**
 * Comment Syntax support for DokuWiki; plugin type extension
 * preventive macro comment in Wiki source text.
 * Sometimes you may want to disable control macro (eg. NOTOC, NOCACHE).
 * if white space put between '~~' and macro word,
 * then the marco is diseabled, but the text not show in the page.
*
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_commentsyntax_preventive extends DokuWiki_Syntax_Plugin {

    protected $pluginMode;
    protected $match_pattern = '~~\B.*?~~';

    public function __construct() {
        $this->pluginMode = substr(get_class($this), 7); // drop 'syntax_'
    }

    public function getType(){ return 'substition'; }
    public function getSort(){ return 369; } // very low priority

    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern($this->match_pattern, $mode, $this->pluginMode);
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) { return ''; }
    public function render($mode, Doku_Renderer $renderer, $data) { return true; }
}
