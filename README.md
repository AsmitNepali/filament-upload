# Advance Upload
The **Advance Upload** plugin allow you to upload PDF file with preview along with the filament default file upload feature.

![Filament Upload Plugin](https://raw.githubusercontent.com/AsmitNepali/filament-upload/refs/heads/main/images/cover.jpg)
## Installation
You can install the package via composer:

```bash
  composer require asmit/filment-upload
```
## Publishing Assets
```bash
  phpp artisan filamnet:assets
 ```
## Usage
```php
use Asmit\FilamentUpload\Forms\Components\AdvanceFileUpload;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            AdvanceFileUpload::make('file')
                ->label('Upload PDF')
        ]);
}
```
## Credits
- [Asmit Nepal][link-asmit]
### Security

If you discover a security vulnerability within this package, please send an e-mail to asmitnepali99@gmail.com, All security vulnerabilities will be promptly addressed.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### 📄 License
The MIT License (MIT). Please see [License File](LICENSE.txt) for more information.

[link-asmit]: https://github.com/AsmitNepali
