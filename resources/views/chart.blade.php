<x-app-layout>
<x-slot name="header">
    <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
    <div>
        <label for="analysis" class="block text-xl font-semibold text-gray-800">Analysis Of</label>
        <select id="agent_filter" name="agent" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-800 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            <option value="all" {{ request('agent') == 'all' ? 'selected' : '' }}>All</option>
            @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ request('agent') == $agent->id ? 'selected' : '' }}>
                    {{ $agent->name }}
                </option>
            @endforeach
        </select>
    </div>
</x-slot>
    <div class="grid grid-cols-2 gap-4 px-6">
        <div id="issueTypeChart">{!! $issueTypeChart->container() !!}</div>
        <div id="dailyCountChart">{!! $dailyCountChart->container() !!}</div>
        <div id="monthlyCountChart">{!! $monthlyCountChart->container() !!}</div>
        <div id="calledClientsChart">{!! $calledClientsChart->container() !!}</div>
    </div>
        
    
<script>
    document.getElementById('agent_filter').addEventListener('change', function () {
        const agentId = this.value;
        window.location.href = `?agent=${agentId}`;
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script> 
    {!! $issueTypeChart->script() !!}
    {!! $dailyCountChart->script() !!}
    {!! $monthlyCountChart->script() !!}
    {!! $calledClientsChart->script() !!}

</x-app-layout>
