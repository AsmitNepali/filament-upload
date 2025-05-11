<?php

namespace Asmit\FilamentUpload\Forms\Components;

use Asmit\FilamentUpload\Concerns\HasPdf;
use Filament\Forms\Components\FileUpload;

class AdvancedFileUpload extends FileUpload
{
    use HasPdf;

    protected string $view = 'asmit-filament-upload::forms.components.advanced-file-upload';
}
