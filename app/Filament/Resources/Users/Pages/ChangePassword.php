<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class ChangePassword extends Page
{
    use InteractsWithRecord;
    use HasPageSidebar;

    protected static string $resource = UserResource::class;

    protected string $view = 'filament.resources.users.pages.change-password';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
