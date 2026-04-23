<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bb extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    protected $fillable = ['title', 'brand', 'content', 'price', 'image', 'user_id', 'category_id', 'status'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'На рассмотрении',
            self::STATUS_REJECTED => 'Отклонено',
            default => 'Одобрено',
        };
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }

            $publicPath = public_path($this->image);
            $storagePath = storage_path('app/public/cars/' . basename($this->image));
            $legacyPublicPath = public_path('storage/cars/' . basename($this->image));

            if (file_exists($publicPath) || file_exists($storagePath) || file_exists($legacyPublicPath)) {
                if (file_exists($publicPath)) {
                    return asset($this->image);
                }

                return asset('storage/cars/' . basename($this->image));
            }
        }

        $exactImage = $this->exactModelImageUrl();
        $matchedImage = $this->matchedImageUrl();

        if ($exactImage) {
            return $exactImage;
        }

        if ($matchedImage) {
            return $matchedImage;
        }

        return $this->fallbackImageUrl();
    }

    public function getBrandNameAttribute(): string
    {
        if (!empty($this->brand)) {
            return $this->brand;
        }

        $title = Str::lower($this->title ?? '');
        $brands = [
            'mercedes-benz' => 'Mercedes-Benz',
            'mercedes' => 'Mercedes-Benz',
            'bmw' => 'BMW',
            'audi' => 'Audi',
            'toyota' => 'Toyota',
            'lexus' => 'Lexus',
            'ford' => 'Ford',
            'volkswagen' => 'Volkswagen',
            'vw' => 'Volkswagen',
            'hyundai' => 'Hyundai',
            'nissan' => 'Nissan',
            'porsche' => 'Porsche',
            'jeep' => 'Jeep',
            'tesla' => 'Tesla',
            'honda' => 'Honda',
            'kia' => 'Kia',
            'mazda' => 'Mazda',
            'skoda' => 'Skoda',
            'renault' => 'Renault',
            'peugeot' => 'Peugeot',
            'bentley' => 'Bentley',
            'infiniti' => 'Infiniti',
            'subaru' => 'Subaru',
            'volvo' => 'Volvo',
            'jaguar' => 'Jaguar',
            'land rover' => 'Land Rover',
            'range rover' => 'Land Rover',
            'chevrolet' => 'Chevrolet',
            'dodge' => 'Dodge',
            'cadillac' => 'Cadillac',
            'acura' => 'Acura',
            'genesis' => 'Genesis',
        ];

        foreach ($brands as $keyword => $label) {
            if (Str::contains($title, $keyword)) {
                return $label;
            }
        }

        return 'Автомобиль с пробегом';
    }

    public function getShortDescriptionAttribute(): string
    {
        return Str::limit(trim((string) $this->content), 110);
    }

    protected function localCarImage(string $filename): string
    {
        return asset('images/cars/' . $filename);
    }

    protected function exactModelImageUrl(): ?string
    {
        $title = trim((string) $this->title);

        if ($title === '') {
            return null;
        }

        $filename = Str::slug($title) . '.png';
        $publicFile = public_path('images/cars/' . $filename);

        if (file_exists($publicFile)) {
            return $this->localCarImage($filename);
        }

        return null;
    }

    protected function fallbackImageUrl(): string
    {
        $title = Str::lower($this->title ?? '');

        $brandImages = [
            'mercedes-benz' => $this->localCarImage('executive-sedan.png'),
            'mercedes' => $this->localCarImage('executive-sedan.png'),
            'bmw' => $this->localCarImage('executive-sedan.png'),
            'audi' => $this->localCarImage('executive-sedan.png'),
            'toyota' => $this->localCarImage('compact-city-car.png'),
            'lexus' => $this->localCarImage('flagship-sedan.png'),
            'ford' => $this->localCarImage('pickup-truck.png'),
            'volkswagen' => $this->localCarImage('compact-city-car.png'),
            'vw' => $this->localCarImage('compact-city-car.png'),
            'hyundai' => $this->localCarImage('midsize-crossover.png'),
            'nissan' => $this->localCarImage('sports-coupe.png'),
            'porsche' => $this->localCarImage('sports-coupe.png'),
            'jeep' => $this->localCarImage('offroad-suv.png'),
            'tesla' => $this->localCarImage('electric-sedan.png'),
            'honda' => $this->localCarImage('compact-city-car.png'),
            'kia' => $this->localCarImage('midsize-crossover.png'),
            'mazda' => $this->localCarImage('midsize-crossover.png'),
            'skoda' => $this->localCarImage('compact-city-car.png'),
            'renault' => $this->localCarImage('compact-city-car.png'),
            'peugeot' => $this->localCarImage('compact-city-car.png'),
            'bentley' => $this->localCarImage('grand-tourer.png'),
            'infiniti' => $this->localCarImage('flagship-sedan.png'),
            'subaru' => $this->localCarImage('offroad-suv.png'),
            'volvo' => $this->localCarImage('luxury-family-suv.png'),
            'jaguar' => $this->localCarImage('flagship-sedan.png'),
            'land rover' => $this->localCarImage('offroad-suv.png'),
            'range rover' => $this->localCarImage('offroad-suv.png'),
            'chevrolet' => $this->localCarImage('sports-coupe.png'),
            'dodge' => $this->localCarImage('sports-coupe.png'),
            'cadillac' => $this->localCarImage('flagship-sedan.png'),
            'acura' => $this->localCarImage('executive-sedan.png'),
            'genesis' => $this->localCarImage('flagship-sedan.png'),
        ];

        foreach ($brandImages as $keyword => $imageUrl) {
            if (Str::contains($title, $keyword)) {
                return $imageUrl;
            }
        }

        return $this->localCarImage('executive-sedan.png');
    }

    protected function matchedImageUrl(): ?string
    {
        $title = Str::lower($this->title ?? '');
        $strictImage = $this->strictTitleImageUrl($title);

        if ($strictImage) {
            return $strictImage;
        }

        $modelImages = [
            'audi a4' => $this->localCarImage('executive-sedan.png'),
            'audi a6' => $this->localCarImage('executive-sedan.png'),
            'audi a8' => $this->localCarImage('flagship-sedan.png'),
            'audi q5' => $this->localCarImage('midsize-crossover.png'),
            'audi q7' => $this->localCarImage('luxury-family-suv.png'),
            'audi tt' => $this->localCarImage('sports-coupe.png'),
            'audi rs6' => $this->localCarImage('grand-tourer.png'),
            'audi e-tron' => $this->localCarImage('electric-crossover.png'),
            'bmw x3' => $this->localCarImage('midsize-crossover.png'),
            'bmw x5' => $this->localCarImage('premium-suv-bmw-x5.png'),
            'bmw x7' => $this->localCarImage('luxury-family-suv.png'),
            'bmw ix' => $this->localCarImage('electric-crossover.png'),
            'bmw m3' => $this->localCarImage('bmw-m3-2023.png'),
            'bmw m5' => $this->localCarImage('bmw-m5-2023.png'),
            '3 series' => $this->localCarImage('executive-sedan.png'),
            '5 series' => $this->localCarImage('executive-sedan.png'),
            'c-class' => $this->localCarImage('executive-sedan.png'),
            'e-class' => $this->localCarImage('executive-sedan.png'),
            's-class' => $this->localCarImage('flagship-sedan.png'),
            'gle' => $this->localCarImage('luxury-family-suv.png'),
            'gls' => $this->localCarImage('luxury-family-suv.png'),
            'g-class' => $this->localCarImage('offroad-suv.png'),
            'amg gt' => $this->localCarImage('sports-coupe.png'),
            'eqs' => $this->localCarImage('electric-sedan.png'),
            'ford focus' => $this->localCarImage('compact-city-car.png'),
            'ford mondeo' => $this->localCarImage('executive-sedan.png'),
            'explorer' => $this->localCarImage('luxury-family-suv.png'),
            'mustang' => $this->localCarImage('sports-coupe.png'),
            'f-150' => $this->localCarImage('pickup-truck.png'),
            'ford edge' => $this->localCarImage('midsize-crossover.png'),
            'camry' => $this->localCarImage('executive-sedan.png'),
            'rav4' => $this->localCarImage('midsize-crossover.png'),
            'land cruiser' => $this->localCarImage('offroad-suv.png'),
            'highlander' => $this->localCarImage('luxury-family-suv.png'),
            'corolla' => $this->localCarImage('compact-city-car.png'),
            'prius' => $this->localCarImage('electric-sedan.png'),
            'golf' => $this->localCarImage('compact-city-car.png'),
            'passat' => $this->localCarImage('executive-sedan.png'),
            'tiguan' => $this->localCarImage('midsize-crossover.png'),
            'touareg' => $this->localCarImage('luxury-family-suv.png'),
            'arteon' => $this->localCarImage('grand-tourer.png'),
            'id.4' => $this->localCarImage('electric-crossover.png'),
            '911' => $this->localCarImage('sports-coupe.png'),
            'cayenne' => $this->localCarImage('luxury-family-suv.png'),
            'macan' => $this->localCarImage('midsize-crossover.png'),
            'panamera' => $this->localCarImage('grand-tourer.png'),
            'taycan' => $this->localCarImage('electric-sedan.png'),
            'altima' => $this->localCarImage('executive-sedan.png'),
            'rogue' => $this->localCarImage('midsize-crossover.png'),
            'pathfinder' => $this->localCarImage('luxury-family-suv.png'),
            'gt-r' => $this->localCarImage('sports-coupe.png'),
            'leaf' => $this->localCarImage('electric-sedan.png'),
            'sonata' => $this->localCarImage('executive-sedan.png'),
            'tucson' => $this->localCarImage('midsize-crossover.png'),
            'santa fe' => $this->localCarImage('luxury-family-suv.png'),
            'palisade' => $this->localCarImage('luxury-family-suv.png'),
            'ioniq' => $this->localCarImage('electric-crossover.png'),
            '308' => $this->localCarImage('compact-city-car.png'),
            '508' => $this->localCarImage('executive-sedan.png'),
            '3008' => $this->localCarImage('midsize-crossover.png'),
            '5008' => $this->localCarImage('luxury-family-suv.png'),
            'continental gt' => $this->localCarImage('grand-tourer.png'),
            'bentayga' => $this->localCarImage('luxury-family-suv.png'),
            'flying spur' => $this->localCarImage('flagship-sedan.png'),
            'wrangler' => $this->localCarImage('offroad-suv.png'),
            'grand cherokee' => $this->localCarImage('luxury-family-suv.png'),
            'cherokee' => $this->localCarImage('midsize-crossover.png'),
            'lexus es' => $this->localCarImage('executive-sedan.png'),
            'lexus rx' => $this->localCarImage('midsize-crossover.png'),
            'lexus lx' => $this->localCarImage('offroad-suv.png'),
            'q50' => $this->localCarImage('executive-sedan.png'),
            'qx60' => $this->localCarImage('luxury-family-suv.png'),
            'cx-5' => $this->localCarImage('midsize-crossover.png'),
            'cx-9' => $this->localCarImage('luxury-family-suv.png'),
            'skoda octavia' => $this->localCarImage('volkswagen-passat-2023.png'),
            'skoda kodiaq' => $this->localCarImage('volkswagen-tiguan-2023.png'),
            'outback' => $this->localCarImage('offroad-suv.png'),
            'forester' => $this->localCarImage('midsize-crossover.png'),
            'xc60' => $this->localCarImage('luxury-family-suv.png'),
            'xc90' => $this->localCarImage('luxury-family-suv.png'),
            'xf' => $this->localCarImage('flagship-sedan.png'),
            'f-pace' => $this->localCarImage('luxury-family-suv.png'),
            'discovery' => $this->localCarImage('offroad-suv.png'),
            'range rover' => $this->localCarImage('offroad-suv.png'),
            'model 3' => $this->localCarImage('electric-sedan.png'),
            'model y' => $this->localCarImage('electric-crossover.png'),
            'model s' => $this->localCarImage('electric-sedan.png'),
            'model x' => $this->localCarImage('electric-crossover.png'),
            'camaro' => $this->localCarImage('sports-coupe.png'),
            'tahoe' => $this->localCarImage('luxury-family-suv.png'),
            'challenger' => $this->localCarImage('sports-coupe.png'),
            'charger' => $this->localCarImage('dodge-charger-2023.png'),
            'escalade' => $this->localCarImage('luxury-family-suv.png'),
            'ct5' => $this->localCarImage('cadillac-ct5-2023.png'),
            'tlx' => $this->localCarImage('executive-sedan.png'),
            'acura mdx' => $this->localCarImage('acura-mdx-2023.png'),
            'mdx' => $this->localCarImage('acura-mdx-2023.png'),
            'genesis g80' => $this->localCarImage('genesis-g80-2023.png'),
            'g80' => $this->localCarImage('genesis-g80-2023.png'),
            'genesis gv80' => $this->localCarImage('genesis-gv80-2023.png'),
            'gv80' => $this->localCarImage('genesis-gv80-2023.png'),
        ];

        foreach ($modelImages as $keyword => $imageUrl) {
            if (Str::contains($title, $keyword)) {
                return $imageUrl;
            }
        }

        return null;
    }

    protected function strictTitleImageUrl(string $title): ?string
    {
        $normalized = trim(preg_replace('/\s+/', ' ', $title));

        $strictMap = [
            'audi a4 2023' => 'audi-a4-2023.png',
            'audi a6 2023' => 'audi-a6-2023.png',
            'audi q5 2023' => 'audi-q5-2023.png',
            'audi q7 2023' => 'audi-q7-2023.png',
            'audi a8 2023' => 'audi-a8-2023.png',
            'audi tt 2023' => 'audi-tt-2023.png',
            'audi rs6 2023' => 'audi-rs6-2023.png',
            'audi e-tron 2023' => 'audi-e-tron-2023.png',
            'bmw 3 series 2023' => 'bmw-3-series-2023.png',
            'bmw 5 series 2023' => 'bmw-5-series-2023.png',
            'bmw x3 2023' => 'bmw-x3-2023.png',
            'bmw x5 2023' => 'bmw-x5-2023.png',
            'bmw x7 2023' => 'bmw-x7-2023.png',
            'bmw m3 2023' => 'bmw-m3-2023.png',
            'bmw m5 2023' => 'bmw-m5-2023.png',
            'bmw ix 2023' => 'bmw-ix-2023.png',
            'mercedes c-class 2023' => 'mercedes-c-class-2023.png',
            'mercedes e-class 2023' => 'mercedes-e-class-2023.png',
            'mercedes s-class 2023' => 'mercedes-s-class-2023.png',
            'mercedes gle 2023' => 'mercedes-gle-2023.png',
            'mercedes gls 2023' => 'mercedes-gls-2023.png',
            'mercedes amg gt 2023' => 'mercedes-amg-gt-2023.png',
            'mercedes g-class 2023' => 'mercedes-g-class-2023.png',
            'mercedes eqs 2023' => 'mercedes-eqs-2023.png',
            'ford focus 2023' => 'ford-focus-2023.png',
            'ford mondeo 2023' => 'ford-mondeo-2023.png',
            'ford explorer 2023' => 'ford-explorer-2023.png',
            'ford mustang 2023' => 'ford-mustang-2023.png',
            'ford f-150 2023' => 'ford-f-150-2023.png',
            'ford edge 2023' => 'ford-edge-2023.png',
            'toyota camry 2023' => 'toyota-camry-2023.png',
            'toyota rav4 2023' => 'toyota-rav4-2023.png',
            'toyota land cruiser 2023' => 'toyota-land-cruiser-2023.png',
            'toyota highlander 2023' => 'toyota-highlander-2023.png',
            'toyota corolla 2023' => 'toyota-corolla-2023.png',
            'toyota prius 2023' => 'toyota-prius-2023.png',
            'volkswagen golf 2023' => 'volkswagen-golf-2023.png',
            'volkswagen passat 2023' => 'volkswagen-passat-2023.png',
            'volkswagen tiguan 2023' => 'volkswagen-tiguan-2023.png',
            'volkswagen touareg 2023' => 'volkswagen-touareg-2023.png',
            'volkswagen arteon 2023' => 'volkswagen-arteon-2023.png',
            'volkswagen id.4 2023' => 'volkswagen-id-4-2023.png',
            'porsche 911 2023' => 'porsche-911-2023.png',
            'porsche cayenne 2023' => 'porsche-cayenne-2023.png',
            'porsche macan 2023' => 'porsche-macan-2023.png',
            'porsche panamera 2023' => 'porsche-panamera-2023.png',
            'porsche taycan 2023' => 'porsche-taycan-2023.png',
            'nissan altima 2023' => 'nissan-altima-2023.png',
            'nissan rogue 2023' => 'nissan-rogue-2023.png',
            'nissan pathfinder 2023' => 'nissan-pathfinder-2023.png',
            'nissan gt-r 2023' => 'nissan-gt-r-2023.png',
            'nissan leaf 2023' => 'nissan-leaf-2023.png',
            'hyundai sonata 2023' => 'hyundai-sonata-2023.png',
            'hyundai tucson 2023' => 'hyundai-tucson-2023.png',
            'hyundai santa fe 2023' => 'hyundai-santa-fe-2023.png',
            'hyundai palisade 2023' => 'hyundai-palisade-2023.png',
            'hyundai ioniq 5 2023' => 'hyundai-ioniq-5-2023.png',
            'peugeot 308 2023' => 'peugeot-308-2023.png',
            'peugeot 508 2023' => 'peugeot-508-2023.png',
            'peugeot 3008 2023' => 'peugeot-3008-2023.png',
            'peugeot 5008 2023' => 'peugeot-5008-2023.png',
            'bentley continental gt 2023' => 'bentley-continental-gt-2023.png',
            'bentley bentayga 2023' => 'bentley-bentayga-2023.png',
            'bentley flying spur 2023' => 'bentley-flying-spur-2023.png',
            'jeep wrangler 2023' => 'jeep-wrangler-2023.png',
            'jeep grand cherokee 2023' => 'jeep-grand-cherokee-2023.png',
            'jeep cherokee 2023' => 'jeep-cherokee-2023.png',
            'lexus es 2023' => 'lexus-es-2023.png',
            'lexus rx 2023' => 'lexus-rx-2023.png',
            'lexus lx 2023' => 'lexus-lx-2023.png',
            'infiniti q50 2023' => 'infiniti-q50-2023.png',
            'infiniti qx60 2023' => 'infiniti-qx60-2023.png',
            'mazda cx-5 2023' => 'mazda-cx-5-2023.png',
            'mazda cx-9 2023' => 'mazda-cx-9-2023.png',
            'skoda octavia 2024' => 'volkswagen-passat-2023.png',
            'skoda kodiaq 2024' => 'volkswagen-tiguan-2023.png',
            'subaru outback 2023' => 'subaru-outback-2023.png',
            'subaru forester 2023' => 'subaru-forester-2023.png',
            'volvo xc60 2023' => 'volvo-xc60-2023.png',
            'volvo xc90 2023' => 'volvo-xc90-2023.png',
            'jaguar xf 2023' => 'jaguar-xf-2023.png',
            'jaguar f-pace 2023' => 'jaguar-f-pace-2023.png',
            'land rover discovery 2023' => 'land-rover-discovery-2023.png',
            'land rover range rover 2023' => 'land-rover-range-rover-2023.png',
            'tesla model 3 2023' => 'tesla-model-3-2023.png',
            'tesla model y 2023' => 'tesla-model-y-2023.png',
            'tesla model s 2023' => 'tesla-model-s-2023.png',
            'tesla model x 2023' => 'tesla-model-x-2023.png',
            'chevrolet camaro 2023' => 'chevrolet-camaro-2023.png',
            'chevrolet tahoe 2023' => 'chevrolet-tahoe-2023.png',
            'dodge challenger 2023' => 'dodge-challenger-2023.png',
            'dodge charger 2023' => 'dodge-charger-2023.png',
            'cadillac escalade 2023' => 'cadillac-escalade-2023.png',
            'cadillac ct5 2023' => 'cadillac-ct5-2023.png',
            'acura tlx 2023' => 'acura-tlx-2023.png',
            'acura mdx 2023' => 'acura-mdx-2023.png',
            'genesis g80 2023' => 'genesis-g80-2023.png',
            'genesis gv80 2023' => 'genesis-gv80-2023.png',
        ];

        if (!isset($strictMap[$normalized])) {
            return null;
        }

        $filename = $strictMap[$normalized];
        $publicFile = public_path('images/cars/' . $filename);

        if (!file_exists($publicFile)) {
            return null;
        }

        return $this->localCarImage($filename);
    }

    protected function shouldPreferMatchedImage(string $imageUrl): bool
    {
        $normalized = Str::lower($imageUrl);

        return Str::contains($normalized, [
            'images.pexels.com/photos/',
            'pexels-photo-',
        ]);
    }

    protected function realModelPhotoUrl(): ?string
    {
        $title = trim((string) $this->title);
        if ($title === '') {
            return null;
        }

        $brand = Str::lower((string) $this->brand_name);
        $category = $this->vehiclePhotoCategory();

        $titleParts = preg_split(
            '/\s+/',
            trim((string) Str::of(Str::lower(str_replace('-', ' ', $title)))->replaceMatches('/[^a-z0-9\s]/', ' '))
        );

        $keywords = array_values(array_filter(array_unique(array_merge(
            [$brand],
            array_slice($titleParts ?: [], 0, 4),
            [$category, 'car']
        ))));

        if (empty($keywords)) {
            $keywords = ['car', 'sedan'];
        }

        $query = implode(',', array_map(static fn ($part) => rawurlencode($part), $keywords));
        $seed = sprintf('%u', crc32(Str::lower($title . '|' . $brand)));

        return "https://source.unsplash.com/featured/1600x900/?{$query}&sig={$seed}";
    }

    protected function vehiclePhotoCategory(): string
    {
        $text = Str::lower(trim(($this->title ?? '') . ' ' . ($this->content ?? '')));

        if (Str::contains($text, ['pickup', 'f-150', 'пикап'])) {
            return 'pickup';
        }

        if (Str::contains($text, ['coupe', 'купе', 'gt-r', '911', 'amg gt', 'camaro', 'challenger', 'mustang', 'tt'])) {
            return 'coupe';
        }

        if (Str::contains($text, ['hatchback', 'хэтчбек', 'golf', 'leaf', 'prius', '308'])) {
            return 'hatchback';
        }

        if (Str::contains($text, ['electric', 'электр', 'model', 'taycan', 'eqs', 'ioniq', 'id.4', 'e-tron'])) {
            return 'electric-car';
        }

        if (Str::contains($text, ['suv', 'внедорож', 'кроссовер', 'x5', 'x7', 'tahoe', 'escalade', 'range rover', 'g-class'])) {
            return 'suv';
        }

        return 'sedan';
    }

    protected function generatedModelCardUrl(): ?string
    {
        $title = trim((string) $this->title);
        if ($title === '') {
            return null;
        }

        $brand = $this->brand_name;
        $type = $this->vehicleTypeFromText();
        [$bgA, $bgB, $accent] = $this->paletteForBrand(Str::lower($brand));

        $titleEsc = htmlspecialchars($title, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $brandEsc = htmlspecialchars($brand, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $typeEsc = htmlspecialchars($type, ENT_QUOTES | ENT_XML1, 'UTF-8');

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1600" height="900" viewBox="0 0 1600 900" role="img" aria-label="$titleEsc">
  <defs>
    <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="$bgA"/>
      <stop offset="100%" stop-color="$bgB"/>
    </linearGradient>
    <linearGradient id="road" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0%" stop-color="#0B1220"/>
      <stop offset="100%" stop-color="#1B263D"/>
    </linearGradient>
    <filter id="shadow" x="-40%" y="-40%" width="180%" height="180%">
      <feDropShadow dx="0" dy="18" stdDeviation="18" flood-color="#000000" flood-opacity="0.35"/>
    </filter>
  </defs>
  <rect width="1600" height="900" fill="url(#bg)"/>
  <circle cx="1280" cy="140" r="270" fill="$accent" fill-opacity="0.14"/>
  <rect x="0" y="630" width="1600" height="270" fill="url(#road)"/>
  <g transform="translate(200,250)" filter="url(#shadow)">
    {$this->carBodySvgByType($type, $accent)}
    <circle cx="260" cy="355" r="72" fill="#0F172A"/>
    <circle cx="260" cy="355" r="38" fill="#CBD5E1"/>
    <circle cx="980" cy="355" r="72" fill="#0F172A"/>
    <circle cx="980" cy="355" r="38" fill="#CBD5E1"/>
  </g>
  <rect x="70" y="70" rx="26" ry="26" width="360" height="74" fill="rgba(6,12,24,0.55)" stroke="rgba(255,255,255,0.3)"/>
  <text x="250" y="118" text-anchor="middle" fill="#E2E8F0" font-size="36" font-weight="700" font-family="Segoe UI, Arial, sans-serif">$brandEsc</text>
  <text x="80" y="760" fill="#FFFFFF" font-size="66" font-weight="800" font-family="Segoe UI, Arial, sans-serif">$titleEsc</text>
  <text x="80" y="815" fill="#C7D2FE" font-size="34" font-weight="600" font-family="Segoe UI, Arial, sans-serif">$typeEsc</text>
</svg>
SVG;

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }

    protected function vehicleTypeFromText(): string
    {
        $text = Str::lower(trim(($this->title ?? '') . ' ' . ($this->content ?? '')));

        if (Str::contains($text, ['пикап', 'pickup', 'f-150'])) {
            return 'Pickup';
        }

        if (Str::contains($text, ['купе', 'coupe', 'gt-r', '911', 'amg gt', 'camaro', 'challenger', 'mustang', 'tt'])) {
            return 'Coupe';
        }

        if (Str::contains($text, ['универсал', 'wagon', 'outback', 'rs6'])) {
            return 'Wagon';
        }

        if (Str::contains($text, ['хэтчбек', 'hatchback', 'golf', 'leaf', 'prius', '308'])) {
            return 'Hatchback';
        }

        if (Str::contains($text, ['электрический', 'ev', 'model', 'taycan', 'eqs', 'ioniq', 'id.4', 'e-tron'])) {
            return 'Electric';
        }

        if (Str::contains($text, ['внедорожник', 'suv', 'кроссовер', 'x5', 'x7', 'tahoe', 'escalade', 'range rover', 'g-class'])) {
            return 'SUV';
        }

        return 'Sedan';
    }

    protected function paletteForBrand(string $brand): array
    {
        $palettes = [
            'bmw' => ['#0B1220', '#1B2C47', '#4D8DFF'],
            'mercedes-benz' => ['#101623', '#2A3348', '#7A8CA8'],
            'mercedes' => ['#101623', '#2A3348', '#7A8CA8'],
            'audi' => ['#111827', '#293241', '#E63946'],
            'porsche' => ['#27110A', '#4A1D12', '#FF5B2E'],
            'toyota' => ['#231015', '#3A1A24', '#E11D48'],
            'ford' => ['#0E1B38', '#1F3A6D', '#60A5FA'],
            'volkswagen' => ['#0B1F3A', '#173D6E', '#5FA8FF'],
            'tesla' => ['#200D12', '#3D111C', '#FF4D5A'],
            'default' => ['#12172A', '#23304A', '#60A5FA'],
        ];

        foreach ($palettes as $key => $colors) {
            if ($key !== 'default' && Str::contains($brand, $key)) {
                return $colors;
            }
        }

        return $palettes['default'];
    }

    protected function carBodySvgByType(string $type, string $accent): string
    {
        $stroke = 'stroke="rgba(255,255,255,0.28)" stroke-width="4"';

        if ($type === 'Pickup') {
            return <<<SVG
<path d="M70 290 L190 240 L640 240 L780 285 L1070 285 L1135 325 L1135 365 L70 365 Z" fill="$accent" $stroke/>
<rect x="610" y="200" width="210" height="72" rx="20" fill="rgba(255,255,255,0.28)"/>
SVG;
        }

        if ($type === 'SUV') {
            return <<<SVG
<path d="M90 300 L220 230 L760 230 L930 280 L1090 290 L1140 325 L1140 365 L90 365 Z" fill="$accent" $stroke/>
<rect x="280" y="200" width="510" height="86" rx="28" fill="rgba(255,255,255,0.28)"/>
SVG;
        }

        if ($type === 'Coupe') {
            return <<<SVG
<path d="M95 325 L205 270 L560 245 L735 250 L930 300 L1105 315 L1140 335 L1140 365 L95 365 Z" fill="$accent" $stroke/>
<path d="M350 240 Q520 150 700 220 L760 255 L365 255 Z" fill="rgba(255,255,255,0.3)"/>
SVG;
        }

        if ($type === 'Hatchback' || $type === 'Wagon' || $type === 'Electric') {
            return <<<SVG
<path d="M90 320 L220 260 L650 245 L850 245 L1030 295 L1125 320 L1140 335 L1140 365 L90 365 Z" fill="$accent" $stroke/>
<rect x="290" y="215" width="500" height="78" rx="22" fill="rgba(255,255,255,0.3)"/>
SVG;
        }

        return <<<SVG
<path d="M95 325 L215 275 L620 255 L815 255 L995 300 L1120 320 L1140 335 L1140 365 L95 365 Z" fill="$accent" $stroke/>
<rect x="300" y="220" width="470" height="78" rx="24" fill="rgba(255,255,255,0.3)"/>
SVG;
    }
}
