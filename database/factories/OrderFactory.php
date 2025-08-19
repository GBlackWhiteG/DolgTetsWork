<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    private array $items = [
        'Ноутбук',
        'Смартфон',
        'Телевизор',
        'Наушники',
        'Холодильник',
        'Стиральная машина',
        'Пылесос',
        'Игровая приставка',
        'Кофемашина',
        'Монитор',
        'Принтер',
        'Смарт-часы',
        'Планшет',
        'Фотоаппарат',
        'Велосипед',
        'Электрочайник',
        'Мультиварка',
        'Коляска',
        'Микроволновка',
        'Электросамокат',
    ];

    private array $brands = [
        'Samsung',
        'Apple',
        'Xiaomi',
        'Sony',
        'LG',
        'Bosch',
        'Lenovo',
        'Asus',
        'Acer',
        'Dyson',
        'Canon',
        'Nikon',
        'Philips',
        'HP',
        'Huawei',
        'Indesit',
        'Redmond',
        'Panasonic',
        'Delonghi',
        'Stels',
    ];

    private array $modifiers = [
        'Pro',
        'Ultra',
        'Max',
        'Mini',
        'Lite',
        '2024',
        'Plus',
        'Air',
        'Prime',
        'Series X',
        'One',
        'Advance',
        'Smart',
        'Digital',
        'Compact',
        'Energy',
        'Next',
        'Flex',
        'Go',
        'Infinity',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement($this->items) . ' ' . $this->faker->randomElement($this->brands) . ' ' . $this->faker->randomElement($this->modifiers),
            'description' => $this->faker->paragraphs(2, true),
            'delivery_date' => date('Y-m-d', mktime(0, 0, 0, date('m') + random_int(1, 10), date('d') + random_int(1, 30), date('Y') + random_int(0, 2))),
            'status' => 'Allowed',
        ];
    }

    public function prohibited(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Prohibited',
        ]);
    }
}
