#!/usr/bin/env bash
set -euo pipefail
ROOT="/Users/manojkumar/Sites/koro-platform"
cd "$ROOT"

mkdir -p Modules/Core/app/{Models,Services,Http/Controllers,Filament/Resources,Providers/Filament}
mkdir -p Modules/Core/database/migrations
mkdir -p Modules/Payments/app/{Models,Services,Contracts,Http/Controllers,Filament/Resources,Providers/Filament}
mkdir -p Modules/Payments/database/migrations
mkdir -p Modules/Ecommerce/app/{Models,Http/Controllers,Filament/Resources,Providers/Filament}
mkdir -p Modules/Ecommerce/database/migrations
mkdir -p Modules/Ecommerce/resources/views/{shop,layouts}
mkdir -p Modules/Crm/app/{Models,Filament/Resources,Providers/Filament}
mkdir -p Modules/Crm/database/migrations
mkdir -p Modules/Cms/app/{Models,Http/Controllers,Filament/Resources,Providers/Filament}
mkdir -p Modules/Cms/database/migrations
mkdir -p Modules/Cms/resources/views/{pages,layouts}
mkdir -p Modules/Erp/app/{Models,Filament/Resources,Providers/Filament}
mkdir -p Modules/Erp/database/migrations
mkdir -p Modules/Api/app/Http/Controllers/V1
mkdir -p resources/views/layouts
mkdir -p docs .cursor/rules

echo "Directories created."
