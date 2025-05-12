<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Resources\Resource;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Manage Employees';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_name')
                    ->label('Employee Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('employee_number')
                    ->label('Employee Number')
                    ->required()
                    ->unique()
                    ->maxLength(255),

                Forms\Components\TextInput::make('mobile_number')
                    ->label('Mobile Number')
                    ->required()
                    ->maxLength(15)
                    ->tel(),

                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->maxLength(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_name')
                    ->label('Employee Name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('employee_number')
                    ->label('Employee Number')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mobile_number')
                    ->label('Mobile Number')
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label('Address')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageEmployees::route('/'),
        ];
    }
}
