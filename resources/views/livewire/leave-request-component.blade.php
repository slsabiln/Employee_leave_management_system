<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">طلب إجازة</h2>

    <!-- رسالة النجاح أو الخطأ -->
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <!-- نموذج طلب الإجازة -->
    <form wire:submit.prevent="submitLeaveRequest" class="space-y-4">
        <!-- حقل نوع الإجازة -->
        <div>
            <label for="leave_type" class="block text-sm font-medium text-gray-700">نوع الإجازة</label>
            <select wire:model="leave_type" id="leave_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="sick">إجازة مرضية</option>
                <option value="vacation">إجازة سنوية</option>
                <option value="personal">إجازة شخصية</option>
            </select>
            @error('leave_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- حقل تاريخ بداية الإجازة -->
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">تاريخ بداية الإجازة</label>
            <input wire:model="start_date" type="date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- حقل تاريخ نهاية الإجازة -->
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">تاريخ نهاية الإجازة</label>
            <input wire:model="end_date" type="date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- حقل سبب الإجازة -->
        <div>
            <label for="reason" class="block text-sm font-medium text-gray-700">سبب الإجازة</label>
            <textarea wire:model="reason" id="reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- زر إرسال الطلب -->
        <div class="mt-4">
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                إرسال طلب الإجازة
            </button>
        </div>
    </form>
</div>
