# Advanced Upload
The **Advanced Upload** plugin allows you to upload PDF files with preview functionality along with Filament's default file upload features. This package provides a seamless way to handle PDF uploads with customizable preview options.

![Filament Upload Plugin](https://raw.githubusercontent.com/AsmitNepali/filament-upload/refs/heads/main/images/cover.jpg)

## Features
- PDF file upload with live preview
- Inline PDF viewer for infolists
- Customizable preview height
- Configurable page display
- Optional toolbar controls
- Adjustable zoom levels
- Multiple fit types for PDF display
- Optional navigation panes
- Seamless integration with Filament forms and infolists

## Installation
You can install the package via composer:

```bash
composer require asmit/filament-upload
```

## Publishing Assets
```bash
php artisan filament:assets
```

## Usage

### Forms
```php
use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            AdvancedFileUpload::make('file')
                ->label('Upload PDF')
                ->pdfPreviewHeight(400) // Customize preview height
                ->pdfDisplayPage(1) // Set default page
                ->pdfToolbar(true) // Enable toolbar
                ->pdfZoomLevel(100) // Set zoom level
                ->pdfFitType(PdfViewFit::FIT) // Set fit type
                ->pdfNavPanes(true) // Enable navigation panes
        ]);
}
```

### Infolists
`PdfEntry` embeds a stored PDF directly in the panel, so uploads can be reviewed without leaving it.

```php
use Asmit\FilamentUpload\Infolists\Components\PdfEntry;

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            PdfEntry::make('document')
                ->label('Uploaded PDF')
                ->pdfPreviewHeight(500) // Customize preview height
                ->pdfToolbar(true) // Enable toolbar
                ->downloadable() // Show a "Download" link
                ->openable(), // Show an "Open in new tab" link
        ]);
}
```

The entry takes the same PDF options as the form component. It reads the file from Filament's default
filesystem disk unless told otherwise, and renders one viewer per file when the state is an array
(i.e. for `multiple()` uploads):

```php
PdfEntry::make('documents')
    ->disk('s3')
    ->visibility('private') // Uses a temporary URL when the disk supports one
    ->temporaryUrlExpiration(10) // Minutes, default 5
```

## Configuration Options

| Method | Description | Default |
|--------|-------------|---------|
| `pdfPreviewHeight()` | Set the height of PDF preview | 320px |
| `pdfDisplayPage()` | Set the default page to display | 1 |
| `pdfToolbar()` | Enable/disable toolbar controls | false |
| `pdfZoomLevel()` | Set the zoom level percentage | 100 |
| `pdfFitType()` | Set the PDF fit type | FIT |
| `pdfNavPanes()` | Enable/disable navigation panes | false |

### `PdfEntry` only

| Method | Description | Default |
|--------|-------------|---------|
| `disk()` | Filesystem disk the file lives on | `filament.default_filesystem_disk` |
| `visibility()` | File visibility, `private` opts into temporary URLs | `public` |
| `temporaryUrlExpiration()` | Lifetime of a temporary URL, in minutes | 5 |
| `downloadable()` | Show a download link under the viewer | false |
| `openable()` | Show an "open in new tab" link under the viewer | false |

All of the above also accept a closure, evaluated when the entry renders.

## Testing
```bash
composer install
./vendor/bin/phpunit
```

## Credits
- [Kishan Sunar][link-kishan]
- [Asmit Nepal][link-asmit]

### Security

If you discover a security vulnerability within this package, please send an e-mail to asmitnepali99@gmail.com. All security vulnerabilities will be promptly addressed.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### 📄 License
The MIT License (MIT). Please see [License File](LICENSE.txt) for more information.

[link-asmit]: https://github.com/AsmitNepali
[link-kishan]: https://github.com/Kishan-Sunar
