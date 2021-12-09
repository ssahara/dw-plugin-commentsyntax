<?php
/**
 * Comment Syntax support for DokuWiki; preventive syntax component
 * preventive macro comment in Wiki source text.
 * 
 * Assume invalid macro directive caused by a typo error as a source comment
 * in the page, eg. "~~NO CACHE~~" (correct sytax is "~~NOCACHE~~").
 * You may disable the directive temporary by intentional typo.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
class syntax_plugin_commentsyntax_preventive extends DokuWiki_Syntax_Plugin
{
    /** syntax type */
    public function getType()
    {
        return 'substition';
    }

    /** sort number used to determine priority of this mode */
    public function getSort()
    {
        return 9999; // very low priority
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
            5 => '~~[^\n~]+~~',
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
        global $ID, $ACT;
        if ($ACT == 'preview') {
            return $data = $match;
        } else if ($this->getConf('log_invalid_macro')) {
            error_log($this->mode.': match='.$match.' |'.$ID);
        }
        return false;
    }

    /**
     * Create output
     */
    public function render($format, Doku_Renderer $renderer, $data)
    {
        global $ACT;
        if ($format == 'xhtml' && $ACT == 'preview') {
            $renderer->doc .= $renderer->_xmlEntities($data);
        }
        return true;
    }
}
