<?php

namespace App\Filament\Pages;

use App\Actions\SendNotificationAction;
use App\DTOs\SendMessageData;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;

class NotificationPage extends Page
{
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.notification-page';

    protected function getFormSchema(): array
    {
        return [
            Grid::make(5)
                ->schema([
                    TextInput::make('title')
                        ->label(__('TITLE'))
                        ->required()
                        ->placeholder(__('Message Title'))
                        ->columnSpan(3),
                    Textarea::make('body')
                        ->label(__('MESSAGE'))
                        ->required()
                        ->placeholder(__('Write notification message here...'))
                        ->columnSpan(5)
                ])
        ];
    }

    public function sendMessage()
    {
        SendNotificationAction::execute(
            SendMessageData::fromArray(
                $this->form->getData()
            )
        );
    }

    // Send Notification to users, Send Notifications to Agent
    // Send Notifications to all
}
