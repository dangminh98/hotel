<?php

namespace App\Repositories\Location;

use App\Models\Location;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class LocationRepository extends EloquentRepository
{
    public function getModel()
    {
        return Location::class;
    }

    public function delete($id)
    {
        $check = $this->checkOriginal($id);
        $location = $this->findOrFail($id);
        if ($check) {
            DB::beginTransaction();
            try {
                $location->locations()->delete();
                $location->delete();
                DB::commit();

                return true;
            } catch (\Exception $exception) {
                DB::rollBack();

                return false;
            }

        } else {
            $location->delete();

            return true;
        }
    }
}