<?php

declare(strict_types=1);

namespace League\OpenAPIValidation\PSR7\Exception\Validation;

use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use League\OpenAPIValidation\Schema\Exception\SchemaMismatch;
use const JSON_PRETTY_PRINT;
use function is_scalar;
use function json_encode;
use function sprintf;

class InvalidParameter extends ValidationFailed
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /**
     * @param mixed $value
     *
     * @return InvalidParameter
     */
    public static function becauseValueDidNotMatchSchema(string $name, $value, SchemaMismatch $prev) : self
    {
        if (! is_scalar($value)) {
            $value = json_encode($value, JSON_PRETTY_PRINT);
        }

        $exception        = new self(sprintf("Parameter '%s' has invalid value '%s'", $name, $value), 0, $prev);
        $exception->name  = $name;
        $exception->value = (string) $value;

        return $exception;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function value() : string
    {
        return (string) $this->value;
    }
}
