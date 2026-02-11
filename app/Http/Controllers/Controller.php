<?php

namespace App\Http\Controllers;

use App\Models\Region;

abstract class Controller
{
    protected function getManagedRegionIds($user)
    {
        if ($user->hasRole('super-admin') || $user->hasRole('national-admin')) {
            return Region::pluck('id')->toArray();
        }

        if ($user->hasAnyRole(['province-admin', 'regency-admin', 'district-admin']) && $user->region_id) {
            // Get current region and all children
            $region = Region::with('children')->find($user->region_id);
            if (!$region) return [];

            $ids = [$region->id];
            
            $ids = array_merge($ids, $this->getChildRegionIds($region));
            
            return $ids;
        }

        return [];
    }

    protected function getChildRegionIds($region)
    {
        $ids = [];
        foreach ($region->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getChildRegionIds($child));
        }
        return $ids;
    }
}
