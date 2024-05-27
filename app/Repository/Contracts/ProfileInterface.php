<?php

namespace App\Repository\Contracts;

use App\Models\Users\Profile;
use App\Http\Resources\ProfileResource;



interface ProfileInterface
{
    // Define your methods here
    public function getProfile(Profile|string $profile): ProfileResource;
    public function create($user): Profile;
    public function update(Profile|string $profile, array $payload): ProfileResource;
    public function  userprofileupdate($user, array $payload): Profile;
}