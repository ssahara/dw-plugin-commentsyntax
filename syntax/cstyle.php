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
class syntax_plugin_commentsyntax_cstyle extends DokuWiki_Syntax_Plugin
{
    /** syntax type */ 
    public function getType()
    {
        return 'protected';
    }

    /** sort number used to determine priority of this mode */
    public function getSort()
    {
        return 8; // precedence of Doku_Parser_Mode_listblock priority (=10)
    }

    /**
     * Connect lookup pattern to lexer
     */
    protected $mode, $pattern;

    public function preConnect()
    {
        // syntax mode, drop 'syntax_' from class name
        $this->mode = substr(__CLASS__, 7);
        // syntax pattern
        $this->pattern = [
            1 => '[ \t]*\n?/\*(?=.*?\*/)',
            4 => '\*/',
            5 => '\s//(?:[^/\n]*|[^/\n]*/[^/\n]*)(?=\n)',
        ];
    }

    public function accepts($mode)
    {   // plugin may accept its own entry syntax
        if ($this->getConf('use_cstyle_nest') && $mode == $this->mode) return true;
        return parent::accepts($mode);
    }


    public function connectTo($mode)
    {
        $this->Lexer->addEntryPattern($this->pattern[1], $mode, $this->mode);

        if ($this->getConf('use_oneline_style')) {
            $this->Lexer->addSpecialPattern($this->pattern[5], $mode, $this->mode);
        }
    }

    public function postConnect()
    {
        $this->Lexer->addExitPattern($this->pattern[4], $this->mode);
    }

    /**
     * Handle the match
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        return false;
    }

    /**
     * Create output
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
        return true;
    }
}
