<x-filament-panels::page>
    <div class="space-y-6">
        @php
            $data = $this->getConversionData();
        @endphp

        <div class="grid grid-cols-4 gap-4">
            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Total Leads</div>
                    <div class="text-3xl font-bold">{{ $data['totalLeads'] }}</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Converted</div>
                    <div class="text-3xl font-bold text-green-600">{{ $data['convertedLeads'] }}</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Conversion Rate</div>
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($data['conversionRate'], 1) }}%</div>
                </div>
            </x-filament::section>

            <x-filament::section>
                <div class="text-center">
                    <div class="text-sm text-gray-500">Avg Time to Convert</div>
                    <div class="text-3xl font-bold">{{ $data['avgTimeToConvert'] }} days</div>
                </div>
            </x-filament::section>
        </div>

        <x-filament::section>
            <x-slot name="heading">Conversion by Source</x-slot>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Source</th>
                            <th class="text-right py-2">Total Leads</th>
                            <th class="text-right py-2">Converted</th>
                            <th class="text-right py-2">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['conversionBySource'] as $source)
                        <tr class="border-b">
                            <td class="py-2">{{ ucwords(str_replace('_', ' ', $source->source)) }}</td>
                            <td class="text-right">{{ $source->total }}</td>
                            <td class="text-right text-green-600">{{ $source->converted }}</td>
                            <td class="text-right font-semibold">{{ number_format($source->conversion_rate, 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Lost Deal Reasons</x-slot>
            <div class="space-y-2">
                @foreach($data['lostReasons'] as $reason)
                <div class="flex justify-between items-center">
                    <span>{{ ucwords(str_replace('_', ' ', $reason->lost_reason)) }}</span>
                    <span class="font-semibold">{{ $reason->count }}</span>
                </div>
                @endforeach
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>