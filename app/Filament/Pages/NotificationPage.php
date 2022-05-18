<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class NotificationPage extends Page
{
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.notification-page';

    // Send Notification to users, Send Notifications to Agent
    // Send Notifications to all
}
