<?php

declare(strict_types=1);

namespace Yiisoft\Form\Tests\TestSupport\Form;

use Yiisoft\Form\FormModel;
use Yiisoft\Form\Attribute\SkipCollection;
use Yiisoft\Validator\Rule\Email;
use Yiisoft\Validator\Rule\Length;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\RulesProviderInterface;

class LoginForm extends FormModel implements RulesProviderInterface
{
    private static ?string $extraField = null;
    #[SkipCollection]
    private ?string $skipField = null;
    private ?string $login = null;
    private ?string $password = null;
    private bool $rememberMe = false;

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRememberMe(): bool
    {
        return $this->rememberMe;
    }

    public function login(string $value): void
    {
        $this->login = $value;
    }

    public function password(string $value): void
    {
        $this->password = $value;
    }

    public function rememberMe(bool $value): void
    {
        $this->rememberMe = $value;
    }

    public function getAttributeHints(): array
    {
        return [
            'login' => 'Write your id or email.',
            'password' => 'Write your password.',
        ];
    }

    public function getAttributeLabels(): array
    {
        return [
            'login' => 'Login:',
            'password' => 'Password:',
            'rememberMe' => 'remember Me:',
        ];
    }

    public function getAttributePlaceholders(): array
    {
        return [
            'login' => 'Type Usernamer or Email.',
            'password' => 'Type Password.',
        ];
    }

    public function getRules(): array
    {
        return [
            'login' => $this->loginRules(),
            'password' => $this->passwordRules(),
        ];
    }

    private function loginRules(): array
    {
        return [
            new Required(),
            new Length(min: 4, max: 40, lessThanMinMessage: 'Is too short.', greaterThanMaxMessage: 'Is too long.'),
            new Email(),
        ];
    }

    private function passwordRules(): array
    {
        return [
            new Required(),
            new Length(min: 8, lessThanMinMessage: 'Is too short.'),
        ];
    }
}
