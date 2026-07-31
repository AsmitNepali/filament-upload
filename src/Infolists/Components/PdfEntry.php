<?php

namespace Asmit\FilamentUpload\Infolists\Components;

use Asmit\FilamentUpload\Concerns\HasPdf;
use Closure;
use Filament\Infolists\Components\Entry;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PdfEntry extends Entry
{
    use HasPdf;

    protected string $view = 'asmit-filament-upload::infolists.components.pdf-entry';

    protected string|Closure|null $disk = null;

    protected string|Closure|null $visibility = 'public';

    protected int|Closure $temporaryUrlExpiration = 5;

    protected bool|Closure $isDownloadable = false;

    protected bool|Closure $isOpenable = false;

    public function disk(string|Closure|null $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function visibility(string|Closure|null $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Minutes a temporary URL stays valid for, on private disks that support them.
     */
    public function temporaryUrlExpiration(int|Closure $minutes): static
    {
        $this->temporaryUrlExpiration = $minutes;

        return $this;
    }

    public function downloadable(bool|Closure $condition = true): static
    {
        $this->isDownloadable = $condition;

        return $this;
    }

    public function openable(bool|Closure $condition = true): static
    {
        $this->isOpenable = $condition;

        return $this;
    }

    public function getDisk(): string
    {
        return $this->evaluate($this->disk)
            ?? config('filament.default_filesystem_disk')
            ?? config('filesystems.default');
    }

    public function getVisibility(): ?string
    {
        return $this->evaluate($this->visibility);
    }

    public function getTemporaryUrlExpiration(): int
    {
        return (int) $this->evaluate($this->temporaryUrlExpiration);
    }

    public function isDownloadable(): bool
    {
        return (bool) $this->evaluate($this->isDownloadable);
    }

    public function isOpenable(): bool
    {
        return (bool) $this->evaluate($this->isOpenable);
    }

    public function getFileUrl(string $path): ?string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $storage = Storage::disk($this->getDisk());

        if ($this->getVisibility() === 'private') {
            try {
                return $storage->temporaryUrl($path, now()->addMinutes($this->getTemporaryUrlExpiration()));
            } catch (Throwable) {
                // ponytail: driver has no temporary URLs (local, public), fall through to the plain URL
            }
        }

        return $storage->url($path);
    }

    /**
     * @return array<string, string> file name keyed by URL
     */
    public function getFiles(): array
    {
        $state = $this->getState();

        if ($state instanceof Collection) {
            $state = $state->all();
        }

        $files = [];

        foreach (Arr::wrap($state) as $path) {
            if (! is_string($path) || blank($path)) {
                continue;
            }

            if (blank($url = $this->getFileUrl($path))) {
                continue;
            }

            $files[$url] = basename($path);
        }

        return $files;
    }
}
