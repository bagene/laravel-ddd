<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Contracts\RepositoryInterface;
use App\Shared\Exceptions\DatabaseTransactionException;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class AbstractRepository implements RepositoryInterface
{
    public function __construct(
        protected DatabaseManager $database,
        protected Model $model,
    ) {
    }

    public function transaction(callable $callback): mixed
    {
        try {
            $this->database->beginTransaction();
            $result = $callback();
            $this->database->commit();

            return $result;
        } catch (\Throwable $e) {
            Log::error("DATABASE TRANSACTION ERROR: {$e->getMessage()}");
            Log::critical($e->getTraceAsString());
            $this->database->rollBack();
            throw new DatabaseTransactionException($e->getMessage());
        }
    }

    public function findNextUuid(): string
    {
        return Str::uuid()->toString();
    }

    private function saveDTO(AbstractDTO $dto): void
    {
        foreach ($dto->toArray() as $key => $value) {
            $this->model->{$key} = $value;
        }

        $this->model->save();
    }

    /**
     * @throws DatabaseTransactionException
     */
    public function create(AbstractDTO $dto): Model
    {
        $this->transaction(fn () => $this->saveDTO($dto));

        return $this->model;
    }

    /**
     * @throws DatabaseTransactionException
     */
    public function update(Model $model, AbstractDTO $dto): Model
    {
        $this->model = $model;
        $this->transaction(fn () => $this->saveDTO($dto));

        return $model;
    }

    public function find(string|int $id): ?Model
    {
        return $this->model->query()->find($id);
    }

    /**
     * @inheritDoc
     */
    public function findBy(string $column, mixed $value, array $with = []): ?Model
    {
        return $this->model
            ->query()
            ->with($with)
            ->where($column, $value)
            ->first();
    }

    /**
     * @throws DatabaseTransactionException
     */
    public function delete(Model $model): bool
    {
        /** @var bool $result */
        $result = $this->transaction(fn () => $model->delete());
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function search(array $pagination = [], array $filters = [], array $with = []): LengthAwarePaginator
    {
        return $this->model->query()
            ->where($filters)
            ->with($with)
            ->paginate(...$pagination);
    }

    /**
     * @inheritDoc
     */
    public function get(array $filters = []): Collection
    {
        return $this->model->query()
            ->where($filters)
            ->get();
    }
}
