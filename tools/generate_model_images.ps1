$ErrorActionPreference = 'Stop'

Add-Type -AssemblyName System.Drawing

$projectRoot = Split-Path -Parent $PSScriptRoot
$carsDir = Join-Path $projectRoot 'public\images\cars'
$seederPath = Join-Path $projectRoot 'database\seeders\CarSeeder.php'

function Get-Slug {
    param([string]$Text)

    $value = $Text.ToLowerInvariant()
    $value = $value -replace '[^a-z0-9]+', '-'
    $value = $value.Trim('-')
    return "$value.png"
}

function Get-TitleHash {
    param([string]$Text)

    $sha = [System.Security.Cryptography.SHA256]::Create()
    try {
        return $sha.ComputeHash([System.Text.Encoding]::UTF8.GetBytes($Text))
    } finally {
        $sha.Dispose()
    }
}

function Get-OverlayColor {
    param([byte[]]$Hash)

    $palette = @(
        [System.Drawing.Color]::FromArgb(32, 46, 108, 223),
        [System.Drawing.Color]::FromArgb(28, 0, 188, 212),
        [System.Drawing.Color]::FromArgb(26, 255, 152, 0),
        [System.Drawing.Color]::FromArgb(30, 255, 87, 34),
        [System.Drawing.Color]::FromArgb(28, 156, 39, 176),
        [System.Drawing.Color]::FromArgb(24, 0, 150, 136),
        [System.Drawing.Color]::FromArgb(24, 233, 30, 99),
        [System.Drawing.Color]::FromArgb(22, 96, 125, 139)
    )

    return $palette[$Hash[0] % $palette.Count]
}

