<?php

namespace Asmit\FilamentUpload;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentUploadServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('asmit-filament-upload')
            ->hasViews();
    }

    public function packageBooted()
    {
        FilamentAsset::register([
            AlpineComponent::make(id: 'filepond-pdf', path: __DIR__.'/../resources/dist/js/advanced-file-upload.js')
                ->loadedOnRequest(),
            Css::make(id: 'filepond-pdf', path: __DIR__.'/../resources/css/advanced-file-upload.css'),
        ], package: 'asmit/filament-upload');
    }
}
