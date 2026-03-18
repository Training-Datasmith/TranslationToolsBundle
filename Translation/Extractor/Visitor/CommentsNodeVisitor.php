<?php

declare(strict_types=1);
/**
 * This file is authored by PrestaShop SA and Contributors <contact@prestashop.com>
 *
 * It is distributed under MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PrestaShop\TranslationToolsBundle\Translation\Extractor\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * Extracts comment information
 */
class CommentsNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var array
     */
    protected $comments = [];

    /**
     * TranslationNodeVisitor constructor.
     */
    public function __construct(protected $file)
    {
    }

    public function leaveNode(Node $node): void
    {
        $this->tryExtractComments($node);
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    private function tryExtractComments(Node $node): void
    {
        $comments = $node->getAttribute('comments');

        if (is_array($comments)) {
            foreach ($comments as $comment) {
                $this->comments[] = [
                    'line' => $comment->getLine(),
                    'file' => $this->file,
                    'comment' => trim((string) $comment->getText(), " \t\n\r\0\x0B/*"),
                ];
            }
        }
    }
}
