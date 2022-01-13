<?php

namespace Adventures\LaravelBokun\GraphQL;

use InvalidArgumentException;

abstract class Query
{
    protected array $arguments = [];

    public function __construct(
        public string $fields
    ) {
    }

    final public function withArgument(string $name, mixed $value): self
    {
        if (! array_key_exists($name, $this->getValidInputs())) {
            throw new InvalidArgumentException("$name is no valid input argument for " . $this::class);
        }

        $type = $this->getValidInputs()[$name];

        if (! ((gettype($value) === $type) || (is_a($value, $type)))) {
            $foundType = gettype($value);
            if ($foundType === 'object') {
                $foundType = get_class($value);
            }

            throw new InvalidArgumentException("$name needs type $type, instead is of type " . $foundType);
        }

        $this->arguments[$name] = $value;

        return $this;
    }

    abstract public function getName(): string;

    abstract public function getValidInputs(): array;

    public function __toString(): string
    {
        $input = $this->serializeInputString($this->arguments);

        return $this->getName() . ' ( ' . $input . ' ) { ' . $this->fields . ' }';
    }

    protected function serializeInputString(array $input): string
    {
        $arguments = [];
        foreach ($input as $name => $value) {
            if (is_string($value)) {
                $value = json_encode($value);
            }
            $arguments[] = $name . ': ' . (string) $value;
        }

        return implode(',', $arguments);
    }
}
