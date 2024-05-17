<?php

namespace App\Policies;

use App\Models\Cluster;
use App\Models\CompanyClusters;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClusterPolicy
{
    public function update(User $user, Cluster $cluster): bool
    {
        $companyCluster = CompanyClusters::query()->where('cluster_id', $cluster->id)->where(
            'user_id',
            $user->id
        )->first();
        return ($companyCluster->is_redactor);
    }


    public function delete(User $user, Cluster $cluster): bool
    {
        $companyCluster = CompanyClusters::query()->where('cluster_id', $cluster->id)->where(
            'user_id',
            $user->id
        )->first();
        return ($companyCluster->is_redactor);
    }


}
