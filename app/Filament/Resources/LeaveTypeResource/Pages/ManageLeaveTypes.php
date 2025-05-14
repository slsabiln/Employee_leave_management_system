<?php

namespace App\Filament\Resources\LeaveTypeResource\Pages;

use App\Filament\Resources\LeaveTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ManageLeaveTypes extends ListRecords
{
    protected static string $resource = LeaveTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(), // يمكنك إضافة أي إجراءات إضافية هنا مثل إضافة نوع إجازة جديد
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'name' => [
                'label' => 'Leave Type Name',
                'sortable' => true,
                'searchable' => true,
            ],
            'created_at' => [
                'label' => 'Created At',
                'sortable' => true,
                'format' => 'datetime',
            ],
        ];
    }
}
