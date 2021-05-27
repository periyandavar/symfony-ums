<?php

namespace App\Entity\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class SalaryType extends Type
{
    const SALARY = 'salary';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        return "int";
    }

    public function getName()
    {
        return self::SALARY;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value * 100);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return ($value / 100);
    }
}

