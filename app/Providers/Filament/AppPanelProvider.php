<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\TestRunResource;
use App\Filament\Resources\TestCaseResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Support\Enums\Width;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('app')
            ->path('/')
            ->font('Poppins')
            ->login()
            ->registration()
            ->passwordReset()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->navigation(function (NavigationBuilder $build): NavigationBuilder {
                return $build->groups([
                    NavigationGroup::make()
                        ->items([
                            ...Dashboard::getNavigationItems(),
                            ...ProjectResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Design')
                        ->items([
                            ...TestCaseResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Build')
                        ->items([
                            ...TestRunResource::getNavigationItems(),
                        ]),
                    NavigationGroup::make('Settings')
                        ->items([
                            ...(Auth::user()->hasRole('admin') ? UserResource::getNavigationItems() : []),
                            ...(Auth::user()->hasRole('admin') ? RoleResource::getNavigationItems() : []),
                        ]),
                ]);
            })
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
