<?php
/**
 * Comment Syntax plugin for DokuWiki; action component
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Satoshi Sahara <sahara.satoshi@gmail.com>
 */
class action_plugin_commentsyntax extends DokuWiki_Action_Plugin
{
    /**
     * Registers a callback function for a given event
     */
    public function register(Doku_Event_Handler $controller)
    {
        if ($this->getConf('toolbar_button')) {
            $controller->register_hook(
                'TOOLBAR_DEFINE', 'AFTER', $this, 'handleToolbar'
            );
        }
    }

    public function handleToolbar(Doku_Event $event)
    {
        $event->data[] = [
            'type' => 'toggleCommentBlock',
            'title' => $this->getLang('toolbar_title'),
            'icon' => DOKU_REL.'lib/plugins/commentsyntax/images/comment.png',
        ];
    }
}
