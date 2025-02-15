<?php

namespace RMValidator\Attributes\PropertyAttributes\Global;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\EqualException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class EqualAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public mixed $expected, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false)
    {
        parent::__construct($errorMsg, $customName, $nullable);
    }

    public function validate(mixed $value) : void
    {
        if ($value === null) {
            if (!$this->checkNullable($value)) {
                throw new NotNullableException();
            }
            return;
        }
        if ($value != $this->expected) {
            throw new EqualException($value, $this->expected);
        }
    }
}