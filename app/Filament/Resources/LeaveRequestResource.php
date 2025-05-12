<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveRequestResource\Pages;
use App\Models\LeaveRequest;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
class LeaveRequestResource extends Resource
{
    protected static ?string $model = LeaveRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('employee_id')
                ->label('Employee')
                ->relationship('employee', 'name')
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
        return $table->columns([
            TextColumn::make('employee.name')->label('Employee'),
            TextColumn::make('leaveType.name')->label('Leave Type'),
            TextColumn::make('from_date')->date(),
            TextColumn::make('to_date')->date(),
            TextColumn::make('reason')->limit(30),
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
}
