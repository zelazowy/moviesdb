<?php declare(strict_types=1);

namespace App\ValueObject;

class CountryValueObject
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $flag;

    public function __construct(string $code, string $name, string $flag)
    {

        $this->code = $code;
        $this->name = $name;
        $this->flag = $flag;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFlag(): string
    {
        return $this->flag;
    }
}
