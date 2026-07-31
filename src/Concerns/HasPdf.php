<?php

namespace Asmit\FilamentUpload\Concerns;

use Asmit\FilamentUpload\Enums\PdfViewFit;
use Closure;

trait HasPdf
{
    protected int|Closure $pdfPreviewHeight = 320;

    protected int|Closure $pdfDisplayPage = 1;

    protected bool|Closure $pdfToolbar = false;

    protected int|Closure $pdfZoomLevel = 100;

    protected PdfViewFit|string|Closure $pdfFitType = PdfViewFit::FITH;

    protected bool|Closure $pdfNavPanes = false;

    public function pdfPreviewHeight(int|Closure $height): static
    {
        $this->pdfPreviewHeight = $height;

        return $this;
    }

    public function pdfDisplayPage(int|Closure $page): static
    {
        $this->pdfDisplayPage = $page;

        return $this;
    }

    public function pdfToolbar(bool|Closure $condition = true): static
    {
        $this->pdfToolbar = $condition;

        return $this;
    }

    public function pdfZoomLevel(int|Closure $level): static
    {
        $this->pdfZoomLevel = $level;

        return $this;
    }

    public function pdfFitType(PdfViewFit|string|Closure $type): static
    {
        $this->pdfFitType = $type;

        return $this;
    }

    public function pdfNavPanes(bool|Closure $condition = true): static
    {
        $this->pdfNavPanes = $condition;

        return $this;
    }

    public function getPdfPreviewHeight(): int
    {
        return (int) $this->evaluate($this->pdfPreviewHeight);
    }

    public function getPdfDisplayPage(): int
    {
        return (int) $this->evaluate($this->pdfDisplayPage);
    }

    public function getPdfToolbar(): bool
    {
        return (bool) $this->evaluate($this->pdfToolbar);
    }

    public function getPdfZoomLevel(): int
    {
        return (int) $this->evaluate($this->pdfZoomLevel);
    }

    public function getFit(): string
    {
        return $this->getPdfFitType();
    }

    public function getPdfFitType(): string
    {
        $type = $this->evaluate($this->pdfFitType);

        return $type instanceof PdfViewFit ? $type->value : $type;
    }

    public function getPdfNavPanes(): bool
    {
        return (bool) $this->evaluate($this->pdfNavPanes);
    }

    /**
     * URL fragment understood by the browser's built-in PDF viewer.
     */
    public function getPdfUrlFragment(): string
    {
        return '#'.http_build_query([
            'toolbar' => $this->getPdfToolbar() ? 1 : 0,
            'navpanes' => $this->getPdfNavPanes() ? 1 : 0,
            'scrollbar' => 0,
            'statusbar' => 0,
            'view' => $this->getPdfFitType(),
            'zoom' => $this->getPdfZoomLevel(),
            'page' => $this->getPdfDisplayPage(),
        ]);
    }
}
