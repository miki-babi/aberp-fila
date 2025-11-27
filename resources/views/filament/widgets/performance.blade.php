<x-filament-widgets::widget>
    <!-- <x-filament::section> -->
        <x-slot name="heading">
            Sales Performance by User
        </x-slot>

        <div x-data="{ period: 'daily' }" class="space-y-4">
            {{-- Period Tabs --}}
            <div class="flex gap-2 border-b border-gray-200 dark:border-gray-700">
                <button 
                    @click="period = 'daily'; $wire.setPeriod('daily')"
                    :class="period === 'daily' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors"
                >
                    Daily (Last 7 Days)
                </button>
                <button 
                    @click="period = 'weekly'; $wire.setPeriod('weekly')"
                    :class="period === 'weekly' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors"
                >
                    Weekly (Last 4 Weeks)
                </button>
                <button 
                    @click="period = 'monthly'; $wire.setPeriod('monthly')"
                    :class="period === 'monthly' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="px-4 py-2 border-b-2 font-medium text-sm transition-colors"
                >
                    Monthly (Last 6 Months)
                </button>
            </div>

            {{-- Performance Data --}}
            <div class="overflow-x-auto">
                @php
                    $performanceData = $this->getPerformanceData();
                @endphp

                @if($performanceData->isEmpty())
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        No sales data available for this period.
                    </div>
                @else
                    @foreach($performanceData as $userName => $userSales)
                        <div class="mb-6 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                            <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">
                                {{ $userName }}
                            </h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-900">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Period
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Total Sales
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Total Quantity
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Total Revenue
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($userSales as $sale)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    @if($this->period === 'daily')
                                                        {{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}
                                                    @elseif($this->period === 'weekly')
                                                        Week {{ $sale->week }}, {{ $sale->year }}
                                                    @else
                                                        {{ \Carbon\Carbon::create($sale->year, $sale->month, 1)->format('F Y') }}
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                        {{ number_format($sale->total_sales) }} sales
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ number_format($sale->total_quantity) }} items
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">
                                                    ${{ number_format($sale->total_revenue, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        
                                        {{-- Summary Row --}}
                                        <tr class="bg-gray-100 dark:bg-gray-900 font-semibold">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                Total
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    {{ number_format($userSales->sum('total_sales')) }} sales
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ number_format($userSales->sum('total_quantity')) }} items
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">
                                                ${{ number_format($userSales->sum('total_revenue'), 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    <!-- </x-filament::section> -->
</x-filament-widgets::widget>

