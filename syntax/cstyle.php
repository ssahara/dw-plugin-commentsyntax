<?php
/**
 * Comment Syntax plugin for DokuWiki; cstyle syntax component
 *
 * A "comment" does not appear in the page, but visible when you edit the page.
 * Supports both C style multi-line comments and one-line C++ style comments
 *
 * NOTE:
 * One-line comments preceded by two slashes (//), may interfere with the markup
 * for italics. The use of italic formatting markup will be restricted so that
 * it can not go over next line.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */

// must be run within DokuWiki
if(!defined('DOKU_INC')) die();

class syntax_plugin_commentsyntax_cstyle extends DokuWiki_Syntax_Plugin {

    protected $mode;
    protected $pattern = array(
            1 => '[ \t]*\n?/\*(?=.*?\*/)',
            4 => '\*/',
            5 => '\s//(?:[^/\n]*|[^/\n]*/[^/\n]*)(?=\n)',
    );

    function __construct() {
        // syntax mode, drop 'syntax_' from class name
        $this->mode = substr(get_class($this), 7);
    }

    function getType(){ return 'protected'; }
    function getSort(){
        return 8; // precedence of Doku_Parser_Mode_listblock priority (=10)
    }

    function accepts($mode) {
        if ($this->getConf('use_cstyle_nest') && $mode == $this->mode) return true;
        return parent::accepts($mode);
    }

    /**
     * Connect lookup pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addEntryPattern($this->pattern[1], $mode, $this->mode);

        if ($this->getConf('use_oneline_style')) {
            $this->Lexer->addSpecialPattern($this->pattern[5], $mode, $this->mode);
        }
    }
    function postConnect() {
        $this->Lexer->addExitPattern($this->pattern[4], $this->mode);
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        return false;
    }

    /**
     * Create output
     */
    function render($format, Doku_Renderer $renderer, $data) {
        return true;
    }
}
