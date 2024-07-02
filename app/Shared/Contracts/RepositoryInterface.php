<?php

declare(strict_types=1);

namespace App\Shared\Contracts;

use App\Shared\AbstractDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    const DEFAULT_LIMIT = 10;

    public function transaction(callable $callback): mixed;

    public function create(AbstractDTO $dto): Model;

    public function update(Model $model, AbstractDTO $dto): Model;

    /**
     * @param  string[]  $with
     */
    public function find(string|int $id, array $with = []): ?Model;

    /**
     * @param  string[]  $with
     */
    public function findBy(string $column, mixed $value, array $with = []): ?Model;

    public function delete(Model $model): bool;

    /**
     * @param array{
     *    perPage?: int,
     *    page?: int,
     *    columns?: string[],
     *    pageName?: string,
     *    total?: int,
     * } $pagination
     * @param  array<string, mixed>  $filters
     * @param  string[]  $with
     * @return LengthAwarePaginator<Model>
     */
    public function search(array $pagination = [], array $filters = [], array $with = []): LengthAwarePaginator;

    /**
     * @param  array<string, mixed>  $filters
     * @return Collection<int, Model>
     */
    public function get(array $filters = []): Collection;
}
