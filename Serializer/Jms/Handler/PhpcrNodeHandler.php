<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2015 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\ResourceRestBundle\Serializer\Jms\Handler;

use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Context;
use PHPCR\NodeInterface;

/**
 * Handle PHPCR node serialization.
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class PhpcrNodeHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return array(
            array(
                'event' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => 'PHPCR\NodeInterface',
                'method' => 'serializePhpcrNode',
            ),
        );
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param NodeInterface            $nodeInterface
     * @param array                    $type
     * @param Context                  $context
     */
    public function serializePhpcrNode(
        JsonSerializationVisitor $visitor,
        NodeInterface $node,
        array $type,
        Context $context
    ) {
        $res = array();

        foreach ($node->getProperties() as $name => $property) {
            $res[$name] = $property->getValue();
        }

        return $res;
    }
}
