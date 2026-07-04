<?php

namespace Modules\Core\Services;

use Modules\Core\Models\Integration;

class IntegrationService
{
    public function store(string $provider, string $name, array $credentials, array $metadata = []): Integration
    {
        return Integration::query()->updateOrCreate(
            ['provider' => $provider, 'name' => $name],
            [
                'credentials' => $credentials,
                'metadata' => $metadata,
                'is_active' => true,
            ]
        );
    }

    public function credentials(string $provider, ?string $name = null): ?array
    {
        $query = Integration::query()
            ->where('provider', $provider)
            ->where('is_active', true);

        if ($name) {
            $query->where('name', $name);
        }

        return $query->first()?->credentials;
    }

    public function deactivate(Integration $integration): void
    {
        $integration->update(['is_active' => false]);
    }
}
