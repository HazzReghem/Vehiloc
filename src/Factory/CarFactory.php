<?php

namespace App\Factory;

use App\Entity\Car;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Car>
 */
final class CarFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Car::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'dailyPrice' => self::faker()->randomFloat(2, 20, 200),
            'description' => self::faker()->text(),
            'manual' => self::faker()->boolean(),
            'monthlyPrice' => self::faker()->randomFloat(2, 300, 2500),
            'name' => self::faker()->randomElement(['Peugeot 206', 'Toyota Corola', 'BMW X5', 'Audi A3', 'Tesla Model S']),
            'seatNumber' => self::faker()->numberBetween(2, 7),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Car $car): void {})
        ;
    }
}
