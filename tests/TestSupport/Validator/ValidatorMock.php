<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Validator;

use Yiisoft\Validator\Result;
use Yiisoft\Validator\ValidationContext;
use Yiisoft\Validator\Validator;
use Yiisoft\Validator\ValidatorInterface;

final class ValidatorMock implements ValidatorInterface
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function validate(
        mixed $data,
        callable|iterable|object|string|null $rules = null,
        ?ValidationContext $context = null
    ): Result {
        return $this->validator->validate($data, $rules, $context);
    }
}
