param(
    [string]$OutputZip = "D:\ilnz-main\ilnz-main\carhut-beget-package.zip"
)

$projectRoot = "D:\ilnz-main\ilnz-main"
$stageDir = Join-Path $projectRoot ".beget-package"

if (Test-Path $stageDir) {
    Remove-Item -LiteralPath $stageDir -Recurse -Force
}

New-Item -ItemType Directory -Path $stageDir | Out-Null

$include = @(
    "app",
    "bootstrap",
    "config",
    "database",
    "public",
    "resources",
    "routes",
    "storage",
    "vendor",
    "artisan",
    "composer.json",
    "composer.lock",
    ".env.beget.example",
    "DEPLOY_BEGET.md",
    "tools\deploy\beget"
)

foreach ($item in $include) {
    $source = Join-Path $projectRoot $item
    if (Test-Path $source) {
        Copy-Item -Path $source -Destination $stageDir -Recurse -Force
    }
}

$envExample = Join-Path $stageDir ".env.beget.example"
$envTarget = Join-Path $stageDir ".env"
Copy-Item -LiteralPath $envExample -Destination $envTarget -Force

if (Test-Path $OutputZip) {
    Remove-Item -LiteralPath $OutputZip -Force
}

Compress-Archive -Path (Join-Path $stageDir "*") -DestinationPath $OutputZip -Force

Write-Output "PACKAGE_READY=$OutputZip"
