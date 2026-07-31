<?php

namespace Asmit\FilamentUpload\Tests;

use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;

class TestLivewireComponent extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public function render(): string
    {
        return '<div></div>';
    }
}
