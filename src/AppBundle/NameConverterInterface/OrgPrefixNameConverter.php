<?php

namespace AppBundle\NameConverterInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class OrgPrefixNameConverter implements NameConverterInterface
{
    public function normalize($propertyName)
    {
        return 'org_'.$propertyName;
    }

    public function denormalize($propertyName)
    {
        // remove org_ prefix
        return 'org_' === substr($propertyName, 0, 4) ? substr($propertyName, 4) : $propertyName;
    }
}