<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bb;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем или создаем пользователя для автомобилей
        $user = User::firstOrCreate(
            ['email' => 'admin@carhut.ru'],
            [
                'name' => 'CarHut Admin',
                'password' => bcrypt('password')
            ]
        );

        $cars = [
            // AUDI
            ['Audi A4 2023', 'Премиальный седан с полным приводом, 2.0 TFSI, 252 л.с., АКПП, кожаный салон, навигация, камера заднего вида', 3200000],
            ['Audi A6 2023', 'Бизнес-седан, 3.0 TFSI, 340 л.с., quattro, пакет S-line, массажная система сидений', 4800000],
            ['Audi Q5 2023', 'Премиальный кроссовер, 2.0 TDI, 190 л.с., полный привод, панорамная крыша, адаптивный круиз-контроль', 4200000],
            ['Audi Q7 2023', 'Большой премиальный внедорожник, 3.0 TDI, 249 л.с., 7 мест, пневмоподвеска, матричные фары', 6200000],
            ['Audi A8 2023', 'Флагманский седан, 4.0 TFSI, 460 л.с., задний привод, массажные кресла, система Bang & Olufsen', 8500000],
            ['Audi TT 2023', 'Спортивное купе, 2.0 TFSI, 245 л.с., quattro, спортивный пакет, карбоновая отделка', 3800000],
            ['Audi RS6 2023', 'Спортивный универсал, 4.0 TFSI, 600 л.с., полный привод, керамические тормоза, карбон', 12000000],
            ['Audi e-tron 2023', 'Электрический кроссовер, 408 л.с., запас хода 436 км, быстрая зарядка, виртуальные зеркала', 5500000],

            // BMW
            ['BMW 3 Series 2023', 'Спортивный седан, 2.0 Turbo, 258 л.с., задний привод, M Sport пакет, кожаный салон', 3500000],
            ['BMW 5 Series 2023', 'Бизнес-седан, 3.0 Turbo, 340 л.с., xDrive, пакет Luxury, массажные сиденья, проекционный дисплей', 5200000],
            ['BMW X3 2023', 'Компактный кроссовер, 2.0 Turbo, 252 л.с., полный привод, панорамная крыша, Harman Kardon', 4200000],
            ['BMW X5 2023', 'Премиальный внедорожник, 3.0 Turbo, 340 л.с., xDrive, 7 мест, пневмоподвеска, лазерные фары', 6500000],
            ['BMW X7 2023', 'Флагманский внедорожник, 4.4 Turbo, 530 л.с., полный привод, 7 мест, VIP-пакет задних сидений', 9500000],
            ['BMW M3 2023', 'Спортивный седан, 3.0 Turbo, 510 л.с., задний привод, М пакет, карбон, керамические тормоза', 8500000],
            ['BMW M5 2023', 'Суперседан, 4.4 Turbo, 600 л.с., полный привод, М пакет Competition, карбоновая отделка', 12000000],
            ['BMW iX 2023', 'Электрический кроссовер, 523 л.с., запас хода 630 км, быстрая зарядка, панорамная крыша', 7000000],

            // MERCEDES-BENZ
            ['Mercedes C-Class 2023', 'Премиальный седан, 2.0 Turbo, 258 л.с., задний привод, AMG Line, MBUX система', 3800000],
            ['Mercedes E-Class 2023', 'Бизнес-седан, 3.0 Turbo, 367 л.с., 4MATIC, пакет AMG, массажные сиденья, Burmester', 5500000],
            ['Mercedes S-Class 2023', 'Флагманский седан, 4.0 Turbo, 496 л.с., полный привод, задние VIP-сиденья, Magic Body Control', 11000000],
            ['Mercedes GLE 2023', 'Премиальный внедорожник, 3.0 Turbo, 367 л.с., 4MATIC, 7 мест, E-Active Body Control', 6800000],
            ['Mercedes GLS 2023', 'Большой внедорожник, 4.0 Turbo, 557 л.с., полный привод, 7 мест, массажные сиденья всех рядов', 10500000],
            ['Mercedes AMG GT 2023', 'Спортивное купе, 4.0 V8, 585 л.с., задний привод, AMG пакет, карбон, керамические тормоза', 15000000],
            ['Mercedes G-Class 2023', 'Легендарный внедорожник, 4.0 Turbo, 585 л.с., полный привод, блокировки, пневмоподвеска', 18000000],
            ['Mercedes EQS 2023', 'Электрический седан, 523 л.с., запас хода 770 км, гиперакран, MBUX Hyperscreen', 9000000],

            // FORD
            ['Ford Focus 2023', 'Компактный хэтчбек, 1.5 EcoBoost, 150 л.с., МКПП, пакет ST-Line, камера заднего вида', 1800000],
            ['Ford Mondeo 2023', 'Семейный седан, 2.0 EcoBoost, 245 л.с., АКПП, полный привод, пакет Titanium', 2800000],
            ['Ford Explorer 2023', 'Большой внедорожник, 3.0 EcoBoost, 365 л.с., полный привод, 7 мест, панорамная крыша', 4500000],
            ['Ford Mustang 2023', 'Спортивное купе, 5.0 V8, 450 л.с., МКПП, пакет GT, карбон, спортивная выхлопная система', 4200000],
            ['Ford F-150 2023', 'Пикап, 3.5 EcoBoost, 400 л.с., полный привод, пакет Raptor, внедорожная подвеска', 5500000],
            ['Ford Edge 2023', 'Средний кроссовер, 2.0 EcoBoost, 250 л.с., полный привод, пакет Titanium, массажные сиденья', 3200000],

            // TOYOTA
            ['Toyota Camry 2023', 'Семейный седан, 2.5 Hybrid, 218 л.с., CVT, пакет XLE, камера 360°, адаптивный круиз', 2800000],
            ['Toyota RAV4 2023', 'Компактный кроссовер, 2.5 Hybrid, 219 л.с., полный привод, пакет Adventure, панорамная крыша', 3200000],
            ['Toyota Land Cruiser 2023', 'Большой внедорожник, 4.6 V8, 309 л.с., полный привод, 7 мест, блокировки, пневмоподвеска', 6500000],
            ['Toyota Highlander 2023', 'Средний внедорожник, 3.5 V6, 295 л.с., полный привод, 7 мест, пакет Platinum', 4200000],
            ['Toyota Corolla 2023', 'Компактный седан, 1.8 Hybrid, 122 л.с., CVT, пакет XSE, камера заднего вида, Apple CarPlay', 2000000],
            ['Toyota Prius 2023', 'Гибридный хэтчбек, 1.8 Hybrid, 122 л.с., CVT, пакет Prime, запас хода на электричестве 40 км', 2500000],

            // VOLKSWAGEN
            ['Volkswagen Golf 2023', 'Компактный хэтчбек, 1.5 TSI, 150 л.с., АКПП, пакет R-Line, цифровая приборная панель', 2200000],
            ['Volkswagen Passat 2023', 'Семейный седан, 2.0 TSI, 220 л.с., АКПП, полный привод, пакет Elegance, массажные сиденья', 3200000],
            ['Volkswagen Tiguan 2023', 'Компактный кроссовер, 2.0 TSI, 220 л.с., полный привод, 7 мест, пакет R-Line, панорамная крыша', 3500000],
            ['Volkswagen Touareg 2023', 'Премиальный внедорожник, 3.0 TDI, 286 л.с., полный привод, пакет Excellence, пневмоподвеска', 5500000],
            ['Volkswagen Arteon 2023', 'Премиальный фастбек, 2.0 TSI, 280 л.с., полный привод, пакет R-Line, массажные сиденья', 4200000],
            ['Volkswagen ID.4 2023', 'Электрический кроссовер, 204 л.с., запас хода 520 км, быстрая зарядка, панорамная крыша', 3800000],

            // PORSCHE
            ['Porsche 911 2023', 'Спортивное купе, 3.0 Turbo, 385 л.с., задний привод, пакет Sport Chrono, карбон, керамические тормоза', 12000000],
            ['Porsche Cayenne 2023', 'Премиальный внедорожник, 3.0 Turbo, 340 л.с., полный привод, пакет S, пневмоподвеска, массажные сиденья', 8500000],
            ['Porsche Macan 2023', 'Компактный кроссовер, 2.0 Turbo, 265 л.с., полный привод, пакет S, спортивная подвеска', 5500000],
            ['Porsche Panamera 2023', 'Премиальный седан, 4.0 Turbo, 550 л.с., полный привод, пакет Turbo S, массажные сиденья, Burmester', 15000000],
            ['Porsche Taycan 2023', 'Электрический седан, 530 л.с., запас хода 450 км, быстрая зарядка, пакет Turbo, карбон', 11000000],

            // NISSAN
            ['Nissan Altima 2023', 'Семейный седан, 2.5, 188 л.с., CVT, пакет Platinum, массажные сиденья, камера 360°', 2500000],
            ['Nissan Rogue 2023', 'Компактный кроссовер, 2.5, 181 л.с., CVT, полный привод, пакет Platinum, панорамная крыша', 2800000],
            ['Nissan Pathfinder 2023', 'Большой внедорожник, 3.5 V6, 284 л.с., полный привод, 7 мест, пакет Platinum, массажные сиденья', 4200000],
            ['Nissan GT-R 2023', 'Спортивное купе, 3.8 V6 Twin Turbo, 565 л.с., полный привод, пакет Nismo, карбон, керамические тормоза', 12000000],
            ['Nissan Leaf 2023', 'Электрический хэтчбек, 214 л.с., запас хода 385 км, быстрая зарядка, пакет e+', 2800000],

            // HYUNDAI
            ['Hyundai Sonata 2023', 'Семейный седан, 2.5 Turbo, 290 л.с., АКПП, пакет Limited, массажные сиденья, камера 360°', 2800000],
            ['Hyundai Tucson 2023', 'Компактный кроссовер, 2.5 Turbo, 281 л.с., полный привод, пакет Limited, панорамная крыша', 3200000],
            ['Hyundai Santa Fe 2023', 'Средний внедорожник, 2.5 Turbo, 281 л.с., полный привод, 7 мест, пакет Calligraphy, массажные сиденья', 3800000],
            ['Hyundai Palisade 2023', 'Большой внедорожник, 3.8 V6, 291 л.с., полный привод, 8 мест, пакет Calligraphy, массажные сиденья всех рядов', 4500000],
            ['Hyundai IONIQ 5 2023', 'Электрический кроссовер, 320 л.с., запас хода 480 км, быстрая зарядка, панорамная крыша', 3500000],

            // PEUGEOT
            ['Peugeot 308 2023', 'Компактный хэтчбек, 1.6 Turbo, 180 л.с., АКПП, пакет GT, цифровая приборная панель, массажные сиденья', 2200000],
            ['Peugeot 508 2023', 'Премиальный седан, 1.6 Turbo, 225 л.с., АКПП, пакет GT, массажные сиденья, камера 360°', 3200000],
            ['Peugeot 3008 2023', 'Компактный кроссовер, 1.6 Turbo, 180 л.с., полный привод, пакет GT, панорамная крыша', 2800000],
            ['Peugeot 5008 2023', 'Средний внедорожник, 1.6 Turbo, 180 л.с., полный привод, 7 мест, пакет GT, массажные сиденья', 3500000],

            // BENTLEY
            ['Bentley Continental GT 2023', 'Роскошное купе, 6.0 W12, 635 л.с., полный привод, пакет Mulliner, массажные сиденья, Naim аудио', 25000000],
            ['Bentley Bentayga 2023', 'Роскошный внедорожник, 6.0 W12, 635 л.с., полный привод, пакет Mulliner, массажные сиденья всех рядов', 28000000],
            ['Bentley Flying Spur 2023', 'Роскошный седан, 6.0 W12, 635 л.с., полный привод, пакет Mulliner, задние VIP-сиденья, Naim', 26000000],

            // JEEP
            ['Jeep Wrangler 2023', 'Внедорожник, 3.6 V6, 285 л.с., полный привод, блокировки, съемная крыша, пакет Rubicon', 4200000],
            ['Jeep Grand Cherokee 2023', 'Премиальный внедорожник, 5.7 V8, 360 л.с., полный привод, пакет Summit, массажные сиденья, пневмоподвеска', 5500000],
            ['Jeep Cherokee 2023', 'Компактный кроссовер, 3.2 V6, 271 л.с., полный привод, пакет Trailhawk, внедорожная подвеска', 3200000],

            // ДОПОЛНИТЕЛЬНЫЕ МАРКИ
            // LEXUS
            ['Lexus ES 2023', 'Премиальный седан, 3.5 V6 Hybrid, 215 л.с., CVT, пакет Luxury, массажные сиденья, Mark Levinson', 4500000],
            ['Lexus RX 2023', 'Премиальный кроссовер, 3.5 V6 Hybrid, 308 л.с., полный привод, пакет Luxury, массажные сиденья, панорамная крыша', 5500000],
            ['Lexus LX 2023', 'Роскошный внедорожник, 5.7 V8, 383 л.с., полный привод, 7 мест, пакет Luxury, массажные сиденья всех рядов', 9500000],

            // INFINITI
            ['Infiniti Q50 2023', 'Премиальный седан, 3.0 Turbo, 300 л.с., задний привод, пакет Red Sport, массажные сиденья, Bose', 3800000],
            ['Infiniti QX60 2023', 'Премиальный внедорожник, 3.5 V6, 295 л.с., полный привод, 7 мест, пакет Autograph, массажные сиденья', 4800000],

            // MAZDA
            ['Mazda CX-5 2023', 'Компактный кроссовер, 2.5 Turbo, 250 л.с., полный привод, пакет Signature, массажные сиденья, Bose', 3200000],
            ['Mazda CX-9 2023', 'Средний внедорожник, 2.5 Turbo, 250 л.с., полный привод, 7 мест, пакет Signature, массажные сиденья', 4200000],

            // SUBARU
            ['Subaru Outback 2023', 'Универсал повышенной проходимости, 2.5, 182 л.с., полный привод, пакет Touring, массажные сиденья', 3200000],
            ['Subaru Forester 2023', 'Компактный кроссовер, 2.5, 182 л.с., полный привод, пакет Touring, камера 360°', 2800000],

            // VOLVO
            ['Volvo XC60 2023', 'Премиальный кроссовер, 2.0 Turbo, 250 л.с., полный привод, пакет Inscription, массажные сиденья, Bowers & Wilkins', 4200000],
            ['Volvo XC90 2023', 'Премиальный внедорожник, 2.0 Turbo, 316 л.с., полный привод, 7 мест, пакет Excellence, массажные сиденья всех рядов', 6500000],

            // JAGUAR
            ['Jaguar XF 2023', 'Премиальный седан, 2.0 Turbo, 250 л.с., задний привод, пакет R-Sport, массажные сиденья, Meridian', 4200000],
            ['Jaguar F-Pace 2023', 'Премиальный кроссовер, 3.0 Turbo, 340 л.с., полный привод, пакет S, массажные сиденья, Meridian', 5500000],

            // LAND ROVER
            ['Land Rover Discovery 2023', 'Премиальный внедорожник, 3.0 Turbo, 340 л.с., полный привод, 7 мест, пакет HSE, массажные сиденья', 6500000],
            ['Land Rover Range Rover 2023', 'Роскошный внедорожник, 5.0 V8, 525 л.с., полный привод, пакет Autobiography, массажные сиденья всех рядов', 15000000],

            // TESLA
            ['Tesla Model 3 2023', 'Электрический седан, 283 л.с., запас хода 602 км, автопилот, панорамная крыша', 3500000],
            ['Tesla Model Y 2023', 'Электрический кроссовер, 384 л.с., запас хода 533 км, автопилот, панорамная крыша, 7 мест', 4500000],
            ['Tesla Model S 2023', 'Электрический седан, 670 л.с., запас хода 652 км, автопилот, панорамная крыша, массажные сиденья', 8500000],
            ['Tesla Model X 2023', 'Электрический внедорожник, 670 л.с., запас хода 576 км, автопилот, панорамное лобовое стекло, 7 мест', 9500000],

            // CHEVROLET
            ['Chevrolet Camaro 2023', 'Спортивное купе, 6.2 V8, 455 л.с., МКПП, пакет SS, карбон, спортивная выхлопная система', 3800000],
            ['Chevrolet Tahoe 2023', 'Большой внедорожник, 5.3 V8, 355 л.с., полный привод, 8 мест, пакет High Country, массажные сиденья', 5500000],

            // DODGE
            ['Dodge Challenger 2023', 'Мощное купе, 6.4 V8, 485 л.с., МКПП, пакет Scat Pack, карбон, спортивная выхлопная система', 4200000],
            ['Dodge Charger 2023', 'Мощный седан, 6.4 V8, 485 л.с., АКПП, пакет Scat Pack, спортивная подвеска', 4500000],

            // CADILLAC
            ['Cadillac Escalade 2023', 'Роскошный внедорожник, 6.2 V8, 420 л.с., полный привод, 7 мест, пакет Platinum, массажные сиденья всех рядов', 8500000],
            ['Cadillac CT5 2023', 'Премиальный седан, 3.0 Turbo, 360 л.с., задний привод, пакет V-Series, массажные сиденья, AKG', 4800000],

            // ACURA
            ['Acura TLX 2023', 'Премиальный седан, 3.0 Turbo, 355 л.с., полный привод, пакет Type S, массажные сиденья, ELS Studio', 4200000],
            ['Acura MDX 2023', 'Премиальный внедорожник, 3.5 V6, 290 л.с., полный привод, 7 мест, пакет Advance, массажные сиденья', 5500000],

            // GENESIS
            ['Genesis G80 2023', 'Премиальный седан, 3.5 Turbo, 375 л.с., полный привод, пакет Prestige, массажные сиденья, Lexicon', 4800000],
            ['Genesis GV80 2023', 'Премиальный кроссовер, 3.5 Turbo, 375 л.с., полный привод, 7 мест, пакет Prestige, массажные сиденья', 5500000],
        ];

        // Массив надежных URL изображений автомобилей - используем простые рабочие ссылки
        $carImages = [
            'https://images.pexels.com/photos/1402787/pexels-photo-1402787.jpeg',
            'https://images.pexels.com/photos/1545743/pexels-photo-1545743.jpeg',
            'https://images.pexels.com/photos/116675/pexels-photo-116675.jpeg',
            'https://images.pexels.com/photos/3802508/pexels-photo-3802508.jpeg',
            'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/1719647/pexels-photo-1719647.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/1592384/pexels-photo-1592384.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/1149137/pexels-photo-1149137.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/210019/pexels-photo-210019.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/164634/pexels-photo-164634.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802507/pexels-photo-3802507.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802509/pexels-photo-3802509.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802510/pexels-photo-3802510.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802511/pexels-photo-3802511.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802512/pexels-photo-3802512.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802513/pexels-photo-3802513.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802514/pexels-photo-3802514.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802515/pexels-photo-3802515.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802516/pexels-photo-3802516.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802517/pexels-photo-3802517.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802518/pexels-photo-3802518.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802519/pexels-photo-3802519.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802520/pexels-photo-3802520.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802521/pexels-photo-3802521.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802522/pexels-photo-3802522.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802523/pexels-photo-3802523.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802524/pexels-photo-3802524.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802525/pexels-photo-3802525.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802526/pexels-photo-3802526.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802527/pexels-photo-3802527.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802528/pexels-photo-3802528.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802529/pexels-photo-3802529.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802530/pexels-photo-3802530.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802531/pexels-photo-3802531.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802532/pexels-photo-3802532.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802533/pexels-photo-3802533.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802534/pexels-photo-3802534.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802535/pexels-photo-3802535.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802536/pexels-photo-3802536.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802537/pexels-photo-3802537.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802538/pexels-photo-3802538.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802539/pexels-photo-3802539.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802540/pexels-photo-3802540.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802541/pexels-photo-3802541.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802542/pexels-photo-3802542.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802543/pexels-photo-3802543.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802544/pexels-photo-3802544.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802545/pexels-photo-3802545.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802546/pexels-photo-3802546.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802547/pexels-photo-3802547.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802548/pexels-photo-3802548.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802549/pexels-photo-3802549.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802550/pexels-photo-3802550.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802551/pexels-photo-3802551.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802552/pexels-photo-3802552.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802553/pexels-photo-3802553.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802554/pexels-photo-3802554.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802555/pexels-photo-3802555.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802556/pexels-photo-3802556.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802557/pexels-photo-3802557.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802558/pexels-photo-3802558.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802559/pexels-photo-3802559.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802560/pexels-photo-3802560.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802561/pexels-photo-3802561.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802562/pexels-photo-3802562.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802563/pexels-photo-3802563.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802564/pexels-photo-3802564.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802565/pexels-photo-3802565.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802566/pexels-photo-3802566.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802567/pexels-photo-3802567.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802568/pexels-photo-3802568.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802569/pexels-photo-3802569.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802570/pexels-photo-3802570.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802571/pexels-photo-3802571.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802572/pexels-photo-3802572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802573/pexels-photo-3802573.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802574/pexels-photo-3802574.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802575/pexels-photo-3802575.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802576/pexels-photo-3802576.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802577/pexels-photo-3802577.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802578/pexels-photo-3802578.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802579/pexels-photo-3802579.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802580/pexels-photo-3802580.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802581/pexels-photo-3802581.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802582/pexels-photo-3802582.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802583/pexels-photo-3802583.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802584/pexels-photo-3802584.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802585/pexels-photo-3802585.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802586/pexels-photo-3802586.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802587/pexels-photo-3802587.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802588/pexels-photo-3802588.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802589/pexels-photo-3802589.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802590/pexels-photo-3802590.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802591/pexels-photo-3802591.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802592/pexels-photo-3802592.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802593/pexels-photo-3802593.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802594/pexels-photo-3802594.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802595/pexels-photo-3802595.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802596/pexels-photo-3802596.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802597/pexels-photo-3802597.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802598/pexels-photo-3802598.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802599/pexels-photo-3802599.jpeg?auto=compress&cs=tinysrgb&w=1200&h=800&fit=crop',
            'https://images.pexels.com/photos/3802600/pexels-photo-3802600.jpeg',
        ];

        // Удаляем старые записи от этого пользователя
        Bb::where('user_id', $user->id)->delete();

        foreach ($cars as $index => $car) {
            Bb::create([
                'title' => $car[0],
                'content' => $car[1],
                'price' => $car[2],
                'user_id' => $user->id,
                'image' => null,
            ]);
        }

        $this->command->info('Создано ' . count($cars) . ' автомобилей!');
    }
}
