<?php

namespace App\Providers\Filament;

use App\Filament\AvatarProviders\AvatarPlaceHolder;
use App\Filament\Pages\Profile;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Auth;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
  public function panel(Panel $panel): Panel
  {
    return $panel
      ->default()
      ->id('admin')
      ->path('admin')
      ->brandName(config('app.name'))
      ->spa()
      ->login()
      ->registration(false)
      ->profile(Profile::class)
      ->userMenuItems([
        'profile' => function (Action $action) {
          $action->visible(function () {
            return Auth::user()->id === 1;
          });
        },
      ])
      ->databaseNotifications()
      ->passwordReset()
      ->multiFactorAuthentication([
        AppAuthentication::make()
          ->recoverable()
          ->recoveryCodeCount(8)
          ->regenerableRecoveryCodes(false)
          ->brandName(config('app.name')),
        EmailAuthentication::make()
          ->codeExpiryMinutes(10),
      ], isRequired: false)
      ->colors([
        'primary' => Color::Emerald,
      ])
      ->unsavedChangesAlerts()
      ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
      ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
      ->navigationGroups([
        'Kriteria',
        'Alternatif',
        'Logs',
      ])
      ->defaultAvatarProvider(AvatarPlaceHolder::class)
      ->pages([
        Dashboard::class,
      ])
      ->favicon(asset('favicon.png'))
      ->sidebarCollapsibleOnDesktop()
      ->maxContentWidth(Width::Full)
      ->topbar(false)
      ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
      ->widgets([
        AccountWidget::class,
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
      ])
      ->renderHook(
        PanelsRenderHook::HEAD_END,
        fn(): HtmlString => new HtmlString('
          <style>
            *::-webkit-scrollbar { display: none; }
            * { -ms-overflow-style: none; scrollbar-width: none; }
          </style>
        ')
      );;
  }
}
