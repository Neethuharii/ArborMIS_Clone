<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Countries;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CountryFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $countries = [
            'Afghanistan',
            'Albania',
            'Algeria',
            'Andorra',
            'Angola',
            'Armenia',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belize',
            'Benin',
            'Bhutan',
            'Bolivia',
            'Bosnia and Herzegovina',
            'Botswana',
            'Bulgaria',
            'Burkina Faso',
            'Burundi',
            'Cambodia',
            'Cameroon',
            'Cape Verde',
            'Central African Republic',
            'Chad',
            'Comoros',
            'Costa Rica',
            'Croatia',
            'Cuba',
            'Cyprus',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'Ecuador',
            'El Salvador',
            'Estonia',
            'Eswatini',
            'Ethiopia',
            'Fiji',
            'Gabon',
            'Gambia',
            'Georgia',
            'Ghana',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Guyana',
            'Haiti',
            'Honduras',
            'Iceland',
            'Iran',
            'Iraq',
            'Jamaica',
            'Jordan',
            'Kazakhstan',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Lesotho',
            'Liberia',
            'Libya',
            'Liechtenstein',
            'Lithuania',
            'North Macedonia',
            'Madagascar',
            'Malawi',
            'Maldives',
            'Mali',
            'Malta',
            'Marshall Islands',
            'Mauritania',
            'Mauritius',
            'Moldova',
            'Mongolia',
            'Montenegro',
            'Mozambique',
            'Myanmar',
            'Namibia',
            'Nepal',
            'Nicaragua',
            'Niger',
            'North Macedonia',
            'Panama',
            'Paraguay',
            'Rwanda',
            'Saint Lucia',
            'Saint Vincent and the Grenadines',
            'Samoa',
            'San Marino',
            'Sao Tome and Principe',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Sierra Leone',
            'Slovakia',
            'Slovenia',
            'Somalia',
            'Sudan',
            'Suriname',
            'Syria',
            'Tajikistan',
            'Tanzania',
            'Togo',
            'Trinidad and Tobago',
            'Tunisia',
            'Turkmenistan',
            'Uganda',
            'United Kingdom',
            'United States',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Zambia'
        ];

        foreach ($countries as $countryName) {
            $country = new Countries();
            $country->setCountryName($countryName);
            $manager->persist($country);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['country-fixture'];
    }
}
