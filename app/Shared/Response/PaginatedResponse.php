<?php

declare(strict_types=1);

namespace App\Shared\Response;

use App\Shared\Traits\StaticConstructor;
use App\Shared\Traits\ToArray;
use Infrastructure\Services\QueryBus\Contracts\QueryResponseInterface;

final class PaginatedResponse implements QueryResponseInterface
{
    use StaticConstructor, ToArray;

    /**
     * @param  array<string, mixed>  $data
     * @param array{
     *     url: string,
     *     label: string,
     *     active: bool,
     * } $links
     */
    private function __construct(
        private readonly int $currentPage,
        private readonly array $data,
        private readonly string $firstPageUrl,
        private readonly int $from,
        private readonly int $lastPage,
        private readonly string $lastPageUrl,
        private readonly array $links,
        private readonly ?string $nextPageUrl,
        private readonly string $path,
        private readonly int $perPage,
        private readonly ?string $prevPageUrl,
        private readonly int $to,
        private readonly int $total,
    ) {}

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getFirstPageUrl(): string
    {
        return $this->firstPageUrl;
    }

    public function getFrom(): int
    {
        return $this->from;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getLastPageUrl(): string
    {
        return $this->lastPageUrl;
    }

    /**
     * @return array{
     *      url: string,
     *      label: string,
     *      active: bool,
     *  }
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    public function getNextPageUrl(): ?string
    {
        return $this->nextPageUrl;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getPrevPageUrl(): ?string
    {
        return $this->prevPageUrl;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getTo(): int
    {
        return $this->to;
    }
}
