<?php

namespace Asmit\FilamentUpload\Concerns;

use Asmit\FilamentUpload\Enums\PdfViewFit;

trait HasPdf
{
    protected int $pdfPreviewHeight = 320;

    protected int $pdfDisplayPage = 1;

    protected bool $pdfToolbar = false;

    protected int $getPdfZoomLevel = 100;

    protected string $pdfFitType = PdfViewFit::FITH->value;

    protected bool $pdfNavPanes = false;

    public function pdfPreviewHeight(int $height): static
    {
        $this->pdfPreviewHeight = $height;

        return $this;
    }

    public function pdfDisplayPage(int $page): static
    {
        $this->pdfDisplayPage = $page;

        return $this;
    }

    public function pdfToolbar(bool|\Closure $condition): static
    {
        $this->pdfToolbar = $this->evaluate($condition);

        return $this;
    }

    public function pdfZoomLevel(int $level): static
    {
        $this->getPdfZoomLevel = $level;

        return $this;
    }

    public function pdfFitType(PdfViewFit $type): static
    {
        $this->pdfFitType = $type->value;

        return $this;
    }

    public function pdfNavPanes(bool|\Closure $condition): static
    {
        $this->pdfNavPanes = $this->evaluate($condition);

        return $this;
    }

    public function getPdfPreviewHeight(): int
    {
        return $this->pdfPreviewHeight;
    }

    public function getPdfDisplayPage(): int
    {
        return $this->pdfDisplayPage;
    }

    public function getPdfToolbar(): bool
    {
        return $this->pdfToolbar;
    }

    public function getPdfZoomLevel(): int
    {
        return $this->getPdfZoomLevel;
    }

    public function getFit(): string
    {
        return $this->pdfFitType;
    }

    public function getPdfFitType(): string
    {
        return $this->pdfFitType;
    }

    public function getPdfNavPanes(): bool
    {
        return $this->pdfNavPanes;
    }
}
