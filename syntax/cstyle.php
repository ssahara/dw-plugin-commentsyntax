<?php
/**
 * Comment Syntax support for DokuWiki; plugin type extension
 * 'C' style comments syntax component
 * Supports 'C' style comment syntax in Wiki source text.
 * The comment does not appear in the page, but visible when you edit the page.
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
class syntax_plugin_commentsyntax_cstyle extends DokuWiki_Syntax_Plugin {

    protected $pluginMode;
    protected $entry_pattern = '\s/\*(?=.*?\*/)';
    protected $exit_pattern  = '\*/';

    public function __construct() {
        $this->pluginMode = substr(get_class($this), 7); // drop 'syntax_'
    }

    public function getType(){ return 'protected'; }
    public function getSort(){ return 9; } // precedence of Doku_Parser_Mode_listblock priority (=10)
    // override default accept() method to allow nesting - ie, to get the plugin accept its own entry syntax
    public function accepts($mode) {
        if ($this->getConf('use_cstyle_nest') && $mode == $this->pluginMode) return true;
        return parent::accepts($mode);
    }

    public function connectTo($mode) {
        $this->Lexer->addEntryPattern($this->entry_pattern, $mode, $this->pluginMode);
    }
    public function postConnect() {
        $this->Lexer->addExitPattern($this->exit_pattern, $this->pluginMode);
    }

    public function handle($match, $state, $pos, Doku_Handler $handler) { return ''; }
    public function render($mode, Doku_Renderer $renderer, $data) { return true; }
}
