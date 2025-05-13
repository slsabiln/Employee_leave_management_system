<?php

namespace App\Filament\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Models\LeaveRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Actions;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    public static function canCreate(): bool
    {
        return Gate::allows('edit-own-request', new LeaveRequest());
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('edit-own-request', $record);
    }

    public static function canDelete(Model $record): bool
    {
        return Gate::allows('edit-own-request', $record);
    }

    public static function canApprove(): bool
    {
        return Gate::allows('manage-leave-requests');
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label('Employee')
                ->relationship('employee', 'name')
                ->default(fn() => Auth::user()?->is_admin ? null : Auth::id())
                ->disabled(fn() => !Auth::user()?->is_admin)
                ->required(),


            Select::make('leave_type_id')
                ->label('Leave Type')
                ->relationship('leaveType', 'name')
                ->required(),

            DatePicker::make('from_date')->required(),
            DatePicker::make('to_date')->required(),

            Textarea::make('reason')->required(),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')->label('Employee'),
                TextColumn::make('leaveType.name')->label('Leave Type'),
                TextColumn::make('from_date')
                    ->label('From')
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)
                            ->locale(App::getLocale())
                            ->isoFormat('LL');
                    }),
                TextColumn::make('to_date')
                    ->label('To')
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)
                            ->locale(App::getLocale())
                            ->isoFormat('LL');
                    }),
                TextColumn::make('reason')->limit(30),
                TextColumn::make('to_date')
                    ->label('To')
                    ->formatStateUsing(function ($state) {
                        return \Carbon\Carbon::parse($state)
                            ->locale(\Illuminate\Support\Facades\App::getLocale())
                            ->isoFormat('LL');
                    }),
                BadgeColumn::make('status')
                    ->label(__('messages.status'))
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),

            ])
            ->actions([
                EditAction::make()
                    ->visible(fn($record) => Auth::check() && (Auth::user()->is_admin || Auth::user()->id === $record->employee_id)),

                DeleteAction::make()
                    ->visible(fn($record) => Auth::check() && (Auth::user()->is_admin || Auth::user()->id === $record->employee_id)),

                Action::make('approve')
                    ->label('Approve')
                    ->action(fn($record) => $record->update(['status' => 'approved']))
                    ->visible(fn() => Auth::check() && Auth::user()->is_admin),

                Action::make('reject')
                    ->label('Reject')
                    ->action(fn($record) => $record->update(['status' => 'rejected']))
                    ->visible(fn() => Auth::check() && Auth::user()->is_admin),

                Actions\Action::make('Approve')
                    ->label(__('messages.approve'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn() => Auth::user()?->is_admin)
                    ->action(function (LeaveRequest $record) {
                        $record->update(['status' => 'approved']);
                        Notification::make()
                            ->title(__('messages.leave_request') . ' ' . __('messages.approved'))
                            ->success()
                            ->send();
                    }),

                Actions\Action::make('Reject')
                    ->label(__('messages.reject'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn() => Auth::user()?->is_admin)
                    ->action(function (LeaveRequest $record) {
                        $record->update(['status' => 'rejected']);
                        Notification::make()
                            ->title(__('messages.leave_request') . ' ' . __('messages.rejected'))
                            ->danger()
                            ->send();
                    }),
            ]);
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
            'index' => Pages\ListLeaveRequests::route('/'),
            'create' => Pages\CreateLeaveRequest::route('/create'),
            'edit' => Pages\EditLeaveRequest::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!Auth::user()?->is_admin) {
            $query->where('employee_id', Auth::id());
        }

        return $query;
    }

    public static function filters(Filter $filter): array
    {
        return [
            SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->label('Status'),
        ];
    }
}
