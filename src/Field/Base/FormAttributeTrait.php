<?php

declare(strict_types=1);

namespace Yiisoft\Form\Field\Base;

use InvalidArgumentException;
use Yiisoft\Form\FormModelInterface;
use Yiisoft\Form\Helper\HtmlForm;
use Yiisoft\Validator\Helper\RulesNormalizer;

/**
 * @psalm-import-type NormalizedRulesMap from RulesNormalizer
 * @psalm-import-type NormalizedRulesList from RulesNormalizer
 */
trait FormAttributeTrait
{
    private ?FormModelInterface $formModel = null;
    private string $formAttribute = '';

    /**
     * @psalm-var NormalizedRulesMap|null
     */
    private ?array $formModelValidationRules = null;

    final public function formAttribute(FormModelInterface $model, string $attribute): static
    {
        $new = clone $this;
        $new->formModel = $model;
        $new->formAttribute = $attribute;
        $new->formModelValidationRules = null;
        return $new;
    }

    final protected function getFormModel(): FormModelInterface
    {
        if ($this->formModel === null) {
            throw new InvalidArgumentException('Form model is not set.');
        }

        return $this->formModel;
    }

    /**
     * @psalm-return NormalizedRulesList
     */
    final protected function getFormAttributeValidationRules(): iterable
    {
        $this->formModelValidationRules ??= RulesNormalizer::normalize(null, $this->getFormModel());
        return $this->formModelValidationRules[$this->formAttribute] ?? [];
    }

    final protected function hasFormModelAndAttribute(): bool
    {
        return $this->formModel !== null && $this->formAttribute !== '';
    }

    final protected function getFormAttributeName(): string
    {
        return HtmlForm::getAttributeName($this->getFormModel(), $this->formAttribute);
    }

    final protected function getFormAttributeValue(): mixed
    {
        return HtmlForm::getAttributeValue($this->getFormModel(), $this->formAttribute);
    }

    final protected function getFormAttributeLabel(): string
    {
        return HtmlForm::getAttributeLabel($this->getFormModel(), $this->formAttribute);
    }

    final protected function getFormAttributeHint(): string
    {
        return HtmlForm::getAttributeHint($this->getFormModel(), $this->formAttribute);
    }

    final protected function getFormAttributePlaceholder(): ?string
    {
        $placeholder = $this
            ->getFormModel()
            ->getAttributePlaceholder($this->getFormAttributeName());
        return $placeholder === '' ? null : $placeholder;
    }

    final protected function getInputId(): string
    {
        return HtmlForm::getInputId($this->getFormModel(), $this->formAttribute);
    }

    final protected function getFirstError(): ?string
    {
        return $this
            ->getFormModel()
            ->getFormErrors()
            ->getFirstError($this->getFormAttributeName());
    }
}
