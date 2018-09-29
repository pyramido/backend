<?php
namespace App\Http\Resources;

class UserResource extends PublicUserResource implements UserResourceInterface
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), ['email' => $this->email]);
    }
}
