<?php

declare(strict_types=1);

namespace MsgPhp\Eav\Infra\Uuid;

use MsgPhp\Domain\Infra\Uuid\DomainId;
use MsgPhp\Eav\AttributeIdInterface;

/**
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
final class AttributeId extends DomainId implements AttributeIdInterface
{
}
