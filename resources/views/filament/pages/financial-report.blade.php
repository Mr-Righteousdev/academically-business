<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">
                Report Period
            </x-slot>
            
            <div class="grid grid-cols-3 gap-4">
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="date"
                        wire:model="startDate"
                    />
                </x-filament::input.wrapper>

                <x-filament::input.wrapper>
                    <x-filament::input
                        type="date"
                        wire:model="endDate"
                    />
                </x-filament::input.wrapper>

                <x-filament::button wire:click="generateReport">
                    Generate Report
                </x-filament::button>
            </div>
        </x-filament::section>

        @if($reportData)
        <div class="grid grid-cols-3 gap-4">
            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Total Revenue</div>
                    <div class="text-2xl font-bold text-green-600">
                        UGX {{ number_format($reportData['totalRevenue']) }}
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Total Expenses</div>
                    <div class="text-2xl font-bold text-red-600">
                        UGX {{ number_format($reportData['totalExpenses']) }}
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Net Profit</div>
                    <div class="text-2xl font-bold {{ $reportData['netProfit'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                        UGX {{ number_format($reportData['netProfit']) }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ number_format($reportData['profitMargin'], 1) }}% margin
                    </div>
                </div>
            </x-filament::section>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <x-filament::section>
                <x-slot name="heading">Revenue Breakdown</x-slot>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt>Cash Payments</dt>
                        <dd class="font-semibold">UGX {{ number_format($reportData['cashRevenue']) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Mobile Money</dt>
                        <dd class="font-semibold">UGX {{ number_format($reportData['mobileMoneyRevenue']) }}</dd>
                    </div>
                </dl>
            </x-filament::section>

            <x-filament::section>
                <x-slot name="heading">Expenses by Category</x-slot>
                <dl class="space-y-2">
                    @foreach($reportData['expensesByCategory'] as $expense)
                    <div class="flex justify-between">
                        <dt>{{ ucwords(str_replace('_', ' ', $expense->category)) }}</dt>
                        <dd class="font-semibold">UGX {{ number_format($expense->total) }}</dd>
                    </div>
                    @endforeach
                </dl>
            </x-filament::section>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Projects Completed</div>
                    <div class="text-3xl font-bold">{{ $reportData['projectsCompleted'] }}</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Projects Started</div>
                    <div class="text-3xl font-bold">{{ $reportData['projectsStarted'] }}</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Outstanding Balance</div>
                    <div class="text-lg font-bold text-yellow-600">
                        UGX {{ number_format($reportData['outstandingBalance']) }}
                    </div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Overdue Projects</div>
                    <div class="text-3xl font-bold text-red-600">{{ $reportData['overdueProjects'] }}</div>
                </div>
            </x-filament::section>
        </div>
        @endif
    </div>
</x-filament-panels::page>