function Get-BaseImageName {
    param([string]$Title)

    $name = $Title.ToLowerInvariant()

    $map = [ordered]@{
        'audi tt' = 'sports-coupe.png'
        'audi rs6' = 'grand-tourer.png'
        'audi e-tron' = 'electric-crossover.png'
        'audi q7' = 'luxury-family-suv.png'
        'audi q5' = 'midsize-crossover.png'
        'audi a8' = 'flagship-sedan.png'
        'audi ' = 'executive-sedan.png'
        'bmw x5' = 'premium-suv-bmw-x5.png'
        'bmw x7' = 'luxury-family-suv.png'
        'bmw x3' = 'midsize-crossover.png'
        'bmw ix' = 'electric-crossover.png'
        'bmw m3' = 'sports-coupe.png'
        'bmw m5' = 'sports-coupe.png'
        'bmw ' = 'executive-sedan.png'
        'mercedes amg gt' = 'sports-coupe.png'
        'mercedes eqs' = 'electric-sedan.png'
        'mercedes g-class' = 'offroad-suv.png'
        'mercedes gls' = 'luxury-family-suv.png'
        'mercedes gle' = 'luxury-family-suv.png'
        'mercedes s-class' = 'flagship-sedan.png'
        'mercedes ' = 'executive-sedan.png'
        'ford f-150' = 'pickup-truck.png'
        'ford mustang' = 'sports-coupe.png'
        'ford explorer' = 'luxury-family-suv.png'
        'ford edge' = 'midsize-crossover.png'
        'ford ' = 'compact-city-car.png'
        'toyota land cruiser' = 'offroad-suv.png'
        'toyota highlander' = 'luxury-family-suv.png'
        'toyota rav4' = 'midsize-crossover.png'
        'toyota prius' = 'electric-sedan.png'
        'toyota camry' = 'executive-sedan.png'
        'toyota corolla' = 'compact-city-car.png'
        'toyota ' = 'compact-city-car.png'
        'volkswagen touareg' = 'luxury-family-suv.png'
        'volkswagen tiguan' = 'midsize-crossover.png'
        'volkswagen id.4' = 'electric-crossover.png'
        'volkswagen arteon' = 'grand-tourer.png'
        'volkswagen ' = 'compact-city-car.png'
        'porsche 911' = 'sports-coupe.png'
        'porsche taycan' = 'electric-sedan.png'
        'porsche panamera' = 'grand-tourer.png'
        'porsche cayenne' = 'luxury-family-suv.png'
        'porsche macan' = 'midsize-crossover.png'
        'nissan gt-r' = 'sports-coupe.png'
        'nissan leaf' = 'electric-sedan.png'
        'nissan pathfinder' = 'luxury-family-suv.png'
        'nissan rogue' = 'midsize-crossover.png'
        'nissan ' = 'executive-sedan.png'
        'hyundai ioniq' = 'electric-crossover.png'
        'hyundai palisade' = 'luxury-family-suv.png'
        'hyundai santa fe' = 'luxury-family-suv.png'
        'hyundai tucson' = 'midsize-crossover.png'
        'hyundai ' = 'executive-sedan.png'
        'peugeot 5008' = 'luxury-family-suv.png'
        'peugeot 3008' = 'midsize-crossover.png'
        'peugeot 508' = 'executive-sedan.png'
        'peugeot ' = 'compact-city-car.png'
        'bentley bentayga' = 'luxury-family-suv.png'
        'bentley flying spur' = 'flagship-sedan.png'
        'bentley ' = 'grand-tourer.png'
        'jeep wrangler' = 'offroad-suv.png'
        'jeep grand cherokee' = 'luxury-family-suv.png'
        'jeep cherokee' = 'midsize-crossover.png'
        'lexus lx' = 'offroad-suv.png'
        'lexus rx' = 'midsize-crossover.png'
        'lexus es' = 'executive-sedan.png'
        'infiniti qx60' = 'luxury-family-suv.png'
        'infiniti ' = 'executive-sedan.png'
        'mazda cx-9' = 'luxury-family-suv.png'
        'mazda ' = 'midsize-crossover.png'
        'subaru outback' = 'offroad-suv.png'
        'subaru ' = 'midsize-crossover.png'
        'volvo xc90' = 'luxury-family-suv.png'
        'volvo ' = 'luxury-family-suv.png'
        'jaguar f-pace' = 'luxury-family-suv.png'
        'jaguar ' = 'flagship-sedan.png'
        'land rover' = 'offroad-suv.png'
        'range rover' = 'offroad-suv.png'
        'tesla model y' = 'electric-crossover.png'
        'tesla model x' = 'electric-crossover.png'
        'tesla ' = 'electric-sedan.png'
        'chevrolet tahoe' = 'luxury-family-suv.png'
        'chevrolet ' = 'sports-coupe.png'
        'dodge ' = 'sports-coupe.png'
        'cadillac escalade' = 'luxury-family-suv.png'
        'cadillac ' = 'flagship-sedan.png'
        'acura mdx' = 'acura-mdx-2023.png'
        'acura ' = 'executive-sedan.png'
        'genesis gv80' = 'genesis-gv80-2023.png'
        'genesis g80' = 'genesis-g80-2023.png'
        'genesis ' = 'flagship-sedan.png'
    }

    foreach ($entry in $map.GetEnumerator()) {
        if ($name.Contains($entry.Key)) {
            return $entry.Value
        }
    }

    return 'executive-sedan.png'
}

