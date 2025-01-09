<?php

namespace App\Mapper\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IWorkTripMapper
{
    public function mapTripPairActualValue(array $tripState): array;
    public function mapPairInfoAndTripActualValue(array $infos, array $tripState): array;
    public function mapTripUnpairActualValue(array $tripState): array;
}
