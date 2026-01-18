<?php

/*
 * Project Name: talent-rank-ahp
 * File: AdminPanelProvider.php
 * Created Date: Wednesday January 7th 2026
 * 
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/talent-rank-ahp/blob/main/LICENSE
 * 
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

namespace App\Providers\Filament;

use App\Filament\Pages\Profile;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
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
        'Perhitungan Final',
        'Pengaturan',
      ])
      ->pages([
        Dashboard::class,
      ])
      ->favicon(asset('favicon.png'))
      ->sidebarCollapsibleOnDesktop()
      ->maxContentWidth(Width::Full)
      ->topbar(false)
      ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
      ->widgets([
        // AccountWidget::class,
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
      ->plugins([
        FilamentShieldPlugin::make()
          ->navigationSort(10)
          ->navigationGroup('Pengaturan')
          ->navigationLabel('Hak Akses')
          ->modelLabel('Hak Akses')
          ->pluralModelLabel('Hak Akses')
          ->gridColumns([
            'default' => 2,
          ])
          ->checkboxListColumns([
            'default' => 1,
          ])
          ->resourceCheckboxListColumns([
            'default' => 2,
          ])
          ->sectionColumnSpan(1)
      ])
      ->renderHook(
        PanelsRenderHook::HEAD_END,
        fn(): HtmlString => new HtmlString('
          <style>
            *::-webkit-scrollbar { display: none; }
            * { -ms-overflow-style: none; scrollbar-width: none; }
          </style>
        ')
      );
    ;
  }
}
