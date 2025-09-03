<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ChangePassword;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ManageUser;
use App\Filament\Resources\Users\Pages\UserDashboard;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'main';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
            'dashboard' => UserDashboard::route('{record}/dashboard'),
            'manage' => ManageUser::route('{record}/manage'),
            'password' => ChangePassword::route('{record}/password'),
        ];
    }

    public static function sidebar(User $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
//            ->topbarNavigation()
            ->setTitle('Sidebar title')
            ->setDescription('Sidebar description')
            ->setNavigationItems([
                PageNavigationItem::make('User Dashboard')
                    ->group('User')
                    ->visible(false)
                    ->url(function () use ($record) {
                        return UserDashboard::getUrl(['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.dashboard');
                    }),
                PageNavigationItem::make('View User')
                    ->group('User')
                    ->url(function () use ($record) {
                        return ViewUser::getUrl(['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.view');
                    }),
                PageNavigationItem::make('Edit User')
                    ->group('User')
                    ->url(function () use ($record) {
                        return EditUser::getUrl(['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.edit');
                    }),
                PageNavigationItem::make('Manage User')
                    ->group('Manage')
                    ->url(function () use ($record) {
                        return ManageUser::getUrl(['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.manage');
                    })
                    ->badge(10),
                PageNavigationItem::make('Change Password')
                    ->url(function () use ($record) {
                        return static::getUrl('password', ['record' => $record->id]);
                    })
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName() . '.password');
                    })
                    ->badge(5),

            ]);
    }
}
