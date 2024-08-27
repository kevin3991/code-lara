<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected const MODEL = null;

    public function create($data)
    {
        return $this->query()->create($data);
    }

    public function find($id)
    {
        return $this->query()->findOrFail($id);
    }

    public function isExist($id)
    {
        return $this->query()->find($id) !== null;
    }

    public function getOne($where_data, $where_in_data = [], $used_lock = false)
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data, $used_lock) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
            if ($used_lock) {
                $query->lockForUpdate();
            }
        })->first();
    }

    public function getAll($where_data, $where_in_data = [], $used_lock = false)
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data, $used_lock) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
            if ($used_lock) {
                $query->lockForUpdate();
            }
        })->get();
    }

    public function getAllByPage($where_data = [], $where_in_data = [], $per_page = 10)
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
        })->paginate($per_page);
    }

    public function getAllByCursorPage($where_data = [], $where_in_data = [], $per_page = 10)
    {
        return $this->query()->where(function ($query) use ($where_data, $where_in_data) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
        })->cursorPaginate($per_page);
    }

    /**
     * 觸發 Observer.
     */
    public function update($where_data, $update_data)
    {
        $where_result = $this->query()->where(function ($query) use ($where_data) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
        })->get();
        $where_result = $where_result->toarray();
        foreach ($where_result as $key => $value) {
            $model = $this->query()->find($value['id']);
            foreach ($update_data as $update_key => $update_value) {
                $model[$update_key] = $update_value;
            }
            $model->update();
        }
    }

    public function updateOrCreate($v_data, $update_data)
    {
        return $this->query()->updateOrCreate($v_data, $update_data);
    }

    public function delete($where_data, $where_in_data = [], $force = false)
    {
        $query = $this->query()->where(function ($query) use ($where_data, $where_in_data) {
            foreach ($where_data as $key => $value) {
                $query->where($key, $value);
            }
            foreach ($where_in_data as $key => $value) {
                $query->whereIn($key, $value);
            }
        });

        if ($force) {
            $query->forceDelete();
        } else {
            $query->delete();
        }
    }

    public function firstOrCreate($first_data, $create_data)
    {
        return $this->query()->firstOrCreate($first_data, $create_data);
    }

    public function query()
    {
        if (static::MODEL === null) {
            throw new \LogicException('MODEL constant must be defined in child class.');
        }

        return \call_user_func(static::MODEL.'::query');
    }
}
