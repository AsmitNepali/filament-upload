# Advanced Upload
The **Advanced Upload** plugin allows you to upload PDF files with preview functionality along with Filament's default file upload features. This package provides a seamless way to handle PDF uploads with customizable preview options.

![Filament Upload Plugin](https://raw.githubusercontent.com/AsmitNepali/filament-upload/refs/heads/main/images/cover.jpg)

## Features
- PDF file upload with live preview
- Customizable preview height
- Configurable page display
- Optional toolbar controls
- Adjustable zoom levels
- Multiple fit types for PDF display
- Optional navigation panes
- Seamless integration with Filament forms

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

## Configuration Options

| Method | Description | Default |
|--------|-------------|---------|
| `pdfPreviewHeight()` | Set the height of PDF preview | 320px |
| `pdfDisplayPage()` | Set the default page to display | 1 |
| `pdfToolbar()` | Enable/disable toolbar controls | false |
| `pdfZoomLevel()` | Set the zoom level percentage | 100 |
| `pdfFitType()` | Set the PDF fit type | FIT |
| `pdfNavPanes()` | Enable/disable navigation panes | false |

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
