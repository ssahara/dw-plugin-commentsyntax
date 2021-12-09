<?php
/**
 * Comment Syntax support for DokuWiki; html comment syntax component
 * allows HTML comments to be retained in the output. The HTML comment will not
 * rendered by the browser, but can be viewed with “View source code” command.
 *
 * Note: adopted original HTML Comment Plugin by Christopher Arndt
 *       https://www.dokuwiki.org/plugin:htmlcomment
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christopher Arndt <chris@chrisarndt.de>
 * @author     Danny Lin <danny0838@gmail.com>
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
class syntax_plugin_commentsyntax_htmlcomment extends DokuWiki_Syntax_Plugin
{
    /** syntax type */
    public function getType()
    {
        return 'substition';
    }

    /** sort number used to determine priority of this mode */
    public function getSort()
    {
        return 325;
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
            5 => '<\!--.*?-->',
        ];
    }

    public function connectTo($mode)
    {
        $this->Lexer->addSpecialPattern($this->pattern[5], $mode, $this->mode);
    }

    /**
     * Handle the match
     */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        if ($state == DOKU_LEXER_SPECIAL) {
             // strip <!-- from start and --> from end
            return array($state, substr($match, 4, -3));
        }
        return false;
    }

    /**
     * Create output
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
        if ($format == 'xhtml') {
            list($state, $comment) = $data;
            if ($state == DOKU_LEXER_SPECIAL) {
                $renderer->doc .= '<!--'.$comment.'-->';
            }
            return true;
        }
        return true;
    }
}
