<?php

namespace Asmit\FilamentUpload\Tests;

use Asmit\FilamentUpload\Enums\PdfViewFit;
use Asmit\FilamentUpload\FilamentUploadServiceProvider;
use Asmit\FilamentUpload\Infolists\Components\PdfEntry;
use Filament\Schemas\Schema;
use Orchestra\Testbench\TestCase;

class PdfEntryTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            \BladeUI\Icons\BladeIconsServiceProvider::class,
            \BladeUI\Heroicons\BladeHeroiconsServiceProvider::class,
            \Livewire\LivewireServiceProvider::class,
            \Filament\Support\SupportServiceProvider::class,
            \Filament\Actions\ActionsServiceProvider::class,
            \Filament\Schemas\SchemasServiceProvider::class,
            \Filament\Infolists\InfolistsServiceProvider::class,
            \Filament\Forms\FormsServiceProvider::class,
            \Filament\Notifications\NotificationsServiceProvider::class,
            FilamentUploadServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('filesystems.disks.public', [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => 'http://localhost/storage',
            'visibility' => 'public',
        ]);

        $app['config']->set('filament.default_filesystem_disk', 'public');
    }

    private function render(PdfEntry $entry, mixed $state): string
    {
        $entry->container(Schema::make(new TestLivewireComponent)->components([$entry]));
        $entry->state($state);

        return $entry->toHtml();
    }

    public function test_it_renders_an_iframe_using_the_pdf_options(): void
    {
        $html = $this->render(
            PdfEntry::make('document')
                ->label('Uploaded PDF')
                ->pdfPreviewHeight(500)
                ->pdfToolbar(true)
                ->pdfNavPanes(true)
                ->pdfDisplayPage(3)
                ->pdfZoomLevel(120)
                ->pdfFitType(PdfViewFit::FIT)
                ->downloadable()
                ->openable(),
            'docs/report.pdf',
        );

        $this->assertStringContainsString('<iframe', $html);
        $this->assertStringContainsString('http://localhost/storage/docs/report.pdf#', $html);
        $this->assertStringContainsString('toolbar=1', $html);
        $this->assertStringContainsString('navpanes=1', $html);
        $this->assertStringContainsString('page=3', $html);
        $this->assertStringContainsString('zoom=120', $html);
        $this->assertStringContainsString('view=Fit', $html);
        $this->assertStringContainsString('height: 500px', $html);
        $this->assertStringContainsString('Uploaded PDF', $html);
        $this->assertStringContainsString('Download', $html);
        $this->assertStringContainsString('Open', $html);
    }

    public function test_it_renders_every_file_when_the_state_is_an_array(): void
    {
        $html = $this->render(PdfEntry::make('documents'), ['a.pdf', 'b.pdf']);

        $this->assertStringContainsString('storage/a.pdf', $html);
        $this->assertStringContainsString('storage/b.pdf', $html);
        $this->assertSame(2, substr_count($html, '<iframe'));
    }

    public function test_it_renders_the_placeholder_when_there_is_no_file(): void
    {
        $html = $this->render(PdfEntry::make('document')->placeholder('No file'), null);

        $this->assertStringNotContainsString('<iframe', $html);
        $this->assertStringContainsString('No file', $html);
    }

    public function test_it_evaluates_closures_at_render_time(): void
    {
        $html = $this->render(
            PdfEntry::make('document')
                ->pdfToolbar(fn (): bool => true)
                ->downloadable(fn (): bool => false),
            'a.pdf',
        );

        $this->assertStringContainsString('toolbar=1', $html);
        $this->assertStringNotContainsString('Download', $html);
    }

    public function test_it_leaves_absolute_urls_untouched(): void
    {
        $html = $this->render(PdfEntry::make('document'), 'https://example.com/a.pdf');

        $this->assertStringContainsString('https://example.com/a.pdf#', $html);
    }
}