function New-VariantImage {
    param(
        [string]$BasePath,
        [string]$OutputPath,
        [string]$Title
    )

    $hash = Get-TitleHash $Title
    $overlayColor = Get-OverlayColor $hash

    $baseBitmap = [System.Drawing.Bitmap]::new($BasePath)
    try {
        if (($hash[1] % 2) -eq 1) {
            $baseBitmap.RotateFlip([System.Drawing.RotateFlipType]::RotateNoneFlipX)
        }

        $canvas = [System.Drawing.Bitmap]::new($baseBitmap.Width, $baseBitmap.Height)
        try {
            $graphics = [System.Drawing.Graphics]::FromImage($canvas)
            try {
                $graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
                $graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
                $graphics.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality

                $zoom = 1.02 + (($hash[2] % 12) / 100.0)
                $cropWidth = [int]($baseBitmap.Width / $zoom)
                $cropHeight = [int]($baseBitmap.Height / $zoom)
                $maxX = [Math]::Max(0, $baseBitmap.Width - $cropWidth)
                $maxY = [Math]::Max(0, $baseBitmap.Height - $cropHeight)
                $cropX = if ($maxX -gt 0) { $hash[3] % ($maxX + 1) } else { 0 }
                $cropY = if ($maxY -gt 0) { $hash[4] % ($maxY + 1) } else { 0 }

                $sourceRect = [System.Drawing.Rectangle]::new($cropX, $cropY, $cropWidth, $cropHeight)
                $destRect = [System.Drawing.Rectangle]::new(0, 0, $canvas.Width, $canvas.Height)
                $graphics.DrawImage($baseBitmap, $destRect, $sourceRect, [System.Drawing.GraphicsUnit]::Pixel)

                $overlayBrush = [System.Drawing.SolidBrush]::new($overlayColor)
                try {
                    $graphics.FillRectangle($overlayBrush, 0, 0, $canvas.Width, $canvas.Height)
                } finally {
                    $overlayBrush.Dispose()
                }

                $topGlow = [System.Drawing.Rectangle]::new(-120, -80, [int]($canvas.Width * 0.75), [int]($canvas.Height * 0.45))
                $glowBrush = [System.Drawing.Drawing2D.LinearGradientBrush]::new(
                    $topGlow,
                    [System.Drawing.Color]::FromArgb(52, 255, 255, 255),
                    [System.Drawing.Color]::FromArgb(0, 255, 255, 255),
                    [System.Drawing.Drawing2D.LinearGradientMode]::ForwardDiagonal
                )
                try {
                    $graphics.FillEllipse($glowBrush, $topGlow)
                } finally {
                    $glowBrush.Dispose()
                }

                $shadeRect = [System.Drawing.Rectangle]::new(0, [int]($canvas.Height * 0.68), $canvas.Width, [int]($canvas.Height * 0.32))
                $shadeBrush = [System.Drawing.Drawing2D.LinearGradientBrush]::new(
                    $shadeRect,
                    [System.Drawing.Color]::FromArgb(0, 8, 12, 22),
                    [System.Drawing.Color]::FromArgb(72, 8, 12, 22),
                    [System.Drawing.Drawing2D.LinearGradientMode]::Vertical
                )
                try {
                    $graphics.FillRectangle($shadeBrush, $shadeRect)
                } finally {
                    $shadeBrush.Dispose()
                }

                $penColor = [System.Drawing.Color]::FromArgb(42 + ($hash[5] % 24), 255, 255, 255)
                $framePen = [System.Drawing.Pen]::new($penColor, 5)
                try {
                    $graphics.DrawRectangle($framePen, 0, 0, $canvas.Width - 1, $canvas.Height - 1)
                } finally {
                    $framePen.Dispose()
                }
            } finally {
                $graphics.Dispose()
            }

            $canvas.Save($OutputPath, [System.Drawing.Imaging.ImageFormat]::Png)
        } finally {
            $canvas.Dispose()
        }
    } finally {
        $baseBitmap.Dispose()
    }
}

if (-not (Test-Path $carsDir)) {
    New-Item -ItemType Directory -Path $carsDir | Out-Null
}

$content = Get-Content $seederPath -Raw
$titles = [System.Text.RegularExpressions.Regex]::Matches($content, "\['([^']+ 2023)'") |
    ForEach-Object { $_.Groups[1].Value } |
    Select-Object -Unique

$created = 0
$skipped = 0

foreach ($title in $titles) {
    $outputName = Get-Slug $title
    $outputPath = Join-Path $carsDir $outputName

    if (Test-Path $outputPath) {
        $skipped++
        continue
    }

    $baseName = Get-BaseImageName $title
    $basePath = Join-Path $carsDir $baseName

    if (-not (Test-Path $basePath)) {
        throw "Base image not found for '$title': $baseName"
    }

    New-VariantImage -BasePath $basePath -OutputPath $outputPath -Title $title
    $created++
}

Write-Output "CREATED=$created"
Write-Output "SKIPPED=$skipped"
