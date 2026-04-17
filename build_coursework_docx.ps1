$ErrorActionPreference = 'Stop'

$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$htmlPath = Join-Path $root 'coursework.html'
$outputPath = Join-Path $root 'kursovaya_pm09_po_metodichke.docx'
$zipPath = Join-Path $root 'kursovaya_pm09_po_metodichke.zip'
$tempDir = Join-Path $root 'tmp_coursework_docx'

if (Test-Path $tempDir) {
    Remove-Item -LiteralPath $tempDir -Recurse -Force
}

New-Item -ItemType Directory -Path $tempDir | Out-Null
New-Item -ItemType Directory -Path (Join-Path $tempDir '_rels') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $tempDir 'word') | Out-Null
New-Item -ItemType Directory -Path (Join-Path $tempDir 'word\_rels') | Out-Null

$contentTypes = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
  <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
  <Default Extension="xml" ContentType="application/xml"/>
  <Default Extension="html" ContentType="text/html"/>
  <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
</Types>
'@

$rootRels = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>
'@

$documentXml = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main"
            xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
  <w:body>
    <w:altChunk r:id="htmlChunk"/>
    <w:sectPr>
      <w:pgSz w:w="11906" w:h="16838"/>
      <w:pgMar w:top="1134" w:right="567" w:bottom="1134" w:left="1134" w:header="709" w:footer="709" w:gutter="0"/>
      <w:cols w:space="708"/>
      <w:docGrid w:linePitch="360"/>
    </w:sectPr>
  </w:body>
</w:document>
'@

$documentRels = @'
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
  <Relationship Id="htmlChunk" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/aFChunk" Target="afchunk.html"/>
</Relationships>
'@

Set-Content -LiteralPath (Join-Path $tempDir '[Content_Types].xml') -Value $contentTypes -Encoding UTF8
Set-Content -LiteralPath (Join-Path $tempDir '_rels\.rels') -Value $rootRels -Encoding UTF8
Set-Content -LiteralPath (Join-Path $tempDir 'word\document.xml') -Value $documentXml -Encoding UTF8
Set-Content -LiteralPath (Join-Path $tempDir 'word\_rels\document.xml.rels') -Value $documentRels -Encoding UTF8
Copy-Item -LiteralPath $htmlPath -Destination (Join-Path $tempDir 'word\afchunk.html')

if (Test-Path $outputPath) {
    Remove-Item -LiteralPath $outputPath -Force
}
if (Test-Path $zipPath) {
    Remove-Item -LiteralPath $zipPath -Force
}

Compress-Archive -LiteralPath (Join-Path $tempDir '[Content_Types].xml'),
    (Join-Path $tempDir '_rels'),
    (Join-Path $tempDir 'word') -DestinationPath $zipPath

Move-Item -LiteralPath $zipPath -Destination $outputPath

Remove-Item -LiteralPath $tempDir -Recurse -Force
Write-Output "CREATED: $outputPath"
