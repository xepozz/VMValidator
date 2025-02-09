<?php

namespace RMValidator\Attributes\PropertyAttributes\Numbers;

use Attribute;
use RMValidator\Exceptions\NotNullableException;
use RMValidator\Attributes\Base\IAttribute;
use RMValidator\Exceptions\BiggerException;
use RMValidator\Exceptions\NotANumberException;
use RMValidator\Attributes\Base\BaseAttribute;


#[Attribute(Attribute::IS_REPEATABLE | Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_CLASS_CONSTANT | Attribute::TARGET_PARAMETER)]
final class BiggerAttribute extends BaseAttribute implements IAttribute
{
    public function __construct(public float $biggerThan, protected ?string $errorMsg = null, protected ?string $customName = null, protected ?bool $nullable = false)
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
        if (!is_numeric($value)) {
            throw new NotANumberException($value);
        }
        if (!is_numeric($this->biggerThan)) {
            throw new NotANumberException();
        }
        if ($value <= $this->biggerThan) {
            throw new BiggerException($value, $this->biggerThan);
        }
    }
}