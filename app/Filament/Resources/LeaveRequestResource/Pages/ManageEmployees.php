<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ManageEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(), // إضافة زر لإضافة موظف جديد
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'employee_name' => [
                'label' => 'Employee Name',
                'sortable' => true,
                'searchable' => true,
            ],
            'employee_number' => [
                'label' => 'Employee Number',
                'sortable' => true,
            ],
            'mobile_number' => [
                'label' => 'Mobile Number',
                'sortable' => true,
            ],
            'address' => [
                'label' => 'Address',
                'sortable' => false,
            ],
            'created_at' => [
                'label' => 'Created At',
                'sortable' => true,
                'format' => 'datetime',
            ],
        ];
    }
}